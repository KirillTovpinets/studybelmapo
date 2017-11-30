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
	templateUrl: "../templates/searchComponents/organization.component.html",
	providers:[GetListService, PersonalInfoService,SearchSirnameService],
	styleUrls:['../css/search.component.css']
})

export class OrganizationComponent extends MainClass implements OnInit{
	constructor(private personalInfo: PersonalInfoService,
				public search: SearchSirnameService,
				public establService: GetListService,
				private PIService: BsModalService){
		super(search, establService);
	}
	organizations: List[] = [];
	offset: number = 0;
	limit: number = 30;
	PersonalInfoModal: BsModalRef;
	scrollCounter:number = 200;
	searchValue: string = "";
	searchOrg: List[] = [];

	ListOffset: number = 0;
	ListLimit: number = 30;
	isLoading: boolean = false;

	ngOnInit(): void{
		this.establService.getList(this.limit, this.offset, "job", {listLimit: this.ListLimit, listOffset: this.ListOffset}).then(data => {
			console.log(data._body);
			for (var i = 0; i < data.json().data.length; i++) {
				this.organizations[i] = new List();
				this.organizations[i].limit = this.ListLimit;
				this.organizations[i].offset = this.ListOffset;
				this.organizations[i].name = data.json().data[i].name;
				this.organizations[i].total = data.json().data[i].Total;
				this.organizations[i].setList(data.json().data[i].List);
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