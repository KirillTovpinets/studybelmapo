import { Component, Input, OnInit, Directive, ViewChild, TemplateRef } from "@angular/core";
import { ShowPersonInfoService } from "./personalInfo/showPersonalInfo.service";
import { PersonalInfoService } from './personalInfo.service';
import { BsModalService, BsModalRef } from "ngx-bootstrap/modal";
@Component({
	selector: "table-list",
	templateUrl: "./templates/tableList.component.html",
	providers:[ShowPersonInfoService,PersonalInfoService,BsModalService]
})

export class TableListCopmonent{
	@Input('course') course: any;
	@ViewChild("sure") modalTpl: TemplateRef<any>
	data: any;
	selectedPerson:any = {};
	constructor(private showInfo: ShowPersonInfoService,
				private modal: BsModalService){}

	private sure: BsModalRef;
	Deduct(person:any, $event:any){
		$event.stopPropagation();
		this.selectedPerson = person;
		this.sure = this.modal.show(this.modalTpl, {class: "modal-sm"});
	}

	Yes(){
		this.course.StudList.splice(this.course.StudList.indexOf(this.selectedPerson), 1);
		this.modal.hide(1);
	}

	No(){
		this.modal.hide(1);
	}
}


