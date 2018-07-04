import { Component, Input, Output, OnInit, EventEmitter } from '@angular/core';
import { PersonalDataService } from "../personalData.service";
import { NotificationsService } from 'angular4-notify';
import { PersonService } from '../../addStudent/savePerson.service';

@Component({
	selector: 'general-info',
	templateUrl: './general.component.html',
	styleUrls: ['../personalInfo.component.css'],
	providers: [PersonalDataService, NotificationsService, PersonService]
})

export class GeneralInfoComponent{
	@Input('info') info: any = {};
	@Input('change') change: boolean = false;
	@Output() canSave = new EventEmitter<number>();

	private personal_appointments: any[] = [];
	private personal_organizations: any[] = [];
	private personal_departments: any[] = [];
	private outputData:any = {};
	private autoCopleteError: boolean = false;
	newValue:string = "";

	constructor(private dataService: PersonalDataService,
				private notify: NotificationsService,
				private saveService: PersonService,){

		this.personal_appointments = JSON.parse(localStorage.getItem("appArr"));
		this.personal_organizations = JSON.parse(localStorage.getItem("orgArr"));
		this.personal_departments = JSON.parse(localStorage.getItem("depArr"));

		if(this.personal_appointments == null || this.personal_organizations || this.personal_departments){
			this.dataService.getData().then(data => {
				this.personal_appointments = data.json().appArr;
				this.personal_organizations = data.json().orgArr;
				this.personal_departments = data.json().depArr;
				localStorage.setItem("appArr", JSON.stringify(this.personal_appointments));
				localStorage.setItem("orgArr", JSON.stringify(this.personal_organizations));
				localStorage.setItem("depArr", JSON.stringify(this.personal_departments));
			});
		}
	}
	saveNewParameter(value:string, table:string, array: any[]){
		this.outputData.value = value;
		this.outputData.table = table;

		array.forEach(element => {
			if(value == element.value){
				this.notify.addWarning("Этот вариант уже существует");
				return;
			}
		});

		this.saveService.saveParameter(this.outputData).then(data => {
			array.push(data.json());
			console.log(data.json());

			switch (table){
				case "personal_appointment":{
					this.info.appointment = data.json();
					break;
				}
				case "personal_organizations":{
					this.info.organization = data.json();
					break;
				}
				case "personal_department":{
					this.info.department = data.json();
					break;
				}
			}
			this.newValue = "";
		})
	}
	checkValue($event){
		if(typeof($event) === 'object'){
			this.autoCopleteError = false;
			this.canSave.emit(1);
		}else{
			this.autoCopleteError = true;
			this.canSave.emit(0);
		}
	}
}