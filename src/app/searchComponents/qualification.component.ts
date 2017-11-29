import { Component, OnInit } from "@angular/core";
import { GetListService } from "./services/getPersonList.service";
import { BsModalService } from "ngx-bootstrap/modal";
import { SearchSirnameService } from './services/searchSirname.service';
import { BsModalRef } from 'ngx-bootstrap/modal/modal-options.class';
import { PersonalInfoService } from '../personalInfo.service';
import { PersonalInfoComponent } from '../personalInfo.component';
@Component({
	templateUrl: "../templates/searchComponents/qualification.component.html",
	providers: [GetListService, PersonalInfoService,SearchSirnameService],
	styleUrls:['../css/search.component.css']
})

export class QualificationComponent implements OnInit{
	constructor(private listService: GetListService,
				private personalInfo: PersonalInfoService,
				private search: SearchSirnameService,
				private PIService: BsModalService){}
	qualification_main:any[] = [];
	qualification_add:any[] = [];
	qualification_others:any[] = [];
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
			this.qualification_main = data.json().data;
		});
		this.listService.getList(this.limit, this.offset, "qualification", {table: "qualification_add", listLimit: this.ListLimit, listOffset: this.ListOffset}).then(data => {
			this.qualification_add = data.json().data;
		});
		this.listService.getList(this.limit, this.offset, "qualification", {table: "qualification_other", listLimit: this.ListLimit, listOffset: this.ListOffset}).then(data => {
			this.qualification_others = data.json().data;
		});
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
			this.searchDoctors = data.json();
		});
	}
	SearchMain(event:any):void{
		if (event.target.value === "") {
			this.ngOnInit();
			return;
		}
		this.searchValue = event.target.value;
		this.listService.getList(30, 0, "qualification", { name: this.searchValue, table: "qualification_main" }).then(data => {
			this.qualification_main = data.json();
		});
	}
	SearchAdditional(event:any):void{
		if (event.target.value === "") {
			this.ngOnInit();
			return;
		}
		this.searchValue = event.target.value;
		this.listService.getList(30, 0, "qualification", { name: this.searchValue, table: "qualification_add" }).then(data => {
			this.qualification_add = data.json();
		});
	}
	SearchOther(event:any):void{
		if (event.target.value === "") {
			this.ngOnInit();
			return;
		}
		this.searchValue = event.target.value;
		this.listService.getList(30, 0, "qualification", { name: this.searchValue, table: "qualification_other" }).then(data => {
			this.qualification_others = data.json();
		});
	}
}