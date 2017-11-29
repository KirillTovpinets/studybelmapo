import { Component, OnInit } from "@angular/core";
import { GetListService } from "./services/getPersonList.service";
import { BsModalService } from "ngx-bootstrap/modal";
import { SearchSirnameService } from './services/searchSirname.service';
import { BsModalRef } from 'ngx-bootstrap/modal/modal-options.class';
import { PersonalInfoService } from '../personalInfo.service';
import { PersonalInfoComponent } from '../personalInfo.component'; 
import { List } from "./List.class";
@Component({
	templateUrl: '../templates/searchComponents/gender.component.html',
	providers:[GetListService, PersonalInfoService,SearchSirnameService],
	styleUrls:['../css/search.component.css']
})

export class GenderComponent implements OnInit{
	constructor(private genderService: GetListService,
				private personalInfo: PersonalInfoService,
				private search: SearchSirnameService,
				private PIService: BsModalService
		){}
	PersonalInfoModal: BsModalRef;
	maleList: List = new List();
	femaleList: List = new List();
	ngOnInit(): void {
		this.genderService.getList(this.maleList.limit, this.maleList.offset, "gender", { isMale: 1 }).then(data => {
			this.maleList.setList(data.json().data);
		});
		this.genderService.getList(this.femaleList.limit, this.femaleList.offset, "gender", { isMale: 2 }).then(data => {
			this.femaleList.setList(data.json().data);
		});
	}
	ShowPersonalInfo(doctor): void{
		this.personalInfo.getInfo(doctor.id).then(data => {
			this.PersonalInfoModal = this.PIService.show(PersonalInfoComponent, {class: 'modal-lg'});
			this.PersonalInfoModal.content.title = "Профиль врача";
			this.PersonalInfoModal.content.person = data.json();
		});
	}
	ajaxLoadMale($event): void{
		if($event.target.scrollTop < this.maleList.scrollCounter){
			this.maleList.offset += 30;
			this.maleList.scrollCounter += 200;
			this.genderService.getList(this.maleList.limit, this.maleList.offset, "gender", { isMale: 1 }).then(data => {
				this.maleList.setList(data.json().data);

			});
		}
	}

	ajaxLoadFemale($event): void{
		if($event.target.scrollTop < this.femaleList.scrollCounter){
			this.femaleList.offset += 30;
			this.femaleList.scrollCounter += 200;
			this.genderService.getList(this.femaleList.limit, this.femaleList.offset, "gender", { isMale: 2 }).then(data => {
				this.femaleList.setList(data.json().data);
			});
		}
	}
	SearchMale(event:any): void{
		if (event.target.value === "") {
			this.maleList.searchResult = [];
			return;
		}
		this.maleList.searchValue = event.target.value;
		this.search.searchPerson(this.maleList.searchValue, {isMale: 1}).then(data => {
			this.maleList.searchResult = data.json();
		});
	}
	SearchFemale(event:any): void{
		if (event.target.value === "") {
			this.femaleList.searchResult = [];
			return;
		}
		this.femaleList.searchValue = event.target.value;
		this.search.searchPerson(this.femaleList.searchValue, {isMale: 0}).then(data => {
			this.femaleList.searchResult = data.json();
		});
	}
}