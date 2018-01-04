import { Component, Input, OnInit } from '@angular/core';
import { Global } from "../global.class";
import { PersonalDataService } from "../services/personalData.service";

@Component({
	selector: 'private-info',
	templateUrl: 'personalInfoTemplates/private.component.html',
	styleUrls: ['../css/personalInfo.component.css'],
	providers: [PersonalDataService]
})

export class PrivateInfoComponent{
	@Input('info') info: any = {};
	@Input('change') change: boolean = false;
	globalPrams: Global = new Global();

	private personal_cityzenships: any[] = [];
	private personal_regions: any[] = [];
	private personal_cities:any[] = [];

	constructor(private dataService: PersonalDataService){
		this.dataService.getData().then(data => {
			this.personal_cityzenships = data.json().residArr;
			this.personal_regions = data.json().regArr;
			this.personal_cities = data.json().citiesArr;
			for(let country of this.personal_cityzenships){
				if (country.id == this.info.country) {
					this.info.contry = country.value;
					break;
				}
			}
		});
	}
}