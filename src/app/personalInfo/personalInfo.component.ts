import { Component, Input, OnInit } from '@angular/core';
import { BsModalRef } from 'ngx-bootstrap/modal/bs-modal-ref.service';
import { TableListCopmonent } from "../tableList/tableList.component";
import { Person } from "../model/person.class";
import { BsModalService } from "ngx-bootstrap/modal";
import { SaveChangesService } from './saveChanges.service';
import {NotificationsService} from 'angular4-notify';
@Component({
	selector: 'personal-info',
	templateUrl: './personalInfo.component.html',
	styleUrls: ['./personalInfo.component.css'],
	providers: [BsModalService, SaveChangesService]
})

export class PersonalInfoComponent{
	title: string = "";
	person: Person = new Person();
	service: BsModalService;
	level: number = 1;
	canChange: boolean = false;
	change: boolean = false;
	originalData:any = {};
	constructor(public PIModal: BsModalRef,
				private saveChanges: SaveChangesService,
				private notify: NotificationsService ){
	}
	Change(){
		this.change = true;
	}
	Cansel(){
		this.change = false;
	}
	SaveChanges(person: any){
		this.saveChanges.save(person, this.originalData).subscribe(data => {
			this.change = false;
			this.originalData = {...this.person}
			this.notify.addInfo("Изменения сохранены");
			localStorage.removeItem("person-" + person.general.id);
		});
	}
}