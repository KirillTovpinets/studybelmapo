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
	templateUrl: "./establishment.component.html",
	providers:[GetListService, PersonalInfoService,SearchSirnameService , ShowPersonInfoService],
	styleUrls:['../search.component.css']
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
	message:string;
	level:number = 0;
	ngOnInit(): void{
		this.establService.getList(this.EstLimit, this.EstOffset, "establishment", {listLimit: this.ListLimit, listOffset: this.ListOffset}).then(data => {
			try{
				if (data.json().data.length == 0) {
					this.message = "Список пуст";
				}
				for (var i = 0; i < data.json().data.length; i++) {
					this.establs[i] = new List();
					this.establs[i].id = data.json().data[i].id;
					this.establs[i].limit = this.ListLimit;
					this.establs[i].offset = this.ListOffset;
					this.establs[i].name = data.json().data[i].name;
					this.establs[i].total = data.json().data[i].Total;
					this.establs[i].setList(data.json().data[i].List);
				}
			}catch(e){
				this.level = 1;
				this.message = "Произошла ошибка. Обратитесь к администратору.";
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