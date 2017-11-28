import { Component, OnInit } from "@angular/core";
import { GetListService } from "./services/getPersonList.service";
import { BsModalService } from "ngx-bootstrap/modal";
import { SearchSirnameService } from './services/searchSirname.service';
import { BsModalRef } from 'ngx-bootstrap/modal/modal-options.class';
import { PersonalInfoService } from '../personalInfo.service';
import { PersonalInfoComponent } from '../personalInfo.component';
@Component({
	templateUrl: "../templates/searchComponents/organization.component.html",
	providers:[GetListService, PersonalInfoService,SearchSirnameService],
	styleUrls:['../css/search.component.css']
})

export class OrganizationComponent implements OnInit{
	constructor(private establService: GetListService,
				private personalInfo: PersonalInfoService,
				private search: SearchSirnameService,
				private PIService: BsModalService){}
	organizations: any[] = [];
	offset: number = 0;
	limit: number = 30;
	PersonalInfoModal: BsModalRef;
	scrollCounter:number = 400;
	searchValue: string = "";
	searchDoctors: any[] = [];
	ngOnInit(): void{
		this.establService.getList(this.limit, this.offset, "job").then(data => {
			console.log(data._body);
			this.organizations = data.json();
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
	SearchOrganization(event:any):void{
		if (event.target.value === "") {
			this.ngOnInit();
			return;
		}
		this.searchValue = event.target.value;
		this.establService.getList(0, 0, "job", { name: this.searchValue }).then(data => {
			this.organizations = data.json();
		});
	}
}