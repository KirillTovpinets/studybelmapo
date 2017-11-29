import { Component, OnInit } from "@angular/core";
import { GetListService } from "./services/getPersonList.service";
import { BsModalService } from "ngx-bootstrap/modal";
import { SearchSirnameService } from './services/searchSirname.service';
import { BsModalRef } from 'ngx-bootstrap/modal/modal-options.class';
import { PersonalInfoService } from '../personalInfo.service';
import { PersonalInfoComponent } from '../personalInfo.component';
import { List } from "./List.class";

@Component({
	templateUrl: "../templates/searchComponents/establishment.component.html",
	providers:[GetListService, PersonalInfoService,SearchSirnameService],
	styleUrls:['../css/search.component.css']
})

export class EstablishmentComponent implements OnInit{
	constructor(private establService: GetListService,
				private personalInfo: PersonalInfoService,
				private search: SearchSirnameService,
				private PIService: BsModalService){}
	establs: List[] = [];
	EstOffset: number = 0;
	EstLimit: number = 30;

	ListOffset: number = 0;
	ListLimit: number = 30;
	searchValue: string = "";
	searchEst:any[] = [];
	PersonalInfoModal: BsModalRef;
	ngOnInit(): void{
		this.establService.getList(this.EstLimit, this.EstOffset, "establishment", {listLimit: this.ListLimit, listOffset: this.ListOffset}).then(data => {
			console.log(data._body);
			for (var i = 0; i < data.json().data.length; i++) {
				this.establs[i] = new List();
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
	ajaxLoad($event:any, establ:any): void{
		if($event.target.scrollTop < establ.scrollCounter){
			establ.offset += 30;
			establ.scrollCounter += 200;
			this.establService.getList(this.EstLimit, this.EstOffset, "establishment", {listLimit: establ.limit, listOffset: establ.offset}).then(data => {
				console.log(data._body);
				establ.setList(establ.doctors.concat(data.json().data.List));
			});
		}
	}

	Search(event:any, establ:any): void{
		if (event.target.value === "") {
			establ.searchResult = [];
			return;
		}
		establ.searchValue = event.target.value;
		this.search.searchPerson(establ.searchValue).then(data => {
			establ.searchResult = data.json().data;
		});
	}
	SearchEstablishment(event:any):void{
		if (event.target.value === "") {
			this.searchEst = [];
			return;
		}
		this.searchValue = event.target.value;
		this.establService.getList(50, 0, "establishment", { name: this.searchValue, listLimit: this.ListLimit, listOffset: this.ListOffset }).then(data => {
			this.searchEst = data.json();
		});
	}
}