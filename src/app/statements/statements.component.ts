import { Component, OnInit, TemplateRef, ViewChild } from '@angular/core';
import { CurrentCourcesListService } from '../FillData/services/getCurrentCourcesList.service';
import { MakeOrderService } from '../order/makeOrder.service';
import { BsDatepickerConfig } from "ngx-bootstrap/datepicker";
import { NotificationsService } from 'angular4-notify';
import { Global } from '../model/global.class';
import { BsModalService, BsModalRef } from 'ngx-bootstrap';
import { build$ } from 'protractor/built/element';
@Component({
  selector: 'app-statements',
  templateUrl: './statements.component.html',
  styleUrls: ['./statements.component.css'],
  styles:[`
		.table-striped>tbody>tr.selected,
		.table>tbody>tr.selected>td{
			background-color: #9368E9 !important;
			color:#fff;
		}
		.btn.selected{
			background:#888888;
			color:#fff;
		}
		table.legend span{
			display:block;
			width:20px;
			height:20px;
		}
		table.legend td{
			padding:5px;
		}
		span.danger{
			background-color: #f2dede;
		}
		span.success{
			background-color: #dff0d8;	
		}
	`],
  providers: [CurrentCourcesListService, MakeOrderService]

})
export class StatementsComponent implements OnInit {

  constructor(private courseList: CurrentCourcesListService,
              private makeOrderService: MakeOrderService,
              private notify: NotificationsService,
              private modal: BsModalService,) { }
  	@ViewChild('certificates') cert: TemplateRef<any>;
	@ViewChild('examlist') examlist: TemplateRef<any>;
	@ViewChild('studList') studList: TemplateRef<any>;

	bsValue: Date = new Date();
	globalParams: Global = new Global();
  data:any = {
    selectedCourses: [],
    prorector: "Т.В.Калининой",
    headmaster: "",
    exam_list_numer: "",
    examDate: undefined,
    exam_date: "",
	exam_form: 0,
	statementInfo: []
  };
  message: string = "";
  courses: any[] = [];
  filename: string = "Document";
  currentUser = JSON.parse(localStorage.getItem("currentUser"));
	bsConfig: Partial<BsDatepickerConfig> =  Object.assign({}, { containerClass: "theme-blue", locale: this.globalParams.locale, dateInputFormat: 'DD.MM.YYYY' });
	modalRef: BsModalRef;
	isLoaded: boolean = false;
	faculties: any[];
	statIsLoaded: boolean = false;
	educTypes: any[] = [];
	educForms: any[] = [];
	searchResult: any[] = [];
  ngOnInit() {
    this.courseList.get().then(res => {
		try{
			this.courses = res.json();
			var today = new Date();
			for (var i = 0; i < this.courses.length; i++) {
					var start = new Date(this.courses[i].Start);
					var finish = new Date(this.courses[i].Finish);
					
					if (start < today && finish < today) {
						this.courses[i].class=1;
					}else if(start < today && finish > today){
						this.courses[i].class=2;
					}else if(start > today && finish > today){
						this.courses[i].class=3;
					}
				}
			this.isLoaded = true;
		}catch(e){
			console.log(e);
			console.log(res._body);
		}
	})
  }
  GetCoursesList(value:Date, flag:number){
		if (flag === 0) {
			this.data.dateFrom = value.toISOString().slice(0, 10);
		}else{
			this.data.dateTo = value.toISOString().slice(0, 10);
		}
		this.makeOrderService.getList(this.data).then(data => {
			try{
				this.courses = data.json();
				this.message = "";
			}
			catch(e){
				console.log(data._body);
				this.courses = [];
				this.message = "Нет курсов удовлетворяющих запросу";
			}
		});
  }
  EnterAction(flag:number):void{
		if (this.data.selectedCourses.length === 0) {
			this.notify.addError("Выберите курс");
			return;
		}
		this.data.type = flag;
		let hasEmptyCourse = false;
		switch (flag) {
			case 2:{
        		this.modalRef = this.modal.show(this.cert, {class: 'modal-md'});
				break;
			}
			case 3:{
        		this.modalRef = this.modal.show(this.examlist, {class: 'modal-md'});
				break;
			}
			case 4:{
				this.BuildOrder(4);
				break;
			}
			case 8:{
				this.modalRef = this.modal.show(this.studList, {class: 'modal-md'});
				break;
			}
		}
	}
	selectCourse(course:any): void{
		if (this.data.selectedCourses.indexOf(course) !== -1) {
			var index = this.data.selectedCourses.indexOf(course);
			this.data.selectedCourses.splice(index, 1);
		}else{
			this.data.selectedCourses.push(course);
		}
	}
	catchSelected(archSelected: any[]){
		this.data.selectedCourses = this.data.selectedCourses.concat(archSelected);
  }
  Search($event){
	  if($event.target.value == ""){
		this.searchResult = [];
		return;
	  }

	  this.searchResult = this.courses.filter((el, index, arr) => {
		  if(el.Number.indexOf($event.target.value) == 0){
			  return el;
		  }
	  })
  }
  BuildOrder(flag?:number): void{
	  	
		if (flag !== undefined) {
			this.data.type = flag;
		}
		if (this.data.selectedCourses.length === 0) {
			this.notify.addError("Выберите курс");
			return;
		}else if(this.data.type == undefined){
			this.notify.addError("Выберите приказ");
			return;
		}
		if (this.data.examDate != undefined) {
			this.data.exam_date = this.data.examDate.getDate() + "." + this.data.examDate.getMonth() + "." + this.data.examDate.getFullYear();
		}
		this.makeOrderService.create(this.data).then(data => {
            var blob = new Blob([data._body], {type: 'application/vnd.msword'});
            var objectUrl = URL.createObjectURL(blob);   
            var filename = this.filename + ".doc";
            var a = document.createElement("a");
            a.href = objectUrl;
            a["download"] = filename;

            var e = document.createEvent("MouseEvents");
            e.initMouseEvent("click", true, false,
			    document.defaultView, 0, 0, 0, 0, 0,
			    false, false, false, false, 0, null);
			a.dispatchEvent(e);
        });
	}
	statementInfo(field:string){
		if(this.data.statementInfo.indexOf(field) !== -1){
			let index = this.data.statementInfo.indexOf(field);
			this.data.statementInfo.splice(index, 1);
		}else{
			this.data.statementInfo.push(field);
		}
	}
}
