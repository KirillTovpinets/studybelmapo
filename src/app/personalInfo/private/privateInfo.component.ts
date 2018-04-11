import { Component, Input, OnInit } from '@angular/core';
import { Global } from "../../model/global.class";
import { PersonalDataService } from "../personalData.service";

@Component({
	selector: 'private-info',
	templateUrl: './private.component.html',
	styleUrls: ['../personalInfo.component.css'],
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

		this.personal_cityzenships = JSON.parse(localStorage.getItem("residArr"));
		this.personal_regions = JSON.parse(localStorage.getItem("regArr"));
		this.personal_cities = JSON.parse(localStorage.getItem("citiesArr"));

		if(this.personal_cityzenships == null ||
			this.personal_regions == null ||
			this.personal_cities == null){
			this.dataService.getData().then(data => {
				this.personal_cityzenships = data.json().residArr;
				this.personal_regions = data.json().regArr;
				this.personal_cities = data.json().citiesArr;

				localStorage.setItem("residArr", JSON.stringify(this.personal_cityzenships));
				localStorage.setItem("regArr", JSON.stringify(this.personal_regions));
				localStorage.setItem("citiesArr", JSON.stringify(this.personal_cities));
				for(let country of this.personal_cityzenships){
					if (country.id == this.info.country) {
						this.info.contry = country.value;
						break;
					}
				}
			});
		}
	}
}