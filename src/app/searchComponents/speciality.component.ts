import { Component, OnInit } from "@angular/core";
import { GetListService } from "./services/getPersonList.service";
import { BsModalService } from "ngx-bootstrap/modal";
import { BsModalRef } from 'ngx-bootstrap/modal/modal-options.class';
import { SearchSirnameService } from './services/searchSirname.service';
import { PersonalInfoService } from '../personalInfo.service';
import { PersonalInfoComponent } from '../personalInfo.component';
import { MainClass } from "../MainClass.class";
import { ShowPersonInfoService } from "../personalInfo/showPersonalInfo.service";
import { List } from "./List.class";
@Component({
	templateUrl: "../templates/searchComponents/speciality.component.html",
	providers:[GetListService, PersonalInfoService,SearchSirnameService,ShowPersonInfoService],
	styleUrls:['../css/search.component.css']
})

export class SpecialityComponent extends MainClass implements OnInit{
	constructor(public establService: GetListService,
				private personalInfo: PersonalInfoService,
				public search: SearchSirnameService,
				private PIService: BsModalService,
				private showInfo: ShowPersonInfoService){
		super(search, establService);
	}
	specialities_main: List[] = [];
	specialities_retraining: List[] = [];
	specialities_others: List[] = [];

	searchSpecialities_main: List[] = [];
	searchSpecialities_retraining: List[] = [];
	searchSpecialities_others: List[] = [];

	isLoaded: boolean = false;

	offset: number = 0;
	limit: number = 30;
	PersonalInfoModal: BsModalRef;
	scrollCounter:number = 400;
	searchValue: string = "";
	searchDoctors: any[] = [];

	ListLimit:number = 30;
	ListOffset:number = 0;
	ngOnInit(): void{
		this.establService.getList(this.limit, this.offset, "speciality", {table: "speciality_doct", listLimit: this.ListLimit, listOffset: this.ListOffset}).then(data => {
			for (var i = 0; i < data.json().data.length; i++) {
				this.specialities_main[i] = new List();
				this.specialities_main[i].id = data.json().data[i].id;
				this.specialities_main[i].limit = this.ListLimit;
				this.specialities_main[i].offset = this.ListOffset;
				this.specialities_main[i].name = data.json().data[i].name;
				this.specialities_main[i].total = data.json().data[i].Total;
				this.specialities_main[i].setList(data.json().data[i].List);
			}
		});
		this.establService.getList(this.limit, this.offset, "speciality", {table: "speciality_retraining", listLimit: this.ListLimit, listOffset: this.ListOffset}).then(data => {
			for (var i = 0; i < data.json().data.length; i++) {
				this.specialities_retraining[i] = new List();
				this.specialities_retraining[i].id = data.json().data[i].id;
				this.specialities_retraining[i].limit = this.ListLimit;
				this.specialities_retraining[i].offset = this.ListOffset;
				this.specialities_retraining[i].name = data.json().data[i].name;
				this.specialities_retraining[i].total = data.json().data[i].Total;
				this.specialities_retraining[i].setList(data.json().data[i].List);
			}
		});
		this.establService.getList(this.limit, this.offset, "speciality", {table: "speciality_other", listLimit: this.ListLimit, listOffset: this.ListOffset}).then(data => {
			for (var i = 0; i < data.json().data.length; i++) {
				this.specialities_others[i] = new List();
				this.specialities_others[i].id = data.json().data[i].id;
				this.specialities_others[i].limit = this.ListLimit;
				this.specialities_others[i].offset = this.ListOffset;
				this.specialities_others[i].name = data.json().data[i].name;
				this.specialities_others[i].total = data.json().data[i].Total;
				this.specialities_others[i].setList(data.json().data[i].List);
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