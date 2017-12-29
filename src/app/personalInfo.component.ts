import { Component, Input, OnInit } from '@angular/core';
import { BsModalRef } from "ngx-bootstrap/modal/modal-options.class"
import { TableListCopmonent } from "./tableList.component";
import { Person } from "./model/person.class";
import { BsModalService } from "ngx-bootstrap/modal";
import { SaveChangesService } from './personalInfo/services/saveChanges.service';
@Component({
	selector: 'personal-info',
	templateUrl: 'templates/personalInfo.component.html',
	styleUrls: ['css/personalInfo.component.css'],
	providers: [BsModalService, SaveChangesService]
})

export class PersonalInfoComponent{
	title: string = "";
	person: Person = new Person();
	service: BsModalService;
	level: number = 1;
	canChange: boolean = false;
	change: boolean = false;
	originalData:Person = new Person();
	constructor(public PIModal: BsModalRef,
				private saveChanges: SaveChangesService ){
	}
	Change(){
		this.change = true;
	}
	Cansel(){
		this.change = false;
	}
	SaveChanges(person: Person){
		this.saveChanges.save(person, this.originalData).subscribe(data => console.log(data._body));
	}
}