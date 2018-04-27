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
	prevRow: any;
	message:string = "";
	isLoading: boolean[] = new Array(4).fill(true);
	
	
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
		this.getList.get("current").then(data => { 
			this.currentCourses = data.json();
			this.isLoading[0] = false;
		});
		this.getList.get("old").then(data => { 
			this.oldCourses = data.json() 
			this.isLoading[1] = false;
		});
		this.getList.get().then(data => { 
			this.courseList = data.json();
			this.isLoading[2] = false;
		});

		this.dataSrv.getTypeList().then(res => this.types = res.json());
	}
	//For departments view
	showListOfListners(course:any): void {
		if (this.prevRow != undefined && this.prevRow !== course) {
			this.prevRow.isOpened = false;
		}
		course.isOpened = !course.isOpened;
		this.prevRow = course;
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