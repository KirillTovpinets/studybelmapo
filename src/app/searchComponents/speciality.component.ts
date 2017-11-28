import { Component, OnInit } from "@angular/core";
import { GetListService } from "./services/getPersonList.service";
import { BsModalService } from "ngx-bootstrap/modal";
import { BsModalRef } from 'ngx-bootstrap/modal/modal-options.class';
import { SearchSirnameService } from './services/searchSirname.service';
import { PersonalInfoService } from '../personalInfo.service';
import { PersonalInfoComponent } from '../personalInfo.component';
@Component({
	templateUrl: "../templates/searchComponents/speciality.component.html",
	providers:[GetListService, PersonalInfoService,SearchSirnameService],
	styleUrls:['../css/search.component.css']
})

export class SpecialityComponent implements OnInit{
	constructor(private establService: GetListService,
				private personalInfo: PersonalInfoService,
				private search: SearchSirnameService,
				private PIService: BsModalService){}
	specialities_main: any[] = [];
	specialities_retraining: any[] = [];
	specialities_others: any[] = [];
	offset: number = 0;
	limit: number = 30;
	PersonalInfoModal: BsModalRef;
	scrollCounter:number = 400;
	searchValue: string = "";
	searchDoctors: any[] = [];
	ngOnInit(): void{
		this.establService.getList(this.limit, this.offset, "speciality").then(data => {
			console.log(data._body);
			this.specialities_main = data.json().speciality_doct;
			this.specialities_retraining = data.json().speciality_retraining;
			this.specialities_others = data.json().speciality_other;
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
	SearchDoctoral(event:any):void{
		if (event.target.value === "") {
			this.ngOnInit();
			return;
		}
		this.searchValue = event.target.value;
		this.establService.getList(0, 0, "specialities_doct", { name: this.searchValue }).then(data => {
			this.specialities_main = data.json();
		});
	}
	SearchRetraining(event:any):void{
		if (event.target.value === "") {
			this.ngOnInit();
			return;
		}
		this.searchValue = event.target.value;
		this.establService.getList(0, 0, "specialities_retrain", { name: this.searchValue }).then(data => {
			this.specialities_retraining = data.json();
		});
	}
	SearchOther(event:any):void{
		if (event.target.value === "") {
			this.ngOnInit();
			return;
		}
		this.searchValue = event.target.value;
		this.establService.getList(0, 0, "specialities_other", { name: this.searchValue }).then(data => {
			this.specialities_others = data.json();
		});
	}
}