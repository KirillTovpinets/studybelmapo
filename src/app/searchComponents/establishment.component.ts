import { Component, OnInit } from "@angular/core";
import { GetListService } from "./services/getPersonList.service";
import { BsModalService } from "ngx-bootstrap/modal";
import { SearchSirnameService } from './services/searchSirname.service';
import { BsModalRef } from 'ngx-bootstrap/modal/modal-options.class';
import { PersonalInfoService } from '../personalInfo.service';
import { PersonalInfoComponent } from '../personalInfo.component';
import { MainClass } from "../MainClass.class";
import { ShowPersonInfoService } from "../personalInfo/showPersonalInfo.service";
import { List } from "./List.class";

@Component({
	templateUrl: "../templates/searchComponents/establishment.component.html",
	providers:[GetListService, PersonalInfoService,SearchSirnameService , ShowPersonInfoService],
	styleUrls:['../css/search.component.css']
})

export class EstablishmentComponent extends MainClass implements OnInit{
	constructor(private personalInfo: PersonalInfoService,
				private PIService: BsModalService,
				public establService: GetListService,
				public search: SearchSirnameService, 
				private showInfo: ShowPersonInfoService){
		super(search, establService);
	}
	establs: List[] = [];
	EstOffset: number = 0;
	EstLimit: number = 30;

	ListOffset: number = 0;
	ListLimit: number = 30;
	searchValue: string = "";
	searchEst:List[] = [];
	PersonalInfoModal: BsModalRef;
	isLoading: boolean = false;
	ngOnInit(): void{
		this.establService.getList(this.EstLimit, this.EstOffset, "establishment", {listLimit: this.ListLimit, listOffset: this.ListOffset}).then(data => {
			for (var i = 0; i < data.json().data.length; i++) {
				this.establs[i] = new List();
				this.establs[i].id = data.json().data[i].id;
				this.establs[i].limit = this.ListLimit;
				this.establs[i].offset = this.ListOffset;
				this.establs[i].name = data.json().data[i].name;
				this.establs[i].total = data.json().data[i].Total;
				this.establs[i].setList(data.json().data[i].List);
			}
		});
	}
	
	ShowPersonalInfo(person:any): void{
		this.personalInfo.getInfo(person.id).then(data => {
			this.PersonalInfoModal = this.PIService.show(PersonalInfoComponent, {class: 'modal-lg'});
			this.PersonalInfoModal.content.title = "Профиль врача";
			this.PersonalInfoModal.content.person = data.json();
		});
	}
}