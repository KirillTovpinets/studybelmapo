import { Component, OnInit, TemplateRef, ViewChild } from '@angular/core';
import { PersonalDataService } from "../personalInfo/personalData.service";
import { BsDatepickerConfig } from "ngx-bootstrap/datepicker";
import { BsModalService, TabsetComponent } from 'ngx-bootstrap';
import { BsModalRef } from 'ngx-bootstrap/modal/bs-modal-ref.service';
import { MatAutocompleteModule } from '@angular/material/autocomplete';
import { PersonService } from './savePerson.service';
import  { Person } from "../model/person.class";
import { PreloaderComponent } from "../preloader/preloader.component";
import { NotificationsService } from 'angular4-notify';
import { ActivatedRoute, Router } from '@angular/router';
import { Retraining } from '../model/profesionInfo.class';
@Component({
	templateUrl: "./addStudent.component.html",
	providers: [PersonalDataService, PersonService, BsModalService],
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
		fieldset{
			padding:20px;
			margin-bottom:10px;
		}
		.tab-content{
			padding:20px;
		}
		tabset input, select{
			margin-bottom:10px;
		}
		.newValue{
			z-index:0;
		}
		.no-padding{
			padding:0px;
		}
		tabset input{
			margin:0px;
		}
		tabset .input-group{
			margin-top:10px;
		}
		legend,
		legend h5,
		.form-group,
		fieldset{
			margin:0;
		}
	`]
})

export class AddStudentComponent implements OnInit{
	@ViewChild("tabSet") tabSet: TabsetComponent
	@ViewChild("existTpl") exist: TemplateRef<any>;
	private personal_faculties: any[] = [];
	
	private personal_appointments: any[] = [];
	private personal_organizations: any[] = [];
	private personal_cityzenships: any[] = [];
	private all_countries: any[] = [];
	private personal_regions: any[] = [];
	private all_regions: any[] = [];
	private personal_cities:any[] = [];
	private all_cities: any[] = [];
	
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

	public newPerson:Person = new Person();
	public tempData:Person = new Person();
	public originalData:Person = new Person();
	private isLoaded: boolean = false;
	private isChecked:boolean = false;

	private outputData:any = {};
	private newValue: string = "";
	private fillDataModal: BsModalRef;
	bsValue: Date = new Date();
	minDate = new Date(1900, 1, 1);
  	maxDate = new Date();
  	locale = "ru";
  	courseId:number = 0;
  	bsConfig: Partial<BsDatepickerConfig> =  Object.assign({}, { containerClass: "theme-blue", locale: "ru", dateInputFormat: 'DD.MM.YYYY' });
  	alreadyExist: BsModalRef;
  	activateTab: boolean = false;
  	dataKeys: string[] = [
		"facBel",
		"educTypeBel",
		"formBel",
		"belmapo_residence",
		"facArr",
		"residArr",
		"appArr",
		"orgArr",
		"regArr",
		"depArr",
		"estArr",
		"residArr",
		"coursesBel",
		"specialityDocArr",
		"specialityRetrArr",
		"specialityOtherArr",
		"qualificationMainArr",
		"qualificationAddArr",
		"qualificationOtherArr",
		"citiesArr"
  	];
	constructor(private dataService: PersonalDataService,
				private saveService: PersonService,
				private notify: NotificationsService,
				private router: ActivatedRoute,
				private routerNav: Router,
				private modal: BsModalService){}
	selectCourse(courseId:number){
		for (var course of this.belmapo_courses) {
			if(course.id === courseId){
				this.selectedCourse = course;
				break;
			}
		}
	}
	SavePerson(inputData:any): void{
 		if (inputData.personal.birthdayDate !== undefined) {
 			inputData.personal.birthday = inputData.personal.birthdayDate.toISOString().slice(0,10);
 		}
 		if (inputData.personal.pasportDate !== undefined) {
 			inputData.personal.pasport_date = inputData.personal.pasportDate.toISOString().slice(0,10);
 		}
 
 		if (inputData.profesional.diploma_startDate !== undefined) {
 			inputData.profesional.diploma_start = inputData.profesional.diploma_startDate.toISOString().slice(0,10);
 		}
 		if (inputData.profesional.mainCategoryDate !== undefined) {
 			inputData.profesional.mainCategory_date = inputData.profesional.mainCategoryDate.toISOString().slice(0,10);
 		}
 		if (inputData.profesional.addCategoryDate !== undefined) {
 			inputData.profesional.addCategory_date = inputData.profesional.addCategoryDate.toISOString().slice(0,10);
 		}
 		if (inputData.profesional.speciality_retraining_diploma_startDate !== undefined) {
 			inputData.profesional.speciality_retraining_diploma_start_date = inputData.profesional.speciality_retraining_diploma_startDate.toISOString().slice(0,10);
 		}
 		if (inputData.profesional.speciality_retraining.length > 0) {
 			for (var i = 0; i < inputData.profesional.speciality_retraining.length; i++) {
 				inputData.profesional.speciality_retraining[i].diploma_start = inputData.profesional.speciality_retraining[i].diploma_startDate.toISOString().slice(0,10);
 			}
 		}
 		if (inputData.sience.statusApproveDate !== undefined) {
 			inputData.sience.statusApprove_date = inputData.sience.statusApproveDate.toISOString().slice(0,10);
 		}
 		inputData.belmapo_course = this.courseId;
 		this.saveService.save(inputData).then(data => {
 			console.log(data._body);
 			this.notify.addInfo("Cлушатель зачислен");
 			this.isChecked = false;
 			this.newPerson = new Person();
 			this.modal.hide(1);
 		});
 	}
	NextTab(tabId:number){
		tabId += 1;
  		this.tabSet.tabs[tabId].active = true;
  	}
	DropdownList(data:any):string{
		return data.value;
	}
	fillLastInfo(template: TemplateRef<any>):void{
		this.fillDataModal = this.modal.show(template, {class: "modal-md"});
	}
	ngOnInit():void{
		this.courseId = this.router.snapshot.params["id"];
		var renewData = [];
		for(let key of this.dataKeys){
			if (localStorage.getItem(key) == null) {
				renewData.push(key);
			}else{
				switch (key) {
					case "facBel":
						this.faculties = JSON.parse(localStorage.getItem("facBel"));
						break;
					case "educTypeBel":
						this.educTypes = JSON.parse(localStorage.getItem("educTypeBel"));
						break;
					case "formBel":
						this.educForms = JSON.parse(localStorage.getItem("formBel"));
						break;
					case "belmapo_residence":
						this.residance = JSON.parse(localStorage.getItem("belmapo_residence"));
						break;
					case "facArr":
						this.personal_faculties = JSON.parse(localStorage.getItem("facArr"));
						break;
					case "residArr":
						this.personal_cityzenships = JSON.parse(localStorage.getItem("residArr"));
						break;
					case "appArr":
						this.personal_appointments = JSON.parse(localStorage.getItem("appArr"));
						break;
					case "orgArr":
						this.personal_organizations = JSON.parse(localStorage.getItem("orgArr"));
						break;
					case "regArr":
						this.personal_regions = JSON.parse(localStorage.getItem("regArr"));
						this.all_regions = this.personal_regions;
						break;
					case "depArr":
						this.personal_departments = JSON.parse(localStorage.getItem("depArr"));
						break;
					case "estArr":
						this.personal_establishments = JSON.parse(localStorage.getItem("estArr"));
						break;
					case "residArr":
						this.personal_cityzenships = JSON.parse(localStorage.getItem("residArr"));
						this.all_countries = this.personal_cityzenships;
						break;
					case "coursesBel":
						this.belmapo_courses = JSON.parse(localStorage.getItem("coursesBel"));
						break;
					case "specialityDocArr":
						this.specialityDocArr = JSON.parse(localStorage.getItem("specialityDocArr"));
						break;
					case "specialityRetrArr":
						this.specialityRetrArr = JSON.parse(localStorage.getItem("specialityRetrArr"));
						break;
					case "specialityOtherArr":
						this.specialityOtherArr = JSON.parse(localStorage.getItem("specialityOtherArr"));
						break;
					case "qualificationMainArr":
						this.qualificationMainArr = JSON.parse(localStorage.getItem("qualificationMainArr"));
						break;
					case "qualificationAddArr":
						this.qualificationAddArr = JSON.parse(localStorage.getItem("qualificationAddArr"));
						break;
					case "qualificationOtherArr":
						this.qualificationOtherArr = JSON.parse(localStorage.getItem("qualificationOtherArr"));
						break;
					case "citiesArr":
						this.personal_cities = JSON.parse(localStorage.getItem("citiesArr"));
						this.all_cities = this.personal_cities;
						break;
				}
			}
		}
		if (renewData.length != 0) {
			this.dataService.getData().then(data => {
				try{
					this.faculties = data.json().facBel;
					localStorage.setItem("facBel", JSON.stringify(data.json().facBel))
					this.educTypes = data.json().educTypeBel;
					localStorage.setItem("educTypeBel", JSON.stringify(data.json().educTypeBel))
					this.educForms = data.json().formBel;
					localStorage.setItem("formBel", JSON.stringify(data.json().formBel))
					this.residance = data.json().belmapo_residence;
					localStorage.setItem("belmapo_residence", JSON.stringify(data.json().belmapo_residence))
					this.personal_faculties = data.json().facArr;
					localStorage.setItem("facArr", JSON.stringify(data.json().facArr))
					this.personal_cityzenships = data.json().residArr;
					this.all_countries = this.personal_cityzenships;
					localStorage.setItem("residArr", JSON.stringify(data.json().residArr))
					this.personal_appointments = data.json().appArr;
					localStorage.setItem("appArr", JSON.stringify(data.json().appArr))
					this.personal_organizations = data.json().orgArr;
					localStorage.setItem("orgArr", JSON.stringify(data.json().orgArr))
					this.personal_regions = data.json().regArr;
					this.all_regions = this.personal_regions;
					localStorage.setItem("regArr", JSON.stringify(data.json().regArr))
					this.personal_departments = data.json().depArr;
					localStorage.setItem("depArr", JSON.stringify(data.json().depArr))
					this.personal_establishments = data.json().estArr;
					localStorage.setItem("estArr", JSON.stringify(data.json().estArr))
					this.belmapo_courses = data.json().coursesBel;
					localStorage.setItem("coursesBel", JSON.stringify(data.json().coursesBel))
					this.specialityDocArr = data.json().specialityDocArr;
					localStorage.setItem("specialityDocArr", JSON.stringify(data.json().specialityDocArr))
					this.specialityRetrArr = data.json().specialityRetrArr;
					localStorage.setItem("specialityRetrArr", JSON.stringify(data.json().specialityRetrArr))
					this.specialityOtherArr = data.json().specialityOtherArr;
					localStorage.setItem("specialityOtherArr", JSON.stringify(data.json().specialityOtherArr))
					this.qualificationMainArr = data.json().qualificationMainArr;
					localStorage.setItem("qualificationMainArr", JSON.stringify(data.json().qualificationMainArr))
					this.qualificationAddArr = data.json().qualificationAddArr;
					localStorage.setItem("qualificationAddArr", JSON.stringify(data.json().qualificationAddArr))
					this.qualificationOtherArr = data.json().qualificationOtherArr;
					localStorage.setItem("qualificationOtherArr", JSON.stringify(data.json().qualificationOtherArr))
					this.personal_cities = data.json().citiesArr;
					this.all_cities = this.personal_cities;
					// localStorage.setItem("citiesArr", JSON.stringify(data.json().citiesArr))
					this.isLoaded = true;
				}catch(e){
					console.log(e);
					console.log(data._body);
				}
				
			});
		}else{
			this.isLoaded = true;
		}
	}
	saveNewParameter(value:string, table:string, array: any[]){
		this.outputData.value = value;
		this.outputData.table = table;

		switch (table){
			case "personal_establishment":{
				for (var i = this.personal_establishments.length - 1; i >= 0; i--) {
					if (this.personal_establishments[i].value == value) {
						this.notify.addWarning("Этот вариант уже существует");
						return;
					}
					
				}
				break;
			}
			case "countries":{
				for (var i = this.personal_cityzenships.length - 1; i >= 0; i--) {
					if (this.personal_cityzenships[i].value == value) {
						this.notify.addWarning("Этот вариант уже существует");
						return;
					}
					
				}
				break;
			}
			case "personal_appointment":{
				for (var i = this.personal_appointments.length - 1; i >= 0; i--) {
					if (this.personal_appointments[i].value == value) {
						this.notify.addWarning("Этот вариант уже существует");
						return;
					}
					
				}
				break;
			}
			case "personal_organizations":{
				for (var i = this.personal_organizations.length - 1; i >= 0; i--) {
					if (this.personal_organizations[i].value == value) {
						this.notify.addWarning("Этот вариант уже существует");
						return;
					}
					
				}
				break;
			}
			case "personal_department":{
				for (var i = this.personal_departments.length - 1; i >= 0; i--) {
					if (this.personal_departments[i].value == value) {
						this.notify.addWarning("Этот вариант уже существует");
						return;
					}
					
				}
				break;
			}
			case "personal_faculty":{
				for (var i = this.personal_faculties.length - 1; i >= 0; i--) {
					if (this.personal_faculties[i].value == value) {
						this.notify.addWarning("Этот вариант уже существует");
						return;
					}
					
				}
				break;
			}
		}

		this.saveService.saveParameter(this.outputData).then(data => {
			array.push(data.json());

			switch (table){
				case "personal_establishment":{
					this.newPerson.profesional.educational_establishment = data.id;
					break;
				}
				case "countries":{
					this.newPerson.personal.cityzenship = data.json().id;
					break;
				}
				case "personal_appointment":{
					this.newPerson.general.appointment = data.json().id;
					break;
				}
				case "personal_organizations":{
					this.newPerson.general.organization = data.json().id;
					break;
				}
				case "personal_department":{
					this.newPerson.general.department = data.json().id;
					break;
				}
				case "personal_faculty":{
					this.newPerson.profesional.faculty = data.json().id;
					break;
				}
			}
			this.newValue = "";
		})
	}
	AddRetraining(){
 		this.newPerson.profesional.speciality_retraining.push(new Retraining());
 	}
 	RemoveRetraining(){
 		this.newPerson.profesional.speciality_retraining.pop();	
 	}
	Check(){
		if (!this.isChecked) {
			this.dataService.check(this.newPerson).then(response => {
				if (response._body == "Exist") {
					this.alreadyExist = this.modal.show(this.exist, {class: "modal-md"});
				}else if(response._body == "Not exist"){
					// var id = this.newPerson.personal.insurance_number;
					// var gender = Number(id.slice(0,1));
					// if (gender == 1 || gender == 3 || gender == 5) {
					// 	this.newPerson.personal.isMale = true;
					// }else{
					// 	this.newPerson.personal.isMale = false;
					// }
					// var century = 0;
					// if (gender == 1 || gender == 2) {
					// 	century = 1800;
					// }else if(gender == 3 || gender == 4){
					// 	century = 1900;
					// }else if(gender == 5 || gender == 6){
					// 	century = 2000;
					// }

					// var dayBth = Number(id.slice(1,3));
					// var monthBth = Number(id.slice(3,5));
					// var yearBth = Number(id.slice(5,7));
					// var fullyear = century + yearBth;
					// var birthdayDate = new Date(fullyear, monthBth - 1, dayBth);
					// this.newPerson.personal.birthdayDate = birthdayDate;
					// var region = id.slice(7,8);
					// var citizenship = id.slice(11,13);
					// if (citizenship == "PB" || citizenship == "РВ") {
					// 	for(let ctr of this.personal_cityzenships){
					// 		console.log(ctr);
					// 		if (ctr.id == 5) {
					// 			this.newPerson.personal.cityzenship = ctr;
					// 			break;
					// 		}
					// 	}
					// }

					this.activateTab = true;
					setTimeout(() => {
						this.tabSet.tabs[1].active = true
					}, 200);
				}else{
					console.log(response._body);
				}
			});
		}
	}
	Confirm(){
		this.routerNav.navigate(['../../chooseStudent', this.courseId], {relativeTo: this.router});
		this.modal.hide(1);
	}
	Hide(){
		this.modal.hide(1);
  	}
  	ValidateExp($event){
  		console.log($event);
  		var value = $event.target.value;
  		if (value > this.newPerson.profesional.experiance_general) {
  			$event.target.classList.remove("ng-valid");
  			$event.target.classList.add("ng-invalid");
  		}else{
  			$event.target.classList.remove("ng-invalid");
  			$event.target.classList.add("ng-valid");
  		}
  	}
  	checkAutoCountry($event){
  		this.personal_cities = [];
  		for(let city of this.all_cities){
  			if (city.country == $event.id) {
  				this.personal_cities.push(city);
  			}
  		}
  	}
  	checkAutoRegion($event){
  		this.personal_cities = [];
  		for(let city of this.all_cities){
  			if (city.region == $event.id) {
  				this.personal_cities.push(city);
  			}
  		}
  	}
  	createMaskHome($event){
  		if ($event.key == "Backspace") {
  			return;
  		}
  		if (this.newPerson.personal.tel_number_home[this.newPerson.personal.tel_number_home.length - 1] == ')' ||
  			this.newPerson.personal.tel_number_home[this.newPerson.personal.tel_number_home.length - 1] == '-') {
  			return;
  		}
  		if (this.newPerson.personal.tel_number_home.length == 3) {
  			this.newPerson.personal.tel_number_home += ")";
  		}
  		if (this.newPerson.personal.tel_number_home.length == 7 ||
  			this.newPerson.personal.tel_number_home.length == 10) {
  			this.newPerson.personal.tel_number_home += "-";
  		}
  	}
  	NumberStartHome(){
  		if (this.newPerson.personal.tel_number_home != undefined) {
  			return;
  		}
  		this.newPerson.personal.tel_number_home = "(";
  	}

  	createMaskWork($event){
  		if ($event.key == "Backspace") {
  			return;
  		}
  		if (this.newPerson.personal.tel_number_work[this.newPerson.personal.tel_number_work.length - 1] == ')' ||
  			this.newPerson.personal.tel_number_work[this.newPerson.personal.tel_number_work.length - 1] == '-') {
  			return;
  		}
  		if (this.newPerson.personal.tel_number_work.length == 3) {
  			this.newPerson.personal.tel_number_work += ")";
  		}
  		if (this.newPerson.personal.tel_number_work.length == 7 ||
  			this.newPerson.personal.tel_number_work.length == 10) {
  			this.newPerson.personal.tel_number_work += "-";
  		}
  	}
  	NumberStartWork(){
  		if (this.newPerson.personal.tel_number_work != undefined) {
  			return;
  		}
  		this.newPerson.personal.tel_number_work = "(";
  	}

  	createMaskMobile($event){
  		if ($event.key == "Backspace") {
  			return;
  		}
  		if (this.newPerson.personal.tel_number_mobile[this.newPerson.personal.tel_number_mobile.length - 1] == ')' ||
  			this.newPerson.personal.tel_number_mobile[this.newPerson.personal.tel_number_mobile.length - 1] == '-') {
  			return;
  		}
  		if (this.newPerson.personal.tel_number_mobile.length == 3) {
  			this.newPerson.personal.tel_number_mobile += ")";
  		}
  		if (this.newPerson.personal.tel_number_mobile.length == 7 ||
  			this.newPerson.personal.tel_number_mobile.length == 10) {
  			this.newPerson.personal.tel_number_mobile += "-";
  		}
  	}

  	NumberStartMobile(){
  		if (this.newPerson.personal.tel_number_mobile != undefined) {
  			return;
  		}
  		this.newPerson.personal.tel_number_mobile = "(";
  	}
  	setCorrectDate(){
  		
  	}
}