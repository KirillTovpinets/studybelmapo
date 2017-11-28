import { Component, OnInit } from "@angular/core";
import { GetListService } from './services/getPersonList.service';
import { SearchSirnameService } from './services/searchSirname.service';
import { BsModalService } from "ngx-bootstrap/modal";
import { BsModalRef } from 'ngx-bootstrap/modal/modal-options.class';
import { PersonalInfoService } from '../personalInfo.service';
import { PersonalInfoComponent } from '../personalInfo.component';
@Component({
	templateUrl: "../templates/searchComponents/age.component.html",
	providers: [GetListService, PersonalInfoService,SearchSirnameService],
	styleUrls:['../css/search.component.css']
})

export class AgeComponent implements OnInit{
	eighteenDoctors:any[] = [];
	twentyTwoDoctors:any[] = [];
	twentyNineDoctors:any[] = [];
	thirtySixDoctors:any[] = [];
	fortyFourDoctors:any[] = [];
	fiftyThreeDoctors:any[] = [];

	searcheighteenDoctors:any[] = [];
	searchtwentyTwoDoctors:any[] = [];
	searchtwentyNineDoctors:any[] = [];
	searchthirtySixDoctors:any[] = [];
	searchfortyFourDoctors:any[] = [];
	searchfiftyThreeDoctors:any[] = [];

	limit: number = 30;
	offset:number = 0;
	scrollCounter:number = 400;
	searchValue: string = "";
	searchDoctors: any[] = [];
	PersonalInfoModal: BsModalRef;
	data: any;


	constructor(private ageService: GetListService,
				private personalInfo: PersonalInfoService,
				private search: SearchSirnameService,
				private PIService: BsModalService
		){}

	ngOnInit(): void{
		this.ageService.getList(this.limit, this.offset, "age", {min: 18, max: 21}).then(data => {
			this.eighteenDoctors = data.json();
		});
		this.ageService.getList(this.limit, this.offset, "age", {min: 22, max: 28}).then(data => {
			this.twentyTwoDoctors = data.json();
		});
		this.ageService.getList(this.limit, this.offset, "age", {min: 29, max: 35}).then(data => {
			this.twentyNineDoctors = data.json();
		});
		this.ageService.getList(this.limit, this.offset, "age", {min: 36, max: 43}).then(data => {
			this.thirtySixDoctors = data.json();
		});
		this.ageService.getList(this.limit, this.offset, "age", {min: 44, max: 52}).then(data => {
			this.fortyFourDoctors = data.json();
		});
		this.ageService.getList(this.limit, this.offset, "age", {min: 53, max: 200}).then(data => {
			this.fiftyThreeDoctors = data.json();
		});
	}
	ShowPersonalInfo(person:any): void{
		this.personalInfo.getInfo(person.id).then(data => {
			this.PersonalInfoModal = this.PIService.show(PersonalInfoComponent, {class: 'modal-lg'});
			this.PersonalInfoModal.content.title = "Профиль врача";
			this.PersonalInfoModal.content.person = data.json();
		});
	}
	ajaxLoad($event): void{
		if($event.target.scrollTop < this.scrollCounter){
			this.offset += 30;
			this.scrollCounter += 200;
			this.ngOnInit();
		}
	}

	Search(event:any, params:any): void{
		if (event.target.value === "") {
			this.ngOnInit();
			return;
		}
		this.searchValue = event.target.value;
		this.search.searchPerson(this.searchValue, params).then(data => {
			switch (params.min) {
				case 18:
					this.searcheighteenDoctors = data.json();
					break;
				case 22:
					this.searchtwentyTwoDoctors = data.json();
					break;
				case 29:
					this.searchtwentyNineDoctors = data.json();
					break;
				case 36:
					this.searchthirtySixDoctors = data.json();
					break;
				case 44:
					this.searchfortyFourDoctors = data.json();
					break;
				case 53:
					this.searchfiftyThreeDoctors = data.json();
					break;
			}
			this.searchDoctors = data.json();
		});
	}
	
}