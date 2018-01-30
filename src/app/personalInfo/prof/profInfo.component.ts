import { Component, Input, OnInit } from '@angular/core';
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
		var renewData = [];
		for(let key of this.dataKeys){
			if (localStorage.getItem(key) == null) {
				console.log("BYE");
				renewData.push(key);
			}else{
				console.log("HELLO");
				switch (key) {
					case "facBel":
						this.personal_faculties = JSON.parse(localStorage.getItem("facArr"));
						break;
					case "educTypeBel":
						this.personal_establishments = JSON.parse(localStorage.getItem("estArr"));
						break;
					case "formBel":
						this.specialityDocArr = JSON.parse(localStorage.getItem("specialityDocArr"));
						break;
					case "belmapo_residence":
						this.specialityRetrArr = JSON.parse(localStorage.getItem("specialityRetrArr"));
						break;
					case "facArr":
						this.specialityOtherArr = JSON.parse(localStorage.getItem("specialityOtherArr"));
						break;
					case "residArr":
						this.qualificationMainArr = JSON.parse(localStorage.getItem("qualificationMainArr"));
						break;
					case "appArr":
						this.qualificationAddArr = JSON.parse(localStorage.getItem("qualificationAddArr"));
						break;
					case "orgArr":
						this.qualificationOtherArr = JSON.parse(localStorage.getItem("qualificationOtherArr"));
						break;
				}
			}
		}
		if (renewData.length != 0) {
			this.dataService.getData().then(data => {
				this.personal_faculties = data.json().facArr;
				localStorage.setItem("facArr", JSON.stringify(data.json().facBel))
				this.personal_establishments = data.json().estArr;
				localStorage.setItem("estArr", JSON.stringify(data.json().facBel))
				this.specialityDocArr = data.json().specialityDocArr;
				localStorage.setItem("specialityDocArr", JSON.stringify(data.json().facBel))
				this.specialityRetrArr = data.json().specialityRetrArr;
				localStorage.setItem("specialityRetrArr", JSON.stringify(data.json().facBel))
				this.specialityOtherArr = data.json().specialityOtherArr;
				localStorage.setItem("specialityOtherArr", JSON.stringify(data.json().facBel))
				this.qualificationMainArr = data.json().qualificationMainArr;
				localStorage.setItem("qualificationMainArr", JSON.stringify(data.json().facBel))
				this.qualificationAddArr = data.json().qualificationAddArr;
				localStorage.setItem("qualificationAddArr", JSON.stringify(data.json().facBel))
				this.qualificationOtherArr = data.json().qualificationOtherArr;
				localStorage.setItem("qualificationOtherArr", JSON.stringify(data.json().facBel))
			});
		}	
	}
}