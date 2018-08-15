import { Component, Input, OnInit, Output, EventEmitter } from '@angular/core';
import { PersonalDataService } from "../personalData.service";
import { Global } from "../../model/global.class";

@Component({
	selector: 'prof-info',
	templateUrl: './profInfo.component.html',
	styleUrls: ['../personalInfo.component.css'],
	providers: [PersonalDataService]
})

export class ProfInfoComponent{
	@Input('info') info: any = {};
	@Input('change') change: boolean = false;
	@Output() canSave = new EventEmitter<number>();
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
	private autoCopleteError: boolean = false;

	dataKeys: string[] = [
		"facArr",
		"estArr",
		"specialityDocArr",
		"specialityRetrArr",
		"specialityOtherArr",
		"qualificationMainArr",
		"qualificationAddArr",
		"qualificationOtherArr"
  	];
	constructor(private dataService: PersonalDataService){
		let fields = ["personal_faculty", "personal_establishment", "speciality_doct", "speciality_retraining", "speciality_other", "qualification_main", "qualification_add", "qualification_other"];
		this.dataService.getData(fields).then(data => {
			try{
				let response = data.json();
				fields.forEach(e => this[e] = response[e]);
			}catch(e){
				console.log(e);
				console.log(data._body)
			}
			
			
			
			
			
			
			
		});
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