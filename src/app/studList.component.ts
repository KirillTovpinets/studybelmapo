import { Component, OnInit, ViewChild } from '@angular/core';
import { InfoService } from './studList.service';
import { AccordionModule } from 'ngx-bootstrap';
import { CurrentCourcesListService } from './FillData/services/getCurrentCourcesList.service';
import { PreloaderComponent } from './preloader.component';
import { Course } from './model/course.class';
import { Global } from './global.class';
import { PersonalDataService } from './services/personalData.service';
import {NotificationsService} from 'angular4-notify';
declare var $: any;
@Component({
	templateUrl: "templates/studList.component.html",
	providers: [InfoService, CurrentCourcesListService, PersonalDataService],
	styles:[`
		tr.active,
		tr.active>td{
			background-color:#63d8f1 !important;
			color:#fff;
		}
		.nested:hover,
		.nested{
			background:#FFF !important;
		}
	`]
})

export class StudListComponent implements OnInit{
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
	constructor(private info: InfoService,
				private getList: CurrentCourcesListService,
				private dataSrv: PersonalDataService,
				private notify: NotificationsService){}

	ngOnInit(): void{
		// this.info.getInfo("getStat").then(data => {
		// 	// console.log(data._body);
		// 	this.faculties = data.json().data;
		// })
		this.isLoading = true;
		this.getList.get().then(data => {
			try{
				this.courseList = data.json();
				console.log(data.json());
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
}