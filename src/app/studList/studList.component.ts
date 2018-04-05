import { Component, OnInit, ViewChild } from '@angular/core';
import { InfoService } from './studList.service';
import { AccordionModule, TabsetComponent } from 'ngx-bootstrap';
import { CurrentCourcesListService } from '../FillData/services/getCurrentCourcesList.service';
import { Course } from '../model/course.class';
import { Global } from '../model/global.class';
import { PersonalDataService } from '../personalInfo/personalData.service';
import {NotificationsService} from 'angular4-notify';
import { StudListService } from './stud-list.service';
import { LogService } from '../share/log.service';

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
	isLoading: boolean[] = new Array(4).fill(true);
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
				private students: StudListService,
				private log: LogService){}

	ngOnInit(): void{
		this.students.currentTotal.subscribe(total => this.deducts = total);
		this.currentUser = JSON.parse(localStorage.getItem("currentUser"));
		if (this.currentUser.is_cathedra == 0) {
			this.info.getInfo("getStat").then(data => this.faculties = data.json().data);
		}else{
			this.getList.get().then(data => {
				try{
					this.courseList = data.json();
					this.isLoading[0] = false;
					var today = new Date();

					this.oldCourses = this.courseList.filter((course) => {
						var start = new Date(course.Start);
						var finish = new Date(course.Finish);

						if(start < today && finish < today){
							course.class = 1;
							return course;
						}
					});
					this.isLoading[1] = false;
					this.currentCourses = this.courseList.filter((course) => {
						var start = new Date(course.Start);
						var finish = new Date(course.Finish);

						if(start < today && finish > today){
							course.class = 2;
							return course;
						}
					});
					this.isLoading[2] = false;
					this.futureCourses = this.courseList.filter((course) => {
						var start = new Date(course.Start);

						if(start > today){
							course.class = 3;
							return course;
						}
					});
					this.isLoading[3] = false;

				}catch(e){
					this.ErrorAction(e, data);
				}
			});
			this.dataSrv.getTypeList().then(res => this.types = res.json());
		}
		if (this.coursesTabs !== undefined) {
			this.coursesTabs.tabs[0].active = false;
			this.coursesTabs.tabs[2].active = true;
		}
	}

	//For departments view
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

	//Catch changes from (table-list)
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
				this.ErrorAction(e, data);
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
			this.getList.getArchiveByYear(year, {limit: 0, offset: 0}).then(data => {
				this.ArchiveYearIsLoaded = false;
				try{
					this.archive[year] = data.json();
					localStorage.setItem("archive-" + year, JSON.stringify(data.json()));
				}catch(e){
					this.ErrorAction(e, data);
				}
				this.ArchiveYearIsLoaded = true;
			})
		}
	}

	ErrorAction(e, data){
		console.log(e);
		console.log(data._body);
		this.notify.addError(data._body);
		this.log.SendError({page: "studList", error: e, response: data});
	}
}