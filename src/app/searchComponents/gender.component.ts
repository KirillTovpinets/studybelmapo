import { Component, OnInit } from "@angular/core";
import { GetListService } from "./services/getPersonList.service";
import { BsModalService } from "ngx-bootstrap/modal";
import { BsModalRef } from 'ngx-bootstrap/modal/modal-options.class';
import { PersonalInfoService } from '../personalInfo.service';
import { PersonalInfoComponent } from '../personalInfo.component'; 

@Component({
	templateUrl: '../templates/searchComponents/gender.component.html',
	providers:[GetListService, PersonalInfoService],
	styles: [`
		#DoctorList .content{
			height:60vh;
			overflow-y: scroll;
		}
		form{
			margin-bottom: 20px;
		}
	`]
})

export class GenderComponent implements OnInit{
	constructor(private genderService: GetListService,
				private personalInfo: PersonalInfoService,
				private PIService: BsModalService
		){}
	MaleDoctors:any[] = [];
	FemaleDoctors: any[] = [];
	offset: number = 0;
	limit: number = 30;
	PersonalInfoModal: BsModalRef;
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
}