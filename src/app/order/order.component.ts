import { Component, OnInit, ViewChild, TemplateRef } from "@angular/core";
import { BsDatepickerConfig } from "ngx-bootstrap/datepicker";
import { BsModalService, BsModalRef } from 'ngx-bootstrap';
import { MakeOrderService } from "./makeOrder.service";
import { Http } from "@angular/http";
import { Global } from '../model/global.class';
import "rxjs/add/operator/toPromise";
import {NotificationsService} from 'angular4-notify';
import { CurrentCourcesListService } from '../FillData/services/getCurrentCourcesList.service';
import { InfoService } from "../studList/studList.service";
import { PersonalDataService } from "../personalInfo/personalData.service";
@Component({
	templateUrl: './order.component.html',
	providers: [MakeOrderService, CurrentCourcesListService, BsModalService, InfoService, PersonalDataService],
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
		.course-list, .selected-courses{
			height:250px;
			overflow-y: scroll;
		}
		.course-list .course{
			width:65px;
			text-align:center;
		}
		.course{
			padding:5px 20px;
			border: 1px solid #ccc;
			margin-bottom: 5px;
			margin-right:5px;
			float:left;
			border-radius: 5px;
		}
		.selected-courses .course{
			width:100px;
		}
		.course-list .course:hover{
			background:#ffbc67;
			border-color: #ffbc15;
			cursor:pointer;
		}
		.alert-info{
			color: #fff;
		}
	`]
})

export class OrderComponent implements OnInit{
	@ViewChild('certificates') cert: TemplateRef<any>;
	@ViewChild('examlist') examlist: TemplateRef<any>;
	bsValue: Date = new Date();
	globalParams: Global = new Global();
  	data:any = {
  		selectedCourses: [],
  		prorector: "Т.В.Калининой",
  		headmaster: "",
  		exam_list_numer: "",
  		examDate: undefined,
  		exam_date: "",
  		exam_form: 0
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
	searchCourses:any[] = [];
	constructor(private makeOrderService: MakeOrderService,
				private http: Http,
				private info: InfoService,
				private notify: NotificationsService,
				private params: PersonalDataService,
				private modal: BsModalService,
				private courseList: CurrentCourcesListService){}
	ngOnInit(){
		this.courseList.get().then(data => { this.courses = data.json()})
	}
	EnterAction(flag:number):void{
		if (this.data.selectedCourses.length === 0) {
			this.notify.addError("Виберите курс");
			return;
		}
		this.data.type = flag;
		let hasEmptyCourse = false;
		switch (flag) {
			case 2:{
				this.data.selectedCourses.forEach((element, index, arr) => {
					if(element.countEntered == 0){
						hasEmptyCourse = true;
						this.notify.addError(`Курс "${element.name}" не имеет зачисленных слушателей`);
					}
				})
				if(!hasEmptyCourse){
					this.modalRef = this.modal.show(this.cert, {class: 'modal-md'});
				}
				break;
			}
			case 3:{
				this.data.selectedCourses.forEach((element, index, arr) => {
					if(element.countEntered == 0){
						hasEmptyCourse = true;
						this.notify.addError(`Курс ${element.name} не имеет зачисленных слушателей`);
					}
				})
				if(!hasEmptyCourse){
					this.modalRef = this.modal.show(this.examlist, {class: 'modal-md'});
				}
				break;
			}
		}
	}
	BuildOrder(flag?:number): void{
		if (flag !== undefined) {
			this.data.type = flag;
		}
		if (this.data.selectedCourses.length === 0) {
			this.notify.addError("Виберите курс");
			return;
		}else if(this.data.type == undefined){
			this.notify.addError("Виберите приказ");
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
	selectCourse(course:any): void{
		this.data.selectedCourses.push(course);
		var index = this.courses.indexOf(course);
		this.courses.splice(index, 1);
	}
	unselectCourse(course:any){
		var index = this.data.selectedCourses.indexOf(course);
		this.data.selectedCourses.splice(index, 1);
	}
	catchSelected(archSelected: any[]){
		this.data.selectedCourses = this.data.selectedCourses.concat(archSelected);
	}
	search($event){
		if($event.target.value == ""){
			this.searchCourses = [];
			return;
		}
		this.searchCourses = this.courses.filter((value, index, array) => {
			if(value.Number.indexOf($event.target.value) === 0 ){
				return value;
			}
		})
	}
}