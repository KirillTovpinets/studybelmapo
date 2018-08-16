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

	public personal_faculty: any[] = [];
	public personal_cityzenships: any[] = [];
	public personal_regions: any[] = [];
	public personal_cities:any[] = [];
	public personal_establishment: any[] = [];
	public speciality_doct: any[] = [];
	public speciality_retraining: any[] = [];
	public speciality_other: any[] = [];
	public qualification_main: any[] = [];
	public qualification_add: any[] = [];
	public qualification_other: any[] = [];
	public autoCopleteError: boolean = false;
	public bsValueDiploma: Date = new Date();
	constructor(public dataService: PersonalDataService){
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