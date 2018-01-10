import { Component, Input, OnInit, Directive, ViewChild, TemplateRef } from "@angular/core";
import { ShowPersonInfoService } from "./personalInfo/showPersonalInfo.service";
import { PersonalInfoService } from './personalInfo.service';
import { BsModalService, BsModalRef } from "ngx-bootstrap/modal";
import { PersonalDataService } from './services/personalData.service';
import { Certificate } from './model/certificate.class';
import { Global } from './global.class';
import {NotificationsService} from 'angular4-notify';
@Component({
	selector: "table-list",
	templateUrl: "./templates/tableList.component.html",
	providers:[ShowPersonInfoService,PersonalInfoService,BsModalService, PersonalDataService],
	styles:[`
		.table{
			background-color:transparent !important;
			margin-top:20px;
		}
		tbody tr:not(.button):hover{
			background-color:#ffbc67;
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
	`]
})

export class TableListCopmonent{
	@Input('course') course: any;
	@ViewChild("DeductInfo") deduct: TemplateRef<any>;
	@ViewChild("sure") modalTpl: TemplateRef<any>;
	data: any;
	selectedPerson:any = {};
	constructor(private showInfo: ShowPersonInfoService,
				private deductData: PersonalDataService,
				private modal: BsModalService,
				private notify: NotificationsService){}

	private sure: BsModalRef;
	private deductInfo: BsModalRef;
	marks: any[] = [];
	certificate: Certificate;
	global: Global = new Global();
	currentUser = JSON.parse(localStorage.getItem('currentUser'));
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
		this.deductData.deduct(this.certificate).then(res => this.notify.addInfo("Слушатель отчислен"));
		this.modal.hide(1);
		this.modal.hide(1);
	}
	Cansel(){
		this.modal.hide(1);
		this.modal.hide(1);
	}
}


