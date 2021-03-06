import { Component, OnInit } from "@angular/core";
import { GetListService } from "../services/getPersonList.service";
import { BsModalService } from "ngx-bootstrap/modal";
import { SearchSirnameService } from '../services/searchSirname.service';
import { BsModalRef } from 'ngx-bootstrap/modal/bs-modal-ref.service';
import { PersonalInfoService } from '../../personalInfo/personalInfo.service';
import { PersonalInfoComponent } from '../../personalInfo/personalInfo.component';
import { MainClass } from "../../model/MainClass.class";
import { ShowPersonInfoService } from "../../personalInfo/showPersonalInfo.service";
import { List } from "../../model/List.class";


@Component({
	templateUrl: './gender.component.html',
	providers:[GetListService, PersonalInfoService,SearchSirnameService, ShowPersonInfoService],
	styleUrls:['../search.component.css']
})

export class GenderComponent implements OnInit{
	constructor(private genderService: GetListService,
				private personalInfo: PersonalInfoService,
				private search: SearchSirnameService,
				private PIService: BsModalService, 
				private showInfo: ShowPersonInfoService
		){}
	PersonalInfoModal: BsModalRef;
	maleList: List = new List();
	femaleList: List = new List();
	errorMessageF: string = "";
	errorMessageM: string = "";
	isLoadedM: boolean = false;
	isLoadedF: boolean = false;
	ngOnInit(): void {
		this.genderService.getList(this.maleList.limit, this.maleList.offset, "gender", { isMale: 1 }).then(data => {
			try{
				if (data.json().data.length == 0) {
					this.maleList.message = "Список пуст";
				}
				this.maleList.setList(data.json().data);
			}catch(e){
				this.errorMessageM = "Произошла ошибка. Обратитесь к администратору";
				console.log(e);
				console.log(data._body);
			}
			this.isLoadedM = true;
		});
		this.genderService.getList(this.femaleList.limit, this.femaleList.offset, "gender", { isMale: 0 }).then(data => {
			try{
				if (data.json().data.length == 0) {
					this.femaleList.message = "Список пуст";
				}
				this.femaleList.setList(data.json().data);
			}catch(e){
				this.errorMessageF = "Произошла ошибка. Обратитесь к администратору";
				console.log(e);
				console.log(data._body);
			}
			this.isLoadedF = true;
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
			this.genderService.getList(this.femaleList.limit, this.femaleList.offset, "gender", { isMale: 0 }).then(data => {
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