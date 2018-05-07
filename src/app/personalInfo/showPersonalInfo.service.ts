import { Injectable } from '@angular/core';
import { PersonalInfoService } from './personalInfo.service';
import { BsModalService } from "ngx-bootstrap/modal";
import { BsModalRef } from 'ngx-bootstrap/modal/bs-modal-ref.service';
import { PersonalInfoComponent } from './personalInfo.component'; 
import { Person } from "../model/person.class";
import {NotificationsService} from 'angular4-notify';
@Injectable()
export class ShowPersonInfoService {
	
	constructor(protected personalInfo:PersonalInfoService,
				protected PIService: BsModalService,
				private notify: NotificationsService){}
	PersonalInfoModal: BsModalRef;
	ShowPersonalInfo(person:any, level?:number, canChange?:boolean): void{
		var id:string = "";
		if (person.general !== null && person.general !== undefined) {
			id = person.general.id;
		}else{
			id = person.id;
		}
		if (localStorage.getItem("person-" + id) !== null) {
			var personStorage = JSON.parse(localStorage.getItem("person-" + id));
			var person = {...personStorage};
			this.showModal(person, level, canChange);
		}else{
			this.personalInfo.getInfo(id).then(data => {
				console.log(data._body);
				try{
					let personInfo = data.json();
					localStorage.setItem("person-" + id, JSON.stringify(personInfo));
					var person = {...personInfo};
					this.showModal(person, level, canChange);
					
				}catch(e){
					this.notify.addError("Произошла ошибка. Обратитесь к администратору");
					console.log(e);
					console.log(data._body);
				}
			});
		}
	}

	showModal(person:any, level?:number, canChange?:boolean){
		var copy = new Person();
		for(var key in person){
			for(var ikey in person[key]){
				copy[key][ikey] = person[key][ikey];
			}
		}
		person.personal.birthdayDate = new Date(person.personal.birthday);
		copy.personal.birthdayDate = new Date(person.personal.birthday);

		if (person.profesional !== null && person.profesional !== undefined) {
			person.profesional.diploma_startDate = new Date(person.profesional.diploma_start);
			copy.profesional.diploma_startDate = new Date(person.profesional.diploma_start);
		}

		if (person.profesional != undefined && person.profesional.addCategory_date !== undefined ) {
			person.profesional.addCategoryDate = new Date(person.profesional.addCategory_date);
			copy.profesional.addCategoryDate = new Date(person.profesional.addCategory_date);

			person.profesional.retrainings.forEach(el => {
				el.diploma_start = new Date(el.diploma_start);
			})
		}
		if (person.profesional != undefined && person.profesional.mainCategory_date !== undefined ) {
			person.profesional.mainCategoryDate = new Date(person.profesional.mainCategory_date);
			copy.profesional.mainCategoryDate = new Date(person.profesional.mainCategory_date);
		}
		if (person.personal.pasport_date !== undefined) {
			person.personal.pasportDate = new Date(person.personal.pasport_date);
			copy.personal.pasportDate = new Date(person.personal.pasport_date);
		}

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
	}
}