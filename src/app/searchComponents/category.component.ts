import { Component, OnInit } from "@angular/core";
import { GetListService } from "./services/getPersonList.service";
import { SearchSirnameService } from './services/searchSirname.service';
import { BsModalService } from "ngx-bootstrap/modal";
import { BsModalRef } from 'ngx-bootstrap/modal/modal-options.class';
import { PersonalInfoService } from '../personalInfo.service';
import { PersonalInfoComponent } from '../personalInfo.component';
import { ShowPersonInfoService } from "../personalInfo/showPersonalInfo.service";
@Component({
	templateUrl: "../templates/searchComponents/category.component.html",
	providers:[GetListService, PersonalInfoService, SearchSirnameService, ShowPersonInfoService],
	styleUrls:['../css/search.component.css']
})

export class CategoryComponent implements OnInit{
	constructor(private personalInfo: PersonalInfoService,
				private search: SearchSirnameService,
				private PIService: BsModalService, 
				private showInfo: ShowPersonInfoService){}
	PersonalInfoModal: BsModalRef;
	scrollCounter:number = 400;
	searchValue: string = "";
	searchDoctors: any[] = [];
	offset: number = 0;
	limit: number = 30;
	ngOnInit(): void{
		// this.establService.getList(this.limit, this.offset, "establishment").then(data => {
		// 	console.log(data._body);
		// 	this.establs = data.json();
		// });
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

	Search(event:any): void{
		if (event.target.value === "") {
			this.ngOnInit();
			return;
		}
		this.searchValue = event.target.value;
		this.search.searchPerson(this.searchValue).then(data => {
			this.searchDoctors = data.json().data;
		});
	}
}