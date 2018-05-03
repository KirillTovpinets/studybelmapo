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
	templateUrl: "./sirname.component.html",
	providers: [GetListService, SearchSirnameService, PersonalInfoService, ShowPersonInfoService],
	styleUrls:['../search.component.css']
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
	message:string;
	messageResult:string;
	ngOnInit(): void{
		this.sirnameServ.getList(30, this.offset, "sirname").then(data => {
			try{
				if (data.json().data.length == 0 && this.offset == 0) {
					this.message = "Список пуст";
				}
				this.doctors = this.doctors.concat(data.json().data);
			}catch(e){
				this.message = "Произошла ошибка. Обратитесь к администратору";
				console.log(e);
				console.log(data._body);
			}
		});
	}

	ajaxLoad($event): void{
		this.offset += 30;
		this.ngOnInit();
	}

	Search(event:any): void{
		if (event.target.value === "") {
			this.searchDoctors = [];
			return;
		}

		this.searchValue = event.target.value.charAt(0).toUpperCase() + event.target.value.slice(1);
		var value = this.searchValue.split(' ');
		var searchValue = "";
		for(let str of value){
			var capital = str.charAt(0).toUpperCase() + str.slice(1);
			searchValue += capital + " ";
		}
		searchValue = searchValue.slice(0, searchValue.length - 1);
		this.search.searchPerson(searchValue).then(data => {
			try{
				if(data.json().length == 0){
					this.messageResult = "По вашему запросу ничего не найдено";
				}else{
					this.messageResult = "";
					this.searchDoctors = data.json();
				}
			}catch(e){
				console.log(data._body);
				console.log(e);
			}
		});
	}
}