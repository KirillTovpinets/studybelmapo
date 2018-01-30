import { Component, OnInit } from "@angular/core";
import { GetListService } from "../services/getPersonList.service";
import { BsModalService } from "ngx-bootstrap/modal";
import { SearchSirnameService } from '../services/searchSirname.service';
import { BsModalRef } from 'ngx-bootstrap/modal/modal-options.class';
import { PersonalInfoService } from '../../personalInfo/personalInfo.service';
import { PersonalInfoComponent } from '../../personalInfo/personalInfo.component';
import { MainClass } from "../../model/MainClass.class";
import { ShowPersonInfoService } from "../../personalInfo/showPersonalInfo.service";
import { List } from "../../model/List.class";

@Component({
	templateUrl: "./qualification.component.html",
	providers: [GetListService, PersonalInfoService,SearchSirnameService, ShowPersonInfoService],
	styleUrls:['../search.component.css']
})

export class QualificationComponent extends MainClass implements OnInit{
	constructor(public listService: GetListService,
				private personalInfo: PersonalInfoService,
				public search: SearchSirnameService,
				private PIService: BsModalService,
				private showInfo: ShowPersonInfoService){
		super(search, listService);
	}
	qualification_main:List[] = [];
	qualification_add:List[] = [];
	qualification_others:List[] = [];

	searchQualification_main:List[] = [];
	searchQualification_add:List[] = [];
	searchQualification_others:List[] = [];

	main_message:string;
	add_message:string;
	others_message:string;

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
			try{
				if (data.json().data.length == 0) {
					this.main_message = "Список пуст";
				}
				for (var i = 0; i < data.json().data.length; i++) {
					this.qualification_main[i] = new List();
					this.qualification_main[i].id = data.json().data[i].id;
					this.qualification_main[i].limit = this.ListLimit;
					this.qualification_main[i].offset = this.ListOffset;
					this.qualification_main[i].name = data.json().data[i].name;
					this.qualification_main[i].total = data.json().data[i].Total;
					this.qualification_main[i].setList(data.json().data[i].List);
				}
			}
			catch(e){
				this.main_message = "Произошла ошибка. Обратитесь к администратору";
				console.log(e);
				console.log(data._body);
			}
		});
		this.listService.getList(this.limit, this.offset, "qualification", {table: "qualification_add", listLimit: this.ListLimit, listOffset: this.ListOffset}).then(data => {
			try{
				if (data.json().data.length == 0) {
					this.add_message = "Список пуст";
				}
				for (var i = 0; i < data.json().data.length; i++) {
					this.qualification_add[i] = new List();
					this.qualification_add[i].id = data.json().data[i].id;
					this.qualification_add[i].limit = this.ListLimit;
					this.qualification_add[i].offset = this.ListOffset;
					this.qualification_add[i].name = data.json().data[i].name;
					this.qualification_add[i].total = data.json().data[i].Total;
					this.qualification_add[i].setList(data.json().data[i].List);
				}
			}
			catch(e){
				this.add_message = "Произошла ошибка. Обратитесь к администратору";
				console.log(e);
				console.log(data._body);
			}
		});
		this.listService.getList(this.limit, this.offset, "qualification", {table: "qualification_other", listLimit: this.ListLimit, listOffset: this.ListOffset}).then(data => {
			try{
				if (data.json().data.length == 0) {
					this.others_message = "Список пуст";
				}
				for (var i = 0; i < data.json().data.length; i++) {
					this.qualification_others[i] = new List();
					this.qualification_others[i].id = data.json().data[i].id;
					this.qualification_others[i].limit = this.ListLimit;
					this.qualification_others[i].offset = this.ListOffset;
					this.qualification_others[i].name = data.json().data[i].name;
					this.qualification_others[i].total = data.json().data[i].Total;
					this.qualification_others[i].setList(data.json().data[i].List);
				}
			}
			catch(e){
				this.others_message = "Произошла ошибка. Обратитесь к администратору";
				console.log(e);
				console.log(data._body);
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