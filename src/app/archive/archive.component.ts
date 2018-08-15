import { Component, OnInit, Input, Output, EventEmitter, OnChanges, SimpleChange } from '@angular/core';
import { CurrentCourcesListService } from '../FillData/services/getCurrentCourcesList.service';
import { NotificationsService } from 'angular4-notify';
import { LogService } from '../share/log.service';
@Component({
  selector: 'archive',
  templateUrl: './archive.component.html',
  styleUrls: ['./archive.component.css'],
  providers: [CurrentCourcesListService]
})
export class ArchiveComponent implements OnInit {
	@Input("selectableRow") selectable: boolean = false;
	@Input() update: boolean;
	@Output("selectedCourses") selected = new EventEmitter<any[]>();
	ArchiveIsLoaded: boolean = false;
	ArchiveYearIsLoaded: boolean = false;
	ArchiveCourseIsLoaded: boolean = false;
	archive: any[];
	selectedCourses: any[] = [];
  constructor(private courseList: CurrentCourcesListService,
  				private notify: NotificationsService,
  				private log: LogService) { }

  ngOnInit() {
  	this.getArchive();
  }

  ngOnChanges(changes: {[propKey: string]: SimpleChange}){
	  this.getArchive();
  }
  getArchive(){
	  this.ArchiveIsLoaded = false;
	  this.archive = [];
	this.courseList.getArchive().then(data => {
			try{
				this.ArchiveIsLoaded = true;
				this.archive = data.json();
			}catch(e){
				this.log.SendError({page: 'archive', error: e, response: data}).subscribe(res => console.log(res));
				this.notify.addError("Произошла ошибка. Обратитесь к администратору");
			}
		})
	}
	DownloadInfo(year){
		this.ArchiveYearIsLoaded = false;
		let data = JSON.parse(localStorage.getItem('archive-' + year));
		if (data !== null) {
			this.archive[year] = data.splice(0, 30);
			this.ArchiveYearIsLoaded = true;
		}else{
			this.courseList.getArchiveByYear(year, {limit: 30, offset: 0}).then(data => {
				this.ArchiveYearIsLoaded = false;
				try{
					this.archive[year] = data.json();
					localStorage.setItem("archive-" + year, JSON.stringify(data.json()));
				}catch(e){
					this.log.SendError({page: 'archive', error: e, response: data}).subscribe(res => console.log(res));
					this.notify.addError("Произошла ошибка. Обратитесь к администратору");
					console.log(e);
					console.log(data._body);
				}
				this.ArchiveYearIsLoaded = true;
			})
		}
	}
	DownloadMoreCourses(year){
		year.isLoading = true;
		if(year.limit == undefined && year.offset === undefined){
			year.limit = 30;
			year.offset = 30;
		}
		let data = JSON.parse(localStorage.getItem('archive-' + year.year));
		if (data.splice(year.offset, year.limit).length !== 0) {
			this.archive[year.year] = this.archive[year.year].concat(data.splice(year.offset, year.limit));
			year.offset += 30;
			year.isLoading = false;
		}else{
			this.courseList.getArchiveByYear(year.year, {limit: year.limit, offset: year.offset}).then(data => {
				year.offset += 30;
				try{
					this.archive[year.year] = this.archive[year.year].concat(data.json());
					localStorage.setItem("archive-" + year.year, JSON.stringify(this.archive[year.year]));
				}catch(e){
					this.log.SendError({page: 'archive', error: e, response: data}).subscribe(res => console.log(res));
					this.notify.addError("Произошла ошибка. Обратитесь к администратору");
					console.log(e);
					console.log(data._body);
				}
				year.isLoading = false;
			})
		}
	}
	DownloadCourseInfo(course, $event){
		if(course.limit == undefined && course.offset === undefined){
			course.limit = 0;
			course.offset = 30;
		}
		course.ArchiveCourseIsLoaded = false;
		if($event){
			if (course.id === undefined) {
				this.notify.addError("Ошибка базы данных. Обратитесь к администратору");
			}
			let data = JSON.parse(localStorage.getItem('archive-course-' + course.id));

			if (data !== null && this.archive["course-" + course.id] === undefined) {
				this.archive["course-" + course.id] = data.slice(0, course.limit);
				course.offset += 30;
				course.ArchiveCourseIsLoaded = true;
			}else{
				this.courseList.getArchiveByCourse(course.id, {limit: 30, offset: 0}).then(data => {
					try{
						course.offset += 30;
						this.archive["course-" + course.id] = data.json();
						localStorage.setItem("archive-course-" + course.id, JSON.stringify(data.json()));
						course.ArchiveCourseIsLoaded = true;
					}catch(e){
						course.endOflist = true;
						this.log.SendError({page: 'archive', error: e, response: data});
						this.notify.addError("Произошла ошибка. Обратитесь к администратору");
						console.log(e);
						console.log(data);
					}
				})
			}
		}
	}
	DownloadMore(course){
		if(course.limit == undefined && course.offset === undefined){
			course.limit = 30;
			course.offset = 30;
		}
		course.isLoading = true;
		var alreadyHave = JSON.parse(localStorage.getItem('archive-course-' + course.id));
		var toShow = alreadyHave.splice(course.offset, course.limit);
		if(toShow.length === 0){
			this.courseList.getArchiveByCourse(course.id, {limit: course.limit, offset: course.offset}).then(data => {
				console.log(data);
				try{
					course.offset += 30;
					this.archive["course-" + course.id] = this.archive["course-" + course.id].concat(data.json());
					localStorage.setItem('archive-course-' + course.id, JSON.stringify(this.archive["course-" + course.id]));
					course.isLoading = false;
				}catch(e){
					this.log.SendError({page: 'archive', error: e, response: data});
					this.notify.addError("Произошла ошибка. Обратитесь к администратору");
					console.log(e);
					console.log(data);
				}
			})
		}else{
			course.offset += 30;
			this.archive["course-" + course.id] = this.archive["course-" + course.id].concat(toShow);
			course.isLoading = false;
		}
	}
	selectCourse(course:any): void{
		if (this.selectedCourses.indexOf(course) !== -1) {
			var index = this.selectedCourses.indexOf(course);
			this.selectedCourses.splice(index, 1);
		}else{
			this.selectedCourses.push(course);
		}
		this.selected.emit(this.selectedCourses);
	}
}
