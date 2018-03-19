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
		input[disabled]{
			background:none;
			border:none;
			text-align: center;
		}
		`]
})

export class TableListCopmonent implements OnInit{
	@Input('course') course: any;
	@Input('disableEnter') disableEnter: boolean = false;
	@Output() onChanges = new EventEmitter<boolean>();
	@ViewChild("DeductInfo") deduct: TemplateRef<any>;
	@ViewChild("DeductBeforeInfo") deductBefore: TemplateRef<any>;
	@ViewChild("sure") modalTpl: TemplateRef<any>;
	@ViewChild("sureBeforeEnd") modalBeforeTpl: TemplateRef<any>;

	data: any;
	selectedPerson:any = {};
	constructor(private showInfo: ShowPersonInfoService,
				private deductData: PersonalDataService,
				private modal: BsModalService,
				private notify: NotificationsService,
				private students: StudListService){}

	private sure: BsModalRef;
	private deductInfo: BsModalRef;

	private sureBefore: BsModalRef;
	private deductBeforeInfo: BsModalRef;

	marks: any[] = [];
	certificate: Certificate;
	global: Global = new Global();
	totalNumber: number = 0;
	currentUser = JSON.parse(localStorage.getItem('currentUser'));
	deductinfo:any = {};
	ngOnInit(){
		this.students.currentTotal.subscribe(total => this.totalNumber = total);
	}
	Deduct(person:any, $event:any){
		$event.stopPropagation();
		if (person.DocNumber.length === 0) {
			this.notify.addError("Отсутствует номер документа");
			return;
		}
		this.selectedPerson = person;
		this.sure = this.modal.show(this.modalTpl, {class: "modal-sm"});
	}

	DeductBeforeEnd(person, $event){
		$event.stopPropagation();
		this.selectedPerson = person;
		this.sureBefore = this.modal.show(this.modalBeforeTpl, {class: "modal-sm"});
	}
	Yes(){
		this.sure.hide();
		this.certificate = new Certificate();
		this.deductData.getMarkList().then(response => this.marks = response.json());
		this.deductInfo = this.modal.show(this.deduct, {class: "modal-md"});
	}

	YesBefore(){
		this.sureBefore.hide();
		this.deductBeforeInfo = this.modal.show(this.deductBefore, {class: "modal-md"});
	}

	No(){
		this.modal.hide(1);
	}

	DeductConfirm(){
		this.certificate.courseId = this.course.id;
		this.certificate.docNumber = this.selectedPerson.DocNumber;
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

	DeductBeforeConfirm(){
		this.deductinfo.arrivalId = this.selectedPerson.arrivalId;
		this.deductinfo.DateGet = this.deductinfo.DateGetDate.toISOString().slice(0,10);
		this.course.StudList.splice(this.course.StudList.indexOf(this.selectedPerson), 1);
		this.totalNumber += 1;
		// this.students.changeTotal(this.totalNumber);
		this.deductData.deductBefore(this.deductinfo).then(res => {
			this.notify.addSuccess("Слушатель отчислен досрочно")
			this.onChanges.emit(this.course);
		});
		this.modal.hide(1);
		this.modal.hide(1);
	}
	Cansel($event){
		$event.preventPropaganion();
		this.modal.hide(1);
		this.modal.hide(1);
	}
	PreventParentEvent($event){
		$event.stopPropagation();
	}

	StartTyping($event, person){
		if ($event.target.value !== "") {
			person.hasChanges = true;
		}else{
			person.hasChanges = false;
		}
	}
	SaveChanges($event, person){
		$event.stopPropagation();
		this.students.saveChanges(person).subscribe(res => {
			this.notify.addSuccess(res._body)
			person.change = false;
			person.hasChanges = false;
		})
	}
	EditAction($event, person){
		$event.stopPropagation();
		person.change = person.change ? false : true;
		if (person.change) {
			person.temp = person.DocNumber;
		}
	}
	CancelEdit($event, person){
		$event.stopPropagation();
		person.DocNumber = person.temp;
		person.change = false;
		person.hasChanges = false;
	}

	DeleteRow(person, $event){
		$event.stopPropagation();
		this.students.deleteRow(person).subscribe(res => {
			this.course.StudList.splice(this.course.StudList.indexOf(person), 1);
			this.notify.addSuccess(res._body);
		})
	}
}


