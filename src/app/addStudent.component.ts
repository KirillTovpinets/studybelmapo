import { Component, OnInit } from '@angular/core';
import { PersonalDataService } from "./services/personalData.service";
import { BsDatepickerConfig } from "ngx-bootstrap/datepicker";
import { listLocales } from 'ngx-bootstrap/bs-moment';
import { MatAutocompleteModule } from '@angular/material/autocomplete';
import { PersonService } from './services/savePerson.service';
import  { Person } from "./model/person.class";
import { PreloaderComponent } from "./preloader.component";
import {NotificationsService} from 'angular4-notify';

@Component({
	templateUrl: "templates/addStudent.component.html",
	providers: [PersonalDataService, PersonService, NotificationsService],
	styles: [`
		table tbody tr td{
			font-size:16px;
			color: #333;
			padding:5px;
		}
		small{
			color:#fa787e;
		}
		.input-group-addon{
			background-color:#c5c5c5;
		}
		.input-group-btn .btn{
			border-right-width:2px;
		}
		blockquote{
			border-left-color: #9368E9;
		}
		angular4-notify-notifications-container{
			position:fixed;
			bottom:20px;
			right:40px;
			z-index:10;s
		}
	`]
})

export class AddStudentComponent implements OnInit{
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
	public newPerson:Person = new Person();

	private isLoaded: boolean = false;

	private outputData:any = {};
	private newValue: string = "";
	bsValue: Date = new Date();
	minDate = new Date(1970, 1, 1);
  	maxDate = new Date();
  	locale = "ru";
  	bsConfig: Partial<BsDatepickerConfig> =  Object.assign({}, { containerClass: "theme-blue", locale: this.locale });

	constructor(private dataService: PersonalDataService,
				private saveService: PersonService,
				private notify: NotificationsService){}
	selectCourse(courseId:number){
		for (var course of this.belmapo_courses) {
			if(course.id === courseId){
				this.selectedCourse = course;
				break;
			}
		}
	}
	SavePerson(inputData:any): void{
		inputData.birthday = inputData.birthdayDate.toISOString().slice(0,10);
		inputData.diploma_start = inputData.diploma_startDate.toISOString().slice(0,10);
		this.saveService.save(inputData).then(data => {
			this.notify.addInfo(data._body);
			this.newPerson = new Person();
		});
	}
	ngOnInit():void{
		console.log(this.newPerson);
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
			this.isLoaded = true;
		});
	}

	saveNewParameter(value:string, table:string, array: any[]){
		this.outputData.value = value;
		this.outputData.table = table;

		this.saveService.saveParameter(this.outputData).then(data => {
			array.push(data.json());
			switch (table){
				case "personal_establishment":{
					this.newPerson.set_educational_establishment(data.id);
					break;
				}
				case "countries":{
					this.newPerson.set_cityzenship(data.json().id);
					break;
				}
				case "personal_appointment":{
					this.newPerson.set_appointment(data.json().id);
					break;
				}
				case "personal_organizations":{
					this.newPerson.set_organization(data.json().id);
					break;
				}
				case "personal_department":{
					this.newPerson.set_department(data.json().id);
					break;
				}
				case "personal_faculty":{
					this.newPerson.set_faculty(data.json().id);
					break;
				}
			}
			this.newValue = "";
		})
	}
}