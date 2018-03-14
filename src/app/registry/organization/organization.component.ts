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
	templateUrl: "./organization.component.html",
	providers:[GetListService, PersonalInfoService,SearchSirnameService, ShowPersonInfoService],
	styleUrls:['../search.component.css']
})

export class OrganizationComponent extends MainClass implements OnInit{
	constructor(private personalInfo: PersonalInfoService,
				public search: SearchSirnameService,
				public establService: GetListService,
				private PIService: BsModalService, 
				private showInfo: ShowPersonInfoService){
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
	message:string;
	ngOnInit(): void{
		this.establService.getList(this.limit, this.offset, "job", {listLimit: this.ListLimit, listOffset: this.ListOffset}).then(data => {
			if (data.json().data.length == 0) {
				this.message = "Список пуст";
			}
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