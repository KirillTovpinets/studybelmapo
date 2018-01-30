import { Component, OnInit } from "@angular/core";
import { GetListService } from "../services/getPersonList.service";
import { BsModalService } from "ngx-bootstrap/modal";
import { SearchSirnameService } from '../services/searchSirname.service';
import { BsModalRef } from 'ngx-bootstrap/modal/modal-options.class';
import { PersonalInfoService } from '../../personalInfo/personalInfo.service';
import { PersonalInfoComponent } from '../../personalInfo/personalInfo.component';
import { ShowPersonInfoService } from "../../personalInfo/showPersonalInfo.service";
import { MainClass } from "../../model/MainClass.class";
import { List } from "../../model/List.class";

@Component({
	templateUrl: "./appointment.component.html",
	providers:[GetListService, PersonalInfoService,SearchSirnameService, ShowPersonInfoService],
	styleUrls:['../search.component.css']
})

export class AppointmentComponent extends MainClass implements OnInit{
	constructor(public establService: GetListService,
				private personalInfo: PersonalInfoService,
				public search: SearchSirnameService,
				private PIService: BsModalService, 
				private showInfo: ShowPersonInfoService){
		super(search, establService);
	}
	appointments: List[] = [];
	offset: number = 0;
	limit: number = 30;
	PersonalInfoModal: BsModalRef;
	scrollCounter:number = 400;
	searchValue: string = "";
	searchDoctors: any[] = [];
	searchApp: List[] = [];
	isLoading: boolean = false;
	ListLimit:number = 30;
	ListOffset:number = 0;
	message: string;
	ngOnInit(): void{
		this.establService.getList(this.limit, this.offset, "appointment", {listLimit: this.ListLimit, listOffset: this.ListOffset}).then(data => {
			console.log(data.json().data.length);
			if (data.json().data.length == 0) {
				this.message = "Список пуст";
			}
			for (var i = 0; i < data.json().data.length; i++) {
				this.appointments[i] = new List();
				this.appointments[i].id = data.json().data[i].id;
				this.appointments[i].limit = this.ListLimit;
				this.appointments[i].offset = this.ListOffset;
				this.appointments[i].name = data.json().data[i].name;
				this.appointments[i].total = data.json().data[i].Total;
				this.appointments[i].setList(data.json().data[i].List);
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