import { Component, Input, OnInit, Directive } from "@angular/core";
import { BsModalService } from "ngx-bootstrap/modal";
import { BsModalRef } from 'ngx-bootstrap/modal/modal-options.class';
import { PersonalInfoService } from './personalInfo.service';

import { PersonalInfoComponent } from './personalInfo.component'; 
@Component({
	selector: "table-list",
	templateUrl: "./templates/tableList.component.html",
	providers: [PersonalInfoService]
})

export class TableListCopmonent{
	@Input('course') course: any;

	PersonalInfoModal: BsModalRef;
	data: any;
	constructor(private PIService: BsModalService,
				private personalInfo: PersonalInfoService){}
	ShowPersonalInfo(person:any): void{
		this.personalInfo.getInfo(person.id).then(data => {
			this.PersonalInfoModal = this.PIService.show(PersonalInfoComponent, {class: 'modal-lg'});
			this.PersonalInfoModal.content.title = "Профиль врача";
			this.PersonalInfoModal.content.person = data.json();
		});
	}
}


