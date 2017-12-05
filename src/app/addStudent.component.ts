import { Component, OnInit } from '@angular/core';
import { PersonalDataService } from "./services/personalData.service";
import { BsDatepickerConfig } from "ngx-bootstrap/datepicker";
import { listLocales } from 'ngx-bootstrap/bs-moment';
import { MatAutocompleteModule } from '@angular/material/autocomplete';
import { SavePersonService } from './services/savePerson.service';
import  { Person } from "./model/person.class";
import { PreloaderComponent } from "./preloader.component";
import {NotificationsService} from 'angular4-notify';

@Component({
	templateUrl: "templates/addStudent.component.html",
	providers: [PersonalDataService, SavePersonService, NotificationsService],
	styles: [`
		table tbody tr td{
			font-size:12px;
			color: #9A9A9A;
			padding:5px;
		}
		small{
			color:#fa787e;
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

	bsValue: Date = new Date();
	minDate = new Date(1970, 1, 1);
  	maxDate = new Date();
  	locale = "ru";
  	bsConfig: Partial<BsDatepickerConfig> =  Object.assign({}, { containerClass: "theme-blue", locale: this.locale });

	constructor(private dataService: PersonalDataService,
				private saveService: SavePersonService,
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
		this.saveService.save(inputData).then(data => this.notify.addInfo(data._body));
	}
	ngOnInit():void{
		this.dataService.getData().then(data => {
			console.log(data.json());
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
}