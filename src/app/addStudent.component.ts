import { Component, OnInit } from '@angular/core';
import { PersonalDataService } from "./services/personalData.service";
import { BsDatepickerConfig } from "ngx-bootstrap/datepicker";
import { listLocales } from 'ngx-bootstrap/bs-moment';
import { FormControl } from "@angular/forms";
import { MatAutocompleteModule } from '@angular/material/autocomplete';

import  { Person } from "./model/person.class";

@Component({
	templateUrl: "templates/addStudent.component.html",
	providers: [PersonalDataService]
})

export class AddStudentComponent implements OnInit{
	private faculties: any[] = [];
	private educTypes: any[] = [];
	private educForms: any[] = [];
	private residance: any[] = [];
	public newPerson:Person = new Person();

	bsValue: Date = new Date();
	minDate = new Date(1970, 1, 1);
  	maxDate = new Date();
  	locale = "ru";
  	bsConfig: Partial<BsDatepickerConfig> =  Object.assign({}, { containerClass: "theme-blue", locale: this.locale });

	constructor(private dataService: PersonalDataService){}
	ngOnInit():void{
		this.dataService.getData().then(data => {
			for (let faculty of data.json().facBel) {
				this.faculties.push(faculty);
			}
			for (let type of data.json().educTypeBel) {
				this.educTypes.push(type);
			}
			for (let form of data.json().formBel) {
				this.educForms.push(form);
			}
			for (let resid of data.json().belmapo_residence) {
				this.residance.push(resid);
			}
		});
	}
}