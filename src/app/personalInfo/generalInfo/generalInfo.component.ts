import { Component, Input, OnInit } from '@angular/core';
import { PersonalDataService } from "../personalData.service";

@Component({
	selector: 'general-info',
	templateUrl: './general.component.html',
	styleUrls: ['../personalInfo.component.css'],
	providers: [PersonalDataService]
})

export class GeneralInfoComponent{
	@Input('info') info: any = {};
	@Input('change') change: boolean = false;

	private personal_appointments: any[] = [];
	private personal_organizations: any[] = [];
	private personal_departments: any[] = [];

	constructor(private dataService: PersonalDataService){

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
}