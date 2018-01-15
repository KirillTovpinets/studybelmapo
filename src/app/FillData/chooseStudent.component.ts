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
		.last-tr{
			border-bottom: 2px solid #666;
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
	isLoading: boolean = false;
	isClicked: boolean = false;
	enteredStudents: any[] = [];

	items: any[] = [];
	ngOnInit() {
		this.getList.getList(30, this.offset, "all").then(response =>{
			this.students = response.json().data;
			this.offset +=30;
		})
		this.courseId = this.router.snapshot.params["id"];

		this.getCourse.getById(this.courseId).then(data => {
			try{
				for (var obj of data.json()) {
					this.course = obj;
				}
			}catch(e){
				console.log(e);
				console.log(data._body);
			}
		});
	}
	confirmation(person:any, template: TemplateRef<any>): void{
		this.hideNotify = false;
		this.selectedPerson = Object.assign(new Person(), person);
		this.modalRef = this.modalService.show(template, {class: 'modal-md'});
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
					this.enteredStudents.push(this.students[i]);
					this.students.splice(i, 1);
					break;
				}
			}
			this.notify.addSuccess("Слушатель зачислен");
		})
	}
	SaveChanges(person:any):void{
		this.personalInfo.saveChanges(person).then(data => console.log(data));
	}
	personInfo(): void{
		var id = this.selectedPerson.id;
		if (localStorage.getItem("person-" + id) !== null) {
			this.isClicked = true;
			var person = JSON.parse(localStorage.getItem("person-" + id));
			this.showInfo.ShowPersonalInfo(person, 2, true);
			this.isClicked = false;
		}else{
			this.isClicked = true;
			this.personalInfo.getInfo(id.toString(), true).then(data => {
				var person = Object.assign(new Person(), data.json());
				localStorage.setItem("person-" + id, JSON.stringify(data.json()));
				this.showInfo.ShowPersonalInfo(person, 2, true);
				this.isClicked = false;
			})
		}
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
		this.isLoading = true;
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
			this.isLoading = false;
		})
	}
	startDrag(item){
		console.log(item);
	}
	releaseDrop(doc){
		this.enteredStudents.push(doc);
	}
	addDropItem($event){}
	dropEventMouse($event){}
	dragEnter($event){}
	dragLeave(){}
	dragoverMouse($event){}
}