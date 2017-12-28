import { Component, OnInit } from '@angular/core';
import { GetListService } from './services/getPersonList.service';
import { SearchSirnameService } from './services/searchSirname.service';
import { PersonalInfoService } from '../personalInfo.service';
import { BsModalService } from "ngx-bootstrap/modal";
import { BsModalRef } from 'ngx-bootstrap/modal/modal-options.class';
import { Person } from '../model/person.class';
import { PreloaderComponent } from '../preloader.component';
import { PersonalInfoComponent } from '../personalInfo.component'; 

import { ShowPersonInfoService } from "../personalInfo/showPersonalInfo.service";
@Component({
	templateUrl: "../templates/searchComponents/sirname.component.html",
	providers: [GetListService, SearchSirnameService, PersonalInfoService, ShowPersonInfoService],
	styleUrls:['../css/search.component.css']
})

export class SirnameComponent implements OnInit{
	constructor(private sirnameServ: GetListService,
				private search: SearchSirnameService,
				private personalInfo: PersonalInfoService,
				private PIService: BsModalService,
				private showInfo: ShowPersonInfoService
		){}
	doctors: any[] = []
	scrollCounter:number = 400;
	offset: number = 0;
	searchValue: string = "";
	searchDoctors: any[] = [];
	PersonalInfoModal: BsModalRef;
	ngOnInit(): void{
		this.sirnameServ.getList(30, this.offset, "sirname").then(data => {
			this.doctors = this.doctors.concat(data.json().data);
			this.doctors.sort((a, b) => {
	          var sirname_first, sirname_second;
	          sirname_first = new Date(a.sirname);
	          sirname_second = new Date(b.sirname);
	          if (sirname_first < sirname_second) {
	            return -1;
	          } else if (sirname_first > sirname_second){
	            return 1;
	          } else{
	          	return 0;
	          }
	        });
		});
	}

	ajaxLoad($event): void{
		if($event.target.scrollTop < this.scrollCounter){
			this.offset += 30;
			this.scrollCounter += 200;
			this.ngOnInit();
		}
	}

	Search(event:any): void{
		if (event.target.value === "") {
			this.searchDoctors = [];
			return;
		}
		this.searchValue = event.target.value;
		this.search.searchPerson(this.searchValue).then(data => {
			console.log(data._body);
			this.searchDoctors = data.json();
		});
	}
}