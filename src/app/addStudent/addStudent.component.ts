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
import { LogService } from '../share/log.service';
import { NgForm } from '@angular/forms';
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
	@ViewChild("addForm") form: NgForm;
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
	public findPerson: any = {};
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
	renewData = [];
  	dataKeys: string[] = [
		"faculties",
		"educType",
		"formofeducation",
		"Residence",
		"personal_faculty",
		"countries",
		"personal_appointment",
		"personal_organizations",
		"regions",
		"personal_department",
		"personal_establishment",
		"speciality_doct",
		"speciality_retraining",
		"speciality_other",
		"qualification_main",
		"qualification_add",
		"qualification_other",
		"cities"
	  ];
	constructor(private dataService: PersonalDataService,
				private saveService: PersonService,
				private notify: NotificationsService,
				private router: ActivatedRoute,
				private routerNav: Router,
				private modal: BsModalService,
				private log: LogService){}
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
 			this.notify.addInfo("Cлушатель зачислен");
 			this.isChecked = false;
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
		
		for(let key of this.dataKeys){
			if (localStorage.getItem(key) == null) {
				this.renewData.push(key);
			}else{
				switch (key) {
					case "faculties":
						this.faculties = JSON.parse(localStorage.getItem("faculties"));
						break;
					case "educType":
						this.educTypes = JSON.parse(localStorage.getItem("educType"));
						break;
					case "formofeducation":
						this.educForms = JSON.parse(localStorage.getItem("formofeducation"));
						break;
					case "Residence":
						this.residance = JSON.parse(localStorage.getItem("Residence"));
						this.personal_cityzenships = JSON.parse(localStorage.getItem("Residence"));
						break;
					case "personal_faculty":
						this.personal_faculties = JSON.parse(localStorage.getItem("personal_faculty"));
						break;
					case "personal_appointment":
						this.personal_appointments = JSON.parse(localStorage.getItem("personal_appointment"));
						break;
					case "personal_organizations":
						this.personal_organizations = JSON.parse(localStorage.getItem("personal_organizations"));
						break;
					case "regions":
						this.personal_regions = JSON.parse(localStorage.getItem("regions"));
						this.all_regions = this.personal_regions;
						break;
					case "personal_department":
						this.personal_departments = JSON.parse(localStorage.getItem("personal_department"));
						break;
					case "personal_establishment":
						this.personal_establishments = JSON.parse(localStorage.getItem("personal_establishment"));
						break;
					case "residArr":
						this.personal_cityzenships = JSON.parse(localStorage.getItem("residArr"));
						this.all_countries = this.personal_cityzenships;
						break;
					case "speciality_doct":
						this.specialityDocArr = JSON.parse(localStorage.getItem("speciality_doct"));
						break;
					case "speciality_retraining":
						this.specialityRetrArr = JSON.parse(localStorage.getItem("speciality_retraining"));
						break;
					case "speciality_other":
						this.specialityOtherArr = JSON.parse(localStorage.getItem("speciality_other"));
						break;
					case "qualification_main":
						this.qualificationMainArr = JSON.parse(localStorage.getItem("qualification_main"));
						break;
					case "qualification_add":
						this.qualificationAddArr = JSON.parse(localStorage.getItem("qualification_add"));
						break;
					case "qualification_other":
						this.qualificationOtherArr = JSON.parse(localStorage.getItem("qualification_other"));
						break;
					case "cities":
						this.personal_cities = JSON.parse(localStorage.getItem("cities"));
						this.all_cities = this.personal_cities;
						break;
				}
			}
		}
		if (this.renewData.length != 0) {
			this.dataService.getData(this.renewData).then(data => {
				try{
					if(data.json().faculties !== undefined){
						this.faculties = data.json().faculties;
						localStorage.setItem("faculties", JSON.stringify(data.json().faculties))
					}
					if(data.json().educType !== undefined){
						this.educTypes = data.json().educType;
						localStorage.setItem("educType", JSON.stringify(data.json().educType))
					}
					if(data.json().formofeducation !== undefined){
						this.educForms = data.json().formofeducation;
						localStorage.setItem("formofeducation", JSON.stringify(data.json().formofeducation))
					}
					if(data.json().Residence !== undefined){
						this.residance = data.json().Residence;
						localStorage.setItem("Residence", JSON.stringify(data.json().Residence))
					}
					if(data.json().personal_faculty !== undefined){
						this.personal_faculties = data.json().personal_faculty;
						localStorage.setItem("personal_faculty", JSON.stringify(data.json().personal_faculty))
					}
					if(data.json().countries !== undefined){
						this.personal_cityzenships = data.json().countries;
						this.all_countries = this.personal_cityzenships;
						localStorage.setItem("countries", JSON.stringify(data.json().countries))
					}
					if(data.json().personal_appointment !== undefined){
						this.personal_appointments = data.json().personal_appointment;
						localStorage.setItem("personal_appointment", JSON.stringify(data.json().personal_appointment))
					}
					if(data.json().personal_organizations !== undefined){
						this.personal_organizations = data.json().personal_organizations;
						localStorage.setItem("personal_organizations", JSON.stringify(data.json().personal_organizations))
					}
					if(data.json().regions !== undefined){
						this.personal_regions = data.json().regions;
						this.all_regions = this.personal_regions;
						localStorage.setItem("regions", JSON.stringify(data.json().regions))
					}
					if(data.json().personal_department !== undefined){
						this.personal_departments = data.json().personal_department;
						localStorage.setItem("personal_department", JSON.stringify(this.personal_departments))
					}
					if(data.json().personal_establishment !== undefined){
						this.personal_establishments = data.json().personal_establishment;
						localStorage.setItem("personal_establishment", JSON.stringify(this.personal_establishments))
					}
					if(data.json().speciality_doct !== undefined){
						this.specialityDocArr = data.json().speciality_doct;
						localStorage.setItem("speciality_doct", JSON.stringify(data.json().speciality_doct))
					}
					if(data.json().speciality_retraining !== undefined){
						this.specialityRetrArr = data.json().speciality_retraining;
						localStorage.setItem("speciality_retraining", JSON.stringify(data.json().speciality_retraining))
					}
					if(data.json().speciality_other !== undefined){
						this.specialityOtherArr = data.json().speciality_other;
						localStorage.setItem("speciality_other", JSON.stringify(data.json().speciality_other))
					}
					if(data.json().qualification_main !== undefined){
						this.qualificationMainArr = data.json().qualification_main;
						localStorage.setItem("qualification_main", JSON.stringify(data.json().qualification_main))
					}
					if(data.json().qualification_add !== undefined){
						this.qualificationAddArr = data.json().qualification_add;
						localStorage.setItem("qualification_add", JSON.stringify(data.json().qualification_add))
					}
					if(data.json().qualification_other !== undefined){
						this.qualificationOtherArr = data.json().qualification_other;
						localStorage.setItem("qualification_other", JSON.stringify(data.json().qualification_other))
					}
					if(data.json().cities !== undefined){
						this.personal_cities = data.json().cities;
						this.all_cities = this.personal_cities;
						localStorage.setItem("cities", JSON.stringify(data.json().citiesArr))
					}
					this.isLoaded = true;
				}catch(e){
					localStorage.clear();
					if(data.json().faculties !== undefined){
						this.faculties = data.json().faculties;
						localStorage.setItem("faculties", JSON.stringify(data.json().faculties))
					}
					if(data.json().educType !== undefined){
						this.educTypes = data.json().educType;
						localStorage.setItem("educType", JSON.stringify(data.json().educType))
					}
					if(data.json().formofeducation !== undefined){
						this.educForms = data.json().formofeducation;
						localStorage.setItem("formofeducation", JSON.stringify(data.json().formofeducation))
					}
					if(data.json().Residence !== undefined){
						this.residance = data.json().Residence;
						localStorage.setItem("Residence", JSON.stringify(data.json().Residence))
					}
					if(data.json().personal_faculty !== undefined){
						this.personal_faculties = data.json().personal_faculty;
						localStorage.setItem("personal_faculty", JSON.stringify(data.json().personal_faculty))
					}
					if(data.json().countries !== undefined){
						this.personal_cityzenships = data.json().countries;
						this.all_countries = this.personal_cityzenships;
						localStorage.setItem("countries", JSON.stringify(data.json().countries))
					}
					if(data.json().personal_appointment !== undefined){
						this.personal_appointments = data.json().personal_appointment;
						localStorage.setItem("personal_appointment", JSON.stringify(data.json().personal_appointment))
					}
					if(data.json().personal_organizations !== undefined){
						this.personal_organizations = data.json().personal_organizations;
						localStorage.setItem("personal_organizations", JSON.stringify(data.json().personal_organizations))
					}
					if(data.json().regions !== undefined){
						this.personal_regions = data.json().regions;
						this.all_regions = this.personal_regions;
						localStorage.setItem("regions", JSON.stringify(data.json().regions))
					}
					if(data.json().personal_department !== undefined){
						this.personal_departments = data.json().personal_department;
						localStorage.setItem("personal_department", JSON.stringify(this.personal_departments))
					}
					if(data.json().personal_establishment !== undefined){
						this.personal_establishments = data.json().personal_establishment;
						localStorage.setItem("personal_establishment", JSON.stringify(this.personal_establishments))
					}
					if(data.json().speciality_doct !== undefined){
						this.specialityDocArr = data.json().speciality_doct;
						localStorage.setItem("speciality_doct", JSON.stringify(data.json().speciality_doct))
					}
					if(data.json().speciality_retraining !== undefined){
						this.specialityRetrArr = data.json().speciality_retraining;
						localStorage.setItem("speciality_retraining", JSON.stringify(data.json().speciality_retraining))
					}
					if(data.json().speciality_other !== undefined){
						this.specialityOtherArr = data.json().speciality_other;
						localStorage.setItem("speciality_other", JSON.stringify(data.json().speciality_other))
					}
					if(data.json().qualification_main !== undefined){
						this.qualificationMainArr = data.json().qualification_main;
						localStorage.setItem("qualification_main", JSON.stringify(data.json().qualification_main))
					}
					if(data.json().qualification_add !== undefined){
						this.qualificationAddArr = data.json().qualification_add;
						localStorage.setItem("qualification_add", JSON.stringify(data.json().qualification_add))
					}
					if(data.json().qualification_other !== undefined){
						this.qualificationOtherArr = data.json().qualification_other;
						localStorage.setItem("qualification_other", JSON.stringify(data.json().qualification_other))
					}
					if(data.json().cities !== undefined){
						this.personal_cities = data.json().cities;
						this.all_cities = this.personal_cities;
						localStorage.setItem("cities", JSON.stringify(data.json().citiesArr))
					}
				}
				
			});
		}else{
			this.isLoaded = true;
		}
	}
	saveNewParameter(value:string, table:string, array: any[]){
		this.outputData.value = value;
		this.outputData.table = table;

		array.forEach(element => {
			if(value == element.value){
				this.notify.addWarning("Этот вариант уже существует");
				return;
			}
		});

		this.saveService.saveParameter(this.outputData).then(data => {
			array.push(data.json());
			console.log(data.json());

			switch (table){
				case "personal_establishment":{
					this.newPerson.profesional.educational_establishment = data.json();
					break;
				}
				case "countries":{
					this.newPerson.personal.cityzenship = data.json();
					break;
				}
				case "personal_appointment":{
					this.newPerson.general.appointment = data.json();
					break;
				}
				case "personal_organizations":{
					this.newPerson.general.organization = data.json();
					break;
				}
				case "personal_department":{
					this.newPerson.general.department = data.json();
					break;
				}
				case "personal_faculty":{
					this.newPerson.profesional.faculty = data.json();
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
				let data = response.json();
				if ( data.surname !== undefined) {
					this.findPerson = data;
					this.alreadyExist = this.modal.show(this.exist, {class: "modal-md"});
				}else if(data.length == 0){
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
			}).catch((e) => {
				this.notify.addError("Что-то пошло не так. Обратитесь к администратору");
				console.log(e);
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