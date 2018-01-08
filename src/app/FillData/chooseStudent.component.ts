import { Component, OnInit, TemplateRef } from '@angular/core';
import { GetListService } from '../searchComponents/services/getPersonList.service';
import { ActivatedRoute } from '@angular/router';
import { BsModalService } from "ngx-bootstrap/modal";
import { BsModalRef } from 'ngx-bootstrap/modal/modal-options.class';
import { SearchSirnameService } from '../searchComponents/services/searchSirname.service';
import { CurrentCourcesListService } from './services/getCurrentCourcesList.service';
import { PersonalInfoService } from '../personalInfo.service';
import { PersonalDataService } from "../services/personalData.service";
import { Person } from '../model/person.class';
import { SaveArrivalService } from './services/saveArrival.service';
import {NotificationsService} from 'angular4-notify';
import { ShowPersonInfoService } from "../personalInfo/showPersonalInfo.service";
@Component({
	templateUrl: './templates/chooseStudent.component.html',
	styles: [`
		a.btn{
			margin-right:5px;
		}
		.newValue{
			z-index:0;
		}
	`],
	providers: [GetListService,
				BsModalService,
				CurrentCourcesListService,
				SearchSirnameService,
				PersonalInfoService,
				PersonalDataService, 
				SaveArrivalService,
				NotificationsService,
				ShowPersonInfoService]
})
export class ChooseStudentComponent implements OnInit {

	private personal_faculties: any[] = [];
	private personal_cityzenships: any[] = [];
	private personal_appointments: any[] = [];
	private personal_organizations: any[] = [];
	private personal_regions: any[] = [];
	private personal_departments: any[] = [];
	private personal_establishments: any[] = [];
	private belmapo_courses:any[] = [];

	private selectedCourse:any;
	private faculties: any[] = [];
	private educTypes: any[] = [];
	private educForms: any[] = [];
	private residance: any[] = [];

	private specialityDocArr: any[] = [];
	private specialityRetrArr: any[] = [];
	private specialityOtherArr: any[] = [];
	private qualificationMainArr: any[] = [];
	private qualificationAddArr: any[] = [];
	private qualificationOtherArr: any[] = [];

	constructor(private getList: GetListService,
				private getCourse: CurrentCourcesListService,
				private router: ActivatedRoute,
				private modalService: BsModalService,
				private search: SearchSirnameService,
				private personalInfo: PersonalInfoService,
				private dataService: PersonalDataService,
				private saveNew: SaveArrivalService,
				private notify: NotificationsService,
				private showInfo: ShowPersonInfoService) {}

	students: any[] = [];
	message: string = "";
	offset: number = 0;
	courseId:number = 0;
	modalRef: BsModalRef;
	selectedInfoModal: BsModalRef;
	setLastInfoModal: BsModalRef;
	course: any;
	selectedPerson: Person;
	originalPersonInfo:Person;
	searchResult: any[] = [];
	searchValue:string = "";
	hideNotify: boolean = false;
	ngOnInit() {
		this.getList.getList(30, this.offset, "all").then(response =>{
			this.students = response.json().data;
			this.offset +=30;
		})

		this.courseId = this.router.snapshot.params["id"];
	}
	confirmation(person:any, template: TemplateRef<any>): void{
		this.hideNotify = false;
		this.getCourse.getById(this.courseId).then(data => {
			for (var obj of data.json()) {
				this.course = obj;
			}
			this.selectedPerson = Object.assign(new Person(), person);
			this.modalRef = this.modalService.show(template, {class: 'modal-md'});
		});
	}
	setLastInfo(template:TemplateRef<any>):void{
		this.setLastInfoModal = this.modalService.show(template, {class: 'modal-md'});
	}
	save():void{
		this.saveNew.save(this.selectedPerson, this.course).then(data =>{
			this.modalService.hide(2);
			this.modalService.hide(1);
			for (var i = 0; i < this.students.length; i++) {
				if(this.students[i].id == this.selectedPerson.id){
					this.students.splice(i, 1);
					break;
				}
			}
			this.notify.addInfo("Слушатель зачислен");
		})
	}
	SaveChanges(person:any):void{
		this.personalInfo.saveChanges(person).then(data => console.log(data));
	}
	personInfo(): void{
		var id = this.selectedPerson.id;				
		this.personalInfo.getInfo(id.toString(), true).then(data => {
			console.log(data._body);
			var person = Object.assign(new Person(), data.json());
			this.showInfo.ShowPersonalInfo(person, 2, true);
		})
	}
	reject(): void{
		this.modalService.hide(1);
	}

	ValueFormatter(data:any): string{
		return `${data.value}`;
	}
	Search(event:any): void{
		if (event.target.value === "") {
			this.searchResult = [];
			this.message = "";
			return;
		}
		this.searchValue = event.target.value;
		this.search.searchPerson(this.searchValue, {personal_card: "1"}).then(data => {
			if (data.json().length !== 0) {
				this.message = "";
				this.searchResult = data.json();
			}else{
				this.searchResult = [];
				this.message = "По вашему запросу ничего не найдено";
			}
		});
	}

	LoadMore(){
		this.getList.getList(30, this.offset, "all").then(response =>{
			try{
				for (var i = 0; i < response.json().data.length; i++) {
					this.students.push(response.json().data[i]);
				}
				console.log(this.students);
				this.offset += 30;
			}catch(e){
				console.log(e);
				console.log(console.log(response._body));
			}
		})
	}
}