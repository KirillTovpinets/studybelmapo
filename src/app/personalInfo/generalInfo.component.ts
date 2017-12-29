import { Component, Input, OnInit } from '@angular/core';
import { PersonalDataService } from "../services/personalData.service";

@Component({
	selector: 'general-info',
	templateUrl: 'personalInfoTemplates/general.component.html',
	styleUrls: ['../css/personalInfo.component.css'],
	providers: [PersonalDataService]
})

export class GeneralInfoComponent{
	@Input('info') info: any = {};
	@Input('change') change: boolean = false;

	private personal_appointments: any[] = [];
	private personal_organizations: any[] = [];
	private personal_departments: any[] = [];

	constructor(private dataService: PersonalDataService){
		this.dataService.getData().then(data => {
			this.personal_appointments = data.json().appArr;
			this.personal_organizations = data.json().orgArr;
			this.personal_departments = data.json().depArr;
		});
	}
}