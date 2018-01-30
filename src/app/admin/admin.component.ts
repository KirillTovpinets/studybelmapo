import { Component, OnInit } from '@angular/core';
import { PersonalDataService } from "../personalInfo/personalData.service";
@Component({
  selector: 'app-admin',
  templateUrl: './admin.component.html',
  styleUrls: ['./admin.component.css'],
  providers:[PersonalDataService]
})
export class AdminComponent implements OnInit {

  constructor(private dataService: PersonalDataService) { }
  country:number = 0;
  countryList: any[] = [];
  cities:string[] = [];
  ngOnInit() {
  	this.dataService.getData().then(data => {
  		this.countryList = data.json().residArr;
  	})
  }
  Save(country, cities){
  	console.log(country);
  	console.log(cities);
  }
}
