import { Component, OnInit } from "@angular/core";
import { GetListService } from "./services/getPersonList.service";
import { BsModalService } from "ngx-bootstrap/modal";
import { SearchSirnameService } from './services/searchSirname.service';
import { BsModalRef } from 'ngx-bootstrap/modal/modal-options.class';
import { PersonalInfoService } from '../personalInfo.service';
import { PersonalInfoComponent } from '../personalInfo.component';
import { MainClass } from "../MainClass.class";

import { List } from "./List.class";

@Component({
	templateUrl: "../templates/searchComponents/qualification.component.html",
	providers: [GetListService, PersonalInfoService,SearchSirnameService],
	styleUrls:['../css/search.component.css']
})

export class QualificationComponent extends MainClass implements OnInit{
	constructor(public listService: GetListService,
				private personalInfo: PersonalInfoService,
				public search: SearchSirnameService,
				private PIService: BsModalService){
		super(search, listService);
	}
	qualification_main:List[] = [];
	qualification_add:List[] = [];
	qualification_others:List[] = [];

	searchQualification_main:List[] = [];
	searchQualification_add:List[] = [];
	searchQualification_others:List[] = [];

	limit: number = 30;
	offset: number = 0;
	PersonalInfoModal: BsModalRef;
	scrollCounter:number = 400;
	searchValue: string = "";
	searchDoctors: any[] = [];

	ListLimit:number = 30;
	ListOffset:number = 0;
	ngOnInit(): void{

		this.listService.getList(this.limit, this.offset, "qualification", {table: "qualification_main", listLimit: this.ListLimit, listOffset: this.ListOffset}).then(data => {
			for (var i = 0; i < data.json().data.length; i++) {
				this.qualification_main[i] = new List();
				this.qualification_main[i].id = data.json().data[i].id;
				this.qualification_main[i].limit = this.ListLimit;
				this.qualification_main[i].offset = this.ListOffset;
				this.qualification_main[i].name = data.json().data[i].name;
				this.qualification_main[i].total = data.json().data[i].Total;
				this.qualification_main[i].setList(data.json().data[i].List);
			}
		});
		this.listService.getList(this.limit, this.offset, "qualification", {table: "qualification_add", listLimit: this.ListLimit, listOffset: this.ListOffset}).then(data => {
			for (var i = 0; i < data.json().data.length; i++) {
				this.qualification_add[i] = new List();
				this.qualification_add[i].id = data.json().data[i].id;
				this.qualification_add[i].limit = this.ListLimit;
				this.qualification_add[i].offset = this.ListOffset;
				this.qualification_add[i].name = data.json().data[i].name;
				this.qualification_add[i].total = data.json().data[i].Total;
				this.qualification_add[i].setList(data.json().data[i].List);
			}
		});
		this.listService.getList(this.limit, this.offset, "qualification", {table: "qualification_other", listLimit: this.ListLimit, listOffset: this.ListOffset}).then(data => {
			for (var i = 0; i < data.json().data.length; i++) {
				this.qualification_others[i] = new List();
				this.qualification_others[i].id = data.json().data[i].id;
				this.qualification_others[i].limit = this.ListLimit;
				this.qualification_others[i].offset = this.ListOffset;
				this.qualification_others[i].name = data.json().data[i].name;
				this.qualification_others[i].total = data.json().data[i].Total;
				this.qualification_others[i].setList(data.json().data[i].List);
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