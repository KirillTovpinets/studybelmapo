import { Component, OnInit } from "@angular/core";
import { GetListService } from './services/getPersonList.service';
import { SearchSirnameService } from './services/searchSirname.service';
import { BsModalService } from "ngx-bootstrap/modal";
import { BsModalRef } from 'ngx-bootstrap/modal/modal-options.class';
import { PersonalInfoService } from '../personalInfo.service';
import { PersonalInfoComponent } from '../personalInfo.component';
import { List } from "./List.class";
import { ShowPersonInfoService } from "../personalInfo/showPersonalInfo.service";
@Component({
	templateUrl: "../templates/searchComponents/age.component.html",
	providers: [GetListService, PersonalInfoService,SearchSirnameService, ShowPersonInfoService],
	styleUrls:['../css/search.component.css']
})

export class AgeComponent implements OnInit{

	ageLists:List[] = [];
	PersonalInfoModal: BsModalRef;

	params:any[] = [
						{min: 18, max: 21},
						{min: 22, max: 28},
						{min: 29, max: 35},
						{min: 36, max: 43},
						{min: 44, max: 52},
						{min: 53, max: 100}
					]

	constructor(private ageService: GetListService,
				private personalInfo: PersonalInfoService,
				private search: SearchSirnameService,
				private PIService: BsModalService, 
				private showInfo: ShowPersonInfoService
		){
		for (var i = 0; i < this.ageLists.length; i++) {
			this.ageLists[i] = new List();
		}
	}
	isLoaded:number[] = [0, 0, 0, 0, 0, 0];
	ngOnInit(): void{

		this.ageService.getList(30, 0, "age", {min: 18, max: 21}).then(data => {
			try{
				this.ageLists[0] = new List();
				if(data.json().data == 0){
					this.ageLists[0].message = "Список пуст";
				}
				this.ageLists[0].id = 0;
				this.ageLists[0].parameters = this.params[0];
				this.ageLists[0].setList(data.json().data);
				this.ageLists[0].total = data.json().Total;
			}catch(e){
				this.ageLists[0].message = "Информация не найдена";				
			}
			this.isLoaded[0] = 1;
		});
		this.ageService.getList(30, 0, "age", {min: 22, max: 28}).then(data => {
			try{
				this.ageLists[1] = new List();
				if(data.json().data == 0){
					this.ageLists[1].message = "Список пуст";
				}
				this.ageLists[1].id = 1;
				this.ageLists[1].parameters = this.params[1];
				this.ageLists[1].setList(data.json().data);
				this.ageLists[1].total = data.json().Total;
			}catch(e){
				this.ageLists[1].message = "Информация не найдена";				
			}
			this.isLoaded[1] = 1;
		});
		this.ageService.getList(30, 0, "age", {min: 29, max: 35}).then(data => {
			try{
				this.ageLists[2] = new List();
				if(data.json().data == 0){
					this.ageLists[2].message = "Список пуст";
				}
				this.ageLists[2].id = 2;
				this.ageLists[2].parameters = this.params[2];
				this.ageLists[2].setList(data.json().data);
				this.ageLists[2].total = data.json().Total;
			}catch(e){
				this.ageLists[2].message = "Информация не найдена";
			}
			this.isLoaded[2] = 1;
		});
		this.ageService.getList(30, 0, "age", {min: 36, max: 43}).then(data => {
			try{
				this.ageLists[3] = new List();
				if(data.json().data == 0){
					this.ageLists[3].message = "Список пуст";
				}
				this.ageLists[3].id = 3;
				this.ageLists[3].parameters = this.params[3];
				this.ageLists[3].setList(data.json().data);
				this.ageLists[3].total = data.json().Total;
			}catch(e){
				this.ageLists[3].message = "Информация не найдена";
			}
			this.isLoaded[3] = 1;
		});
		this.ageService.getList(30, 0, "age", {min: 44, max: 52}).then(data => {
			try{
				this.ageLists[4] = new List();
				if(data.json().data == 0){
					this.ageLists[4].message = "Список пуст";
				}
				this.ageLists[4].id = 4;
				this.ageLists[4].parameters = this.params[4];
				this.ageLists[4].setList(data.json().data);
				this.ageLists[4].total = data.json().Total;
			}catch(e){
				this.ageLists[4].message = "Информация не найдена";
			}
			this.isLoaded[4] = 1;
		});
		this.ageService.getList(30, 0, "age", {min: 53, max: 100}).then(data => {
			try{
				this.ageLists[5] = new List();
				if(data.json().data == 0){
					this.ageLists[5].message = "Список пуст";
				}
				this.ageLists[5].id = 5;
				this.ageLists[5].parameters = this.params[5];
				this.ageLists[5].setList(data.json().data);
				this.ageLists[5].total = data.json().Total;
			}catch(e){
				this.ageLists[5].message = "Информация не найдена";
			}
			this.isLoaded[5] = 1;
		});
	}
	ShowPersonalInfo(person:any): void{
		this.personalInfo.getInfo(person.id).then(data => {
			this.PersonalInfoModal = this.PIService.show(PersonalInfoComponent, {class: 'modal-lg'});
			this.PersonalInfoModal.content.title = "Профиль врача";
			this.PersonalInfoModal.content.person = data.json();
		});
	}
	ajaxLoad($event:any, list:List): void{
		if($event.target.scrollTop < list.scrollCounter){
			list.offset += 30;
			list.scrollCounter += 200;
			this.ageService.getList(list.limit, list.offset, "age", list.parameters).then(data => {
				list.setList(data.json().data);
				list.total = data.json().Total;
			});
		}
	}

	Search(event:any, age:List): void{
		if (event.target.value === "") {
			age.searchResult = [];
			return;
		}

		age.searchValue = event.target.value;
		this.search.searchPerson(age.searchValue, age.parameters).then(data => {
			age.searchResult = data.json();
		});
	}
	
}