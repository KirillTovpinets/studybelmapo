import { Component, OnInit, ViewChild } from '@angular/core';
import { InfoService } from './studList.service';
import { AccordionModule, TabsetComponent } from 'ngx-bootstrap';
import { CurrentCourcesListService } from '../FillData/services/getCurrentCourcesList.service';
import { Course } from '../model/course.class';
import { Global } from '../model/global.class';
import { PersonalDataService } from '../personalInfo/personalData.service';
import {NotificationsService} from 'angular4-notify';
import { StudListService } from './stud-list.service';
declare var $: any;
@Component({
	templateUrl: "./studList.component.html",
	providers: [InfoService, CurrentCourcesListService, PersonalDataService],
	styles:[`
		tr.active,
		tr.active>td{
			background-color:#63d8f1 !important;
			color:#fff;
			font-weight:bold;
		}
		.nested:hover,
		.nested{
			background:#FFF !important;
		}
		[accordion-heading]:first-letter{
			text-transform: capitalize;
		}
		.pull-right{
			font-style:italic;
		}
	`]
})

export class StudListComponent implements OnInit{
	@ViewChild("courseLists") coursesTabs: TabsetComponent;
	courseList: any[] = [];
	oldCourses: any[] = [];
	currentCourses: any[] = [];
	futureCourses: any[] = [];
	cathedras: string[] = [];
	faculties: any[] = [];
	prevRow: any;
	message:string = "";
	isLoading: boolean = false;
	newCourse: Course = new Course();
	global: Global = new Global();
	types: any[] = [];
	currentUser: any;
	cathedraClass: string = "panel-default";
	deducts:number;
	ArchiveIsLoaded: boolean = false;
	archive: any[] = [];
	ArchiveYearIsLoaded: boolean = false;
	nowYear: number = new Date().getFullYear();
	constructor(private info: InfoService,
				private getList: CurrentCourcesListService,
				private dataSrv: PersonalDataService,
				private notify: NotificationsService,
				private students: StudListService){}

	ngOnInit(): void{
		this.students.currentTotal.subscribe(total => this.deducts = total);
		this.currentUser = JSON.parse(localStorage.getItem("currentUser"));
		this.isLoading = true;
		if (this.currentUser.is_cathedra == 0) {
			this.info.getInfo("getStat").then(data => this.faculties = data.json().data);
		}else{
			this.getList.get().then(data => {
				try{
					this.courseList = data.json();
					var today = new Date();
					for (var i = 0; i < this.courseList.length; i++) {
						var start = new Date(this.courseList[i].Start);
						var finish = new Date(this.courseList[i].Finish);
						
						if (start < today && finish < today) {
							this.oldCourses.push(this.courseList[i]);
							this.courseList[i].class=1;
						}else if(start < today && finish > today){
							this.currentCourses.push(this.courseList[i]);
							this.courseList[i].class=2;
						}else if(start > today && finish > today){
							this.futureCourses.push(this.courseList[i]);
							this.courseList[i].class=3;
						}
					}
					this.isLoading = false;
				}catch(e){
					this.message = data._body;
				}
			});
			this.dataSrv.getTypeList().then(res => this.types = res.json());
		}
		this.isLoading = false;
		if (this.coursesTabs !== undefined) {
			this.coursesTabs.tabs[0].active = false;
			this.coursesTabs.tabs[2].active = true;
		}
	}

	showListOfListners(course:any): void {
		if (this.prevRow != undefined && this.prevRow !== course) {
			this.prevRow.isOpened = false;
		}
		course.isOpened = !course.isOpened;
		this.prevRow = course;
	}
	SaveCourse(){
		this.newCourse.startStr = this.newCourse.start.toISOString().slice(0,10);
		this.newCourse.finishStr = this.newCourse.finish.toISOString().slice(0,10);
		this.info.saveCourse(this.newCourse).then(res => this.notify.addInfo("Курс добавлен"))
		this.newCourse = new Course();
	}

	onChanges(course:any){
		for (var i = 0; i < this.faculties.length; i++) {
			var cathedras = this.faculties[i].CathedraList;
			for (var j = 0; j < cathedras.length; j++) {
				if (cathedras[j].CourseList.indexOf(course) > -1) {
					this.faculties[i].CathedraList[j].Total -=1;
					this.faculties[i].Total -= 1;
					return;
				}
			}
		}
	}
	getArchive(){
		this.getList.getArchive().then(data => {
			try{
				this.ArchiveIsLoaded = true;
				this.archive = data.json();
			}catch(e){
				console.log(e);
				console.log(data._body);
			}
		})
	}
	DownloadInfo(year){
		this.ArchiveYearIsLoaded = false;
		let data = JSON.parse(localStorage.getItem('archive-' + year));
		if (data !== null) {
			this.archive[year] = data;
			this.ArchiveYearIsLoaded = true;
		}else{
			this.getList.getArchiveByYear(year).then(data => {
				this.ArchiveYearIsLoaded = false;
				try{
					this.archive[year] = data.json();
					localStorage.setItem("archive-" + year, JSON.stringify(data.json()));
				}catch(e){
					console.log(e);
					console.log(data._body);
				}
				this.ArchiveYearIsLoaded = true;
			})
		}
	}
}