import { Component, OnInit } from "@angular/core";
import { GetListService } from '../services/getPersonList.service';
import { SearchSirnameService } from '../services/searchSirname.service';
import { BsModalService } from "ngx-bootstrap/modal";
import { BsModalRef } from 'ngx-bootstrap/modal/modal-options.class';
import { PersonalInfoService } from '../../personalInfo/personalInfo.service';
import { PersonalInfoComponent } from '../../personalInfo/personalInfo.component';
import { List } from "../../model/List.class";
import { ShowPersonInfoService } from "../../personalInfo/showPersonalInfo.service";
@Component({
	templateUrl: "./age.component.html",
	providers: [GetListService, PersonalInfoService,SearchSirnameService, ShowPersonInfoService],
	styleUrls:['../search.component.css']
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
	message:string = "";
	ngOnInit(): void{

		for (var i = 0; i < this.params.length; ++i) {
			this.ageLists[i] = new List();
		}
		this.ageService.getList(30, 0, "age", {min: 18, max: 21}).then(data => this.isLoaded[0] = this.exportData(data, this.ageLists[0], 0));
		this.ageService.getList(30, 0, "age", {min: 22, max: 28}).then(data => this.isLoaded[1] = this.exportData(data, this.ageLists[1], 1));
		this.ageService.getList(30, 0, "age", {min: 29, max: 35}).then(data => this.isLoaded[2] = this.exportData(data, this.ageLists[2], 2));
		this.ageService.getList(30, 0, "age", {min: 36, max: 43}).then(data => this.isLoaded[3] = this.exportData(data, this.ageLists[3], 3));
		this.ageService.getList(30, 0, "age", {min: 44, max: 52}).then(data => this.isLoaded[4] = this.exportData(data, this.ageLists[4], 4));
		this.ageService.getList(30, 0, "age", {min: 53, max: 100}).then(data => this.isLoaded[5] = this.exportData(data, this.ageLists[5], 5));
	}
	exportData(data:any, input:any, index:number): number{
		try{
			console.log(data.json());
			if(data.json().data.length == 0){
				input.message = "Список пуст";
			}
			input.id = index;
			input.parameters = this.params[index];
			input.setList(data.json().data);
			input.currentDoctors = data.json().current;
			input.total = data.json().Total;
			input.currentTotal = data.json().CurrentTotal;
			if (data.json().CurrentTotal == 0) {
				input.message = "Список пуст";
			}
			return 1;
		}catch(e){
			console.log(data._body);
			console.log(e);
			input.message = "Произошла ошибка. Обратитесь к администратору";
			return 1;
		}
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
				try{
					console.log(data.json());
					list.setList(data.json().data);
				}catch(e){
					console.log(e);
					console.log(data._body);
				}
			});
		}
	}

	Search(event:any, age:List): void{
		if (event.target.value === "") {
			age.searchResult = [];
			return;
		}

		age.searchValue = event.target.value.charAt(0).toUpperCase() + event.target.value.slice(1);
		var value = age.searchValue.split(' ');
		var searchValue = "";
		for(let str of value){
			var capital = str.charAt(0).toUpperCase() + str.slice(1);
			searchValue += capital + " ";
		}
		searchValue = searchValue.slice(0, searchValue.length - 1);
		this.search.searchPerson(searchValue, age.parameters).then(data => {
			age.searchResult = data.json();
		});
	}
}