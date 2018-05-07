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
	createMaskHome($event){
		if ($event.key == "Backspace") {
			return;
		}
		if (this.info.tel_number_home[this.info.tel_number_home.length - 1] == ')' ||
			this.info.tel_number_home[this.info.tel_number_home.length - 1] == '-') {
			return;
		}
		if (this.info.tel_number_home.length == 3) {
			this.info.tel_number_home += ")";
		}
		if (this.info.tel_number_home.length == 7 ||
			this.info.tel_number_home.length == 10) {
			this.info.tel_number_home += "-";
		}
	}
	NumberStartHome(){
		if (this.info.tel_number_home != undefined && this.info.tel_number_home != "") {
			return;
		}
		this.info.tel_number_home = "(";
	}

	createMaskWork($event){
		if ($event.key == "Backspace") {
			return;
		}
		if (this.info.tel_number_work[this.info.tel_number_work.length - 1] == ')' ||
			this.info.tel_number_work[this.info.tel_number_work.length - 1] == '-') {
			return;
		}
		if (this.info.tel_number_work.length == 3) {
			this.info.tel_number_work += ")";
		}
		if (this.info.tel_number_work.length == 7 ||
			this.info.tel_number_work.length == 10) {
			this.info.tel_number_work += "-";
		}
	}
	NumberStartWork(){
		if (this.info.tel_number_work != undefined && this.info.tel_number_work != "") {
			return;
		}
		this.info.tel_number_work = "(";
	}

	createMaskMobile($event){
		if ($event.key == "Backspace") {
			return;
		}
		if (this.info.tel_number_mobile[this.info.tel_number_mobile.length - 1] == ')' ||
			this.info.tel_number_mobile[this.info.tel_number_mobile.length - 1] == '-') {
			return;
		}
		if (this.info.tel_number_mobile.length == 3) {
			this.info.tel_number_mobile += ")";
		}
		if (this.info.tel_number_mobile.length == 7 ||
			this.info.tel_number_mobile.length == 10) {
			this.info.tel_number_mobile += "-";
		}
	}

	NumberStartMobile(){
		if (this.info.tel_number_mobile != undefined && this.info.tel_number_mobile != "") {
			return;
		}
		this.info.tel_number_mobile = "(";
	}
}