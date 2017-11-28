import { Component, OnInit } from "@angular/core";
import { GetListService } from "./services/getPersonList.service";
import { BsModalService } from "ngx-bootstrap/modal";
import { SearchSirnameService } from './services/searchSirname.service';
import { BsModalRef } from 'ngx-bootstrap/modal/modal-options.class';
import { PersonalInfoService } from '../personalInfo.service';
import { PersonalInfoComponent } from '../personalInfo.component'; 

@Component({
	templateUrl: '../templates/searchComponents/gender.component.html',
	providers:[GetListService, PersonalInfoService,SearchSirnameService],
	styleUrls:['../css/search.component.css']
})

export class GenderComponent implements OnInit{
	constructor(private genderService: GetListService,
				private personalInfo: PersonalInfoService,
				private search: SearchSirnameService,
				private PIService: BsModalService
		){}
	MaleDoctors:any[] = [];
	FemaleDoctors: any[] = [];
	offset: number = 0;
	parameters: any = {};
	limit: number = 30;
	PersonalInfoModal: BsModalRef;
	scrollCounter:number = 400;
	searchValue: string = "";
	searchMaleDoctors: any[] = [];
	searchFemaleDoctors: any[] = [];
	ngOnInit(): void {
		this.genderService.getList(this.limit, this.offset, "gender", { isMale: 1 }).then(data => {
			this.MaleDoctors = data.json()
		});
		this.genderService.getList(this.limit, this.offset, "gender", { isMale: 2 }).then(data => {
			this.FemaleDoctors = data.json()
		});
	}
	ShowPersonalInfo(doctor): void{
		this.personalInfo.getInfo(doctor.id).then(data => {
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

	Search(event:any, isMale:number): void{
		if (event.target.value === "") {
			this.ngOnInit();
			return;
		}
		this.searchValue = event.target.value;
		this.parameters.isMale = isMale;
		this.search.searchPerson(this.searchValue, this.parameters).then(data => {
			if (this.parameters.isMale === 1) {
				this.searchMaleDoctors = data.json();
			}else{
				this.searchFemaleDoctors = data.json();
			}
		});
	}
}