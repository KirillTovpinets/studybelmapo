import { Component, Input, OnInit } from '@angular/core';
import { PersonalDataService } from "../services/personalData.service";
import { Global } from "../global.class";

@Component({
	selector: 'prof-info',
	templateUrl: 'personalInfoTemplates/profInfo.component.html',
	styleUrls: ['../css/personalInfo.component.css'],
	providers: [PersonalDataService]
})

export class ProfInfoComponent{
	@Input('info') info: any = {};
	@Input('change') change: boolean = false;
	globalPrams: Global = new Global();

	private personal_faculties: any[] = [];
	private personal_cityzenships: any[] = [];
	private personal_regions: any[] = [];
	private personal_cities:any[] = [];
	private personal_establishments: any[] = [];
	private specialityDocArr: any[] = [];
	private specialityRetrArr: any[] = [];
	private specialityOtherArr: any[] = [];
	private qualificationMainArr: any[] = [];
	private qualificationAddArr: any[] = [];
	private qualificationOtherArr: any[] = [];

	constructor(private dataService: PersonalDataService){
		this.dataService.getData().then(data => {
			this.personal_faculties = data.json().facArr;
			this.personal_establishments = data.json().estArr;
			this.specialityDocArr = data.json().specialityDocArr;
			this.specialityRetrArr = data.json().specialityRetrArr;
			this.specialityOtherArr = data.json().specialityOtherArr;
			this.qualificationMainArr = data.json().qualificationMainArr;
			this.qualificationAddArr = data.json().qualificationAddArr;
			this.qualificationOtherArr = data.json().qualificationOtherArr;
		});
	}
}