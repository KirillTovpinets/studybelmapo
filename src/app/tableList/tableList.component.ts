import { Component, Input, Output, EventEmitter, OnInit, Directive, ViewChild, TemplateRef } from "@angular/core";
import { ShowPersonInfoService } from "../personalInfo/showPersonalInfo.service";
import { PersonalInfoService } from '../personalInfo/personalInfo.service';
import { BsModalService, BsModalRef } from "ngx-bootstrap/modal";
import { PersonalDataService } from '../personalInfo/personalData.service';
import { Certificate } from '../model/certificate.class';
import { Global } from '../model/global.class';
import { NotificationsService } from 'angular4-notify';
import { StudListService } from '../studList/stud-list.service';
@Component({
	selector: "table-list",
	templateUrl: "./tableList.component.html",
	providers:[ShowPersonInfoService,PersonalInfoService,BsModalService, PersonalDataService],
	styles:[`
		.table{
			background-color:transparent !important;
			margin-top:20px;
		}
		tbody tr:not(.button):hover{
			background-color:#C2FAFA;
		}
		tr.button:hover{
			background:transparent !important;
		}
		.no-hover:hover{
			background:transparent !important;
		}
		th{
			text-align:center;
		}
		.pe-7s-piggy{
			color:#398439;
			font-size:20px;
		}
		`]
})

export class TableListCopmonent implements OnInit{
	@Input('course') course: any;
	@Output() onChanges = new EventEmitter<boolean>();
	@ViewChild("DeductInfo") deduct: TemplateRef<any>;
	@ViewChild("sure") modalTpl: TemplateRef<any>;

	data: any;
	selectedPerson:any = {};
	constructor(private showInfo: ShowPersonInfoService,
				private deductData: PersonalDataService,
				private modal: BsModalService,
				private notify: NotificationsService,
				private students: StudListService){}

	private sure: BsModalRef;
	private deductInfo: BsModalRef;
	marks: any[] = [];
	certificate: Certificate;
	global: Global = new Global();
	totalNumber: number = 0;
	currentUser = JSON.parse(localStorage.getItem('currentUser'));
	ngOnInit(){
		this.students.currentTotal.subscribe(total => this.totalNumber = total);
	}
	Deduct(person:any, $event:any){
		$event.stopPropagation();
		this.selectedPerson = person;
		this.sure = this.modal.show(this.modalTpl, {class: "modal-sm"});
	}

	Yes(){
		this.sure.hide();
		this.certificate = new Certificate();
		this.deductData.getMarkList().then(response => this.marks = response.json());
		this.deductInfo = this.modal.show(this.deduct, {class: "modal-md"});
	}

	No(){
		this.modal.hide(1);
	}

	DeductConfirm(){
		this.certificate.courseId = this.course.id;
		this.certificate.arrivalId = this.selectedPerson.arrivalId;
		this.certificate.DateGet = this.certificate.DateGetDate.toISOString().slice(0,10);
		this.course.StudList.splice(this.course.StudList.indexOf(this.selectedPerson), 1);
		this.totalNumber += 1;
		// this.students.changeTotal(this.totalNumber);
		this.deductData.deduct(this.certificate).then(res => {
			console.log(res._body);
			this.notify.addSuccess("Слушатель отчислен")
			this.onChanges.emit(this.course);
		});
		this.modal.hide(1);
		this.modal.hide(1);
	}
	Cansel(){
		this.modal.hide(1);
		this.modal.hide(1);
	}
}


