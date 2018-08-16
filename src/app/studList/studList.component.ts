import { Component, OnInit, ViewChild, ComponentFactoryResolver, ViewContainerRef, QueryList, ViewChildren, ComponentRef } from '@angular/core';
import { InfoService } from './studList.service';
import { AccordionModule, TabsetComponent } from 'ngx-bootstrap';
import { CurrentCourcesListService } from '../FillData/services/getCurrentCourcesList.service';
import { Course } from '../model/course.class';
import { Global } from '../model/global.class';
import { PersonalDataService } from '../personalInfo/personalData.service';
import {NotificationsService} from 'angular4-notify';
import { StudListService } from './stud-list.service';
import { LogService } from '../share/log.service';
import { IfObservable } from 'rxjs/observable/IfObservable';
import { ShareService } from '../share/share.service';
import { TableListCopmonent } from '../tableList/tableList.component';
import { forwardRef } from '@angular/core';

declare var $: any;
@Component({
	templateUrl: "./studList.component.html",
	providers: [InfoService, CurrentCourcesListService, PersonalDataService],
	styles:[`
		tr.active,
		tr.active>td{
			background-color:#15A3C1 !important;
			color:#fff;
		}
		tr.active .btn{
			border-color: #fff;
			color:#fff;
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
		a:hover{
			cursor:pointer;
		}
		.refresh:hover{
			color: #666;
		}
	`]
})

export class StudListComponent implements OnInit{
	@ViewChild("courseLists") coursesTabs: TabsetComponent;
	@ViewChildren('oldCrs', { read: ViewContainerRef }) oldList: QueryList<ViewContainerRef>;
	@ViewChildren('curCrs', { read: ViewContainerRef }) curList: QueryList<ViewContainerRef>;
	@ViewChildren('allCrs', { read: ViewContainerRef }) allList: QueryList<ViewContainerRef>;
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
	shouldUpdateList: boolean = false;
	componentRef: any;
	constructor(private info: InfoService,
				private getList: CurrentCourcesListService,
				private dataSrv: PersonalDataService,
				private notify: NotificationsService,
				private share: ShareService,
				private students: StudListService,
				private log: LogService,
				private cfr: ComponentFactoryResolver){}

	ngOnInit(): void{
		this.share._updateData.subscribe(list => {
			for(let item of list){
				if(item.info == "studList"){
					this.shouldUpdateList = true;
				}
			}
		})
		this.students.currentTotal.subscribe(total => this.deducts = total);
		this.currentUser = JSON.parse(localStorage.getItem("currentUser"));
		let current = localStorage.getItem("current-courses");
		if(current != null){
			this.currentCourses = JSON.parse(current);
			this.isLoading[0] = false;
		}else{
			this.getList.get("current").then(data => { 
				try{
					this.currentCourses = data.json();
					try{
						localStorage.setItem("current-courses", JSON.stringify(this.currentCourses));
					}catch(e){
						let currentUser = localStorage.getItem("currentUser");
						localStorage.clear();
						localStorage.setItem("currentUser", currentUser);
					}
					
				}catch(e){
					console.log(data._body);
					console.log(e);
				}
				this.isLoading[0] = false;
			}).catch((e) => {
				console.log(e);
				this.notify.addError("Что-то пошло не так. Обратитесь к администратору.");
				this.isLoading[0] = false;
			});
		}
		let old = localStorage.getItem("old-courses");
		if(old != null){
			this.oldCourses = JSON.parse(old);
			this.isLoading[1] = false;
		}else{
			this.getList.get("old").then(data => { 
				console.log(data._body);
				try{
					this.oldCourses = data.json();
					try{
						localStorage.setItem("old-courses", JSON.stringify(this.oldCourses)); 
					}catch(e){
						let currentUser = localStorage.getItem("currentUser");
						localStorage.clear();
						localStorage.setItem("currentUser", currentUser);
					}
					
				}catch(e){
					console.log(data._body);
					console.log(e);
				}
				this.isLoading[1] = false;
			}).catch((e) => {
				console.log(e);
				this.notify.addError("Что-то пошло не так. Обратитесь к администратору.");
				this.isLoading[1] = false;
			});;
		}
		let all = localStorage.getItem("all-courses");
		if(all != null){
			this.courseList = JSON.parse(all);
			this.isLoading[2] = false;
		}else{
			this.getList.get().then(data => { 
				try{
					this.courseList = data.json();
					try{
						localStorage.setItem("all-courses", JSON.stringify(this.courseList));
					}catch(e){
						let currentUser = localStorage.getItem("currentUser");
						localStorage.clear();
						localStorage.setItem("currentUser", currentUser);
					}
					
					this.courseList.forEach((el, index, arr) => {
						if(this.currentCourses.indexOf(el) !== -1){
							el.class = 2;
						}else if (this.oldCourses.indexOf(el) !== -1){
							el.class = 1;
						}else{
							el.class = 3;
						}
					})
				}catch(e){
					console.log(data._body);
					console.log(e);
				}
				this.isLoading[2] = false;
			}).catch((e) => {
				console.log(e);
				this.notify.addError("Что-то пошло не так. Обратитесь к администратору.");
				this.isLoading[2] = false;
			});;
		}

		this.dataSrv.getData(['educType']).then(res => {
			try{
				this.types = res.json();
			}catch(e){
				console.log(res._body);
			}
		}).catch((e) => console.log(e));
	}
	//For departments view
	showListOfListners(course:any, cl:any[], type:string): void {
		if(course.isOpened){
			this.componentRef.destroy();
			course.isOpened = false;
			this.prevRow = course;
			return;
		}
		course.isLoading = true;
		this.getList.getById(course.id).then((data) => {
			try{
				console.log(data.json())
				let viewList;
				switch(type){
					case 'curCources':
						viewList = this.curList.toArray();
						break;
					case 'oldCources':
						viewList = this.oldList.toArray();
						break;
					case 'allCources':
						viewList = this.allList.toArray();
						break;
				}

				const container = viewList[cl.indexOf(course)];
				if(this.componentRef !== undefined){
					this.componentRef.destroy();
				}
				container.clear();
				let compFact = this.cfr.resolveComponentFactory(TableListCopmonent);
				this.componentRef = container.createComponent(compFact);
				let response = data.json();
				this.componentRef.instance.courseItem = response[0];
				course.isOpened = true;
				course.isLoading = false;

			}catch(e){
				console.log(e);
				console.log(data._body);
				this.notify.addError("Что-то пошло не так. Обратитесь к администратору");
			}
		})
	}

	updateList(time:string = ""){
		console.log(time);
		localStorage.removeItem(time + "-courses");
		let data = time || "";
		switch(time){
			case "current":
				this.isLoading[0] = true;
				break;
			case "old":
				this.isLoading[1] = true;
				break;
			case "":
				this.isLoading[2] = true;
				break;
		}
		this.getList.get(data).then(data => { 
			try{
				console.log(data.json());
				switch(time){
					case "current":
					{
						this.isLoading[0] = false;
						this.currentCourses = data.json();
						localStorage.setItem(time + "-courses", JSON.stringify(this.oldCourses)); 
						break;
					}
					case "old":
					{
						this.isLoading[1] = false;
						this.oldCourses = data.json();
						localStorage.setItem(time + "-courses", JSON.stringify(this.oldCourses)); 
						break;
					}
					case "":
					{
						this.isLoading[2] = false;
						this.courseList = data.json();
						localStorage.setItem("all-courses", JSON.stringify(this.oldCourses)); 
						break;
					}
				}

			}catch(e){
				console.log(data._body);
				console.log(e);
			}
			this.isLoading[1] = false;
			this.shouldUpdateList = false;
			this.share.deleteUpdates("studList");
		}).catch((e) => {
			this.notify.addError("Ошибка сервера. Попробуйте обновить позже");
			this.isLoading.fill(true);
		});
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