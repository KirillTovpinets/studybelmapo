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
				NotificationsService]
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
				private notify: NotificationsService) {}

	students: any[] = [];
	message: string = "";
	offset: number = 0;
	courseId:number = 0;
	modalRef: BsModalRef;
	selectedInfoModal: BsModalRef;
	setLastInfoModal: BsModalRef;
	course: any;
	selectedPerson: Person;
	searchResult: any[] = [];
	searchValue:string = "";
	hideNotify: boolean = false;
	ngOnInit() {
		this.getList.getList(30, this.offset, "all").then(response =>{
			this.students = response.json().data;
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
			this.notify.addInfo("Слушатель зачислен");
			// console.log(data._body);
			setTimeout(() => this.hideNotify = true, 2000)
		})
	}
	forward(template:TemplateRef<any>): void{
		var id = this.selectedPerson.id;

		this.dataService.getData().then(data => {
			for (let faculty of data.json().facBel) {
				this.faculties.push(faculty);
			}
			for (let type of data.json().educTypeBel) {
				this.educTypes.push(type);
			}
			for (let form of data.json().formBel) {
				this.educForms.push(form);
			}
			for (let resid of data.json().belmapo_residence) {
				this.residance.push(resid);
			}
			for (var faculty of data.json().facArr) {
				this.personal_faculties.push(faculty);
			}
			for (var citizenship of data.json().residArr) {
				this.personal_cityzenships.push(citizenship);
			}
			for (var appointment of data.json().appArr) {
				this.personal_appointments.push(appointment);
			}
			for (var organization of data.json().orgArr) {
				this.personal_organizations.push(organization);
			}
			for (var region of data.json().regArr) {
				this.personal_regions.push(region);
			}
			for (var department of data.json().depArr) {
				this.personal_departments.push(department);
			}
			for (var establishment of data.json().estArr) {
				this.personal_establishments.push(establishment);
			}
			for (var citizenship of data.json().residArr) {
				this.personal_cityzenships.push(citizenship);
			}
			for (var course of data.json().coursesBel) {
				this.belmapo_courses.push(course);
			}

			for (var obj of data.json().specialityDocArr) {
				this.specialityDocArr.push(obj);
			}			
				
			for (var obj of data.json().specialityRetrArr) {
				this.specialityRetrArr.push(obj);
			}				
				
			for (var obj of data.json().specialityOtherArr) {
				this.specialityOtherArr.push(obj);
			}				
				
			for (var obj of data.json().qualificationMainArr) {
				this.qualificationMainArr.push(obj);
			}				
				
			for (var obj of data.json().qualificationAddArr) {
				this.qualificationAddArr.push(obj);
			}				
				
			for (var obj of data.json().qualificationOtherArr) {
				this.qualificationOtherArr.push(obj);
			}				
				
			// this.isLoaded = true;
			this.personalInfo.getInfo(id.toString(), true).then(data => {
				this.selectedPerson = Object.assign(this.selectedPerson, data.json());
				this.selectedInfoModal = this.modalService.show(template, {class: 'modal-lg'});
			})
		});
	}
	reject(): void{
		this.modalService.hide(1);
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
}