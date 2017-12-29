import { Injectable } from '@angular/core';
import { PersonalInfoService } from '../personalInfo.service';
import { BsModalService } from "ngx-bootstrap/modal";
import { BsModalRef } from 'ngx-bootstrap/modal/modal-options.class';
import { PersonalInfoComponent } from '../personalInfo.component'; 
import { Person } from "../model/person.class";

@Injectable()
export class ShowPersonInfoService {
	
	constructor(protected personalInfo:PersonalInfoService,
				protected PIService: BsModalService){}
	PersonalInfoModal: BsModalRef;
	ShowPersonalInfo(person:any, level?:number, canChange?:boolean): void{
		var id:string = "";
		if (person.general !== undefined) {
			id = person.general.id;
		}else{
			id = person.id;
		}
		this.personalInfo.getInfo(id).then(data => {
			var person = Object.assign(new Person(), data.json());
			var copy = Object.assign(new Person(), data.json());
			person.personal.birthdayDate = new Date(person.personal.birthday);
			person.profesional.diploma_startDate = new Date(person.profesional.diploma_start);
			this.PersonalInfoModal = this.PIService.show(PersonalInfoComponent, {class: 'modal-lg'});
			this.PersonalInfoModal.content.title = "Профиль врача (" + person.general.surname + " " + person.general.name + " " + person.general.patername + ")";
			this.PersonalInfoModal.content.person = person;
			this.PersonalInfoModal.content.originalData = copy;
			this.PersonalInfoModal.content.service = this.PIService;
			if (level !== undefined) {
				this.PersonalInfoModal.content.level = level;
			}
			if (canChange !== undefined) {
				this.PersonalInfoModal.content.canChange = canChange;
			}
		});
	}
}