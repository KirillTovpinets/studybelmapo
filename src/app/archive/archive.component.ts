import { Component, OnInit, Input, Output, EventEmitter } from '@angular/core';
import { CurrentCourcesListService } from '../FillData/services/getCurrentCourcesList.service';

@Component({
  selector: 'archive',
  templateUrl: './archive.component.html',
  styleUrls: ['./archive.component.css'],
  providers: [CurrentCourcesListService]
})
export class ArchiveComponent implements OnInit {
	@Input("selectableRow") selectable: boolean = false;
	@Output("selectedCourses") selected = new EventEmitter<any[]>();
	ArchiveIsLoaded: boolean = false;
	ArchiveYearIsLoaded: boolean = false;
	ArchiveCourseIsLoaded: boolean = false;
	archive: any[];
	selectedCourses: any[] = [];
  constructor(private courseList: CurrentCourcesListService) { }

  ngOnInit() {
  	this.getArchive();
  }

  getArchive(){
	this.courseList.getArchive().then(data => {
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
			this.courseList.getArchiveByYear(year).then(data => {
				console.log(data._body);
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
	DownloadCourseInfo(course){
		console.log(course);
		this.ArchiveCourseIsLoaded = false;
		let data = JSON.parse(localStorage.getItem('archive-course-' + course.id));
		if (data !== null) {
			this.archive[course] = data;
			this.ArchiveCourseIsLoaded = true;
		}else{
			this.courseList.getArchiveByCourse(course.id).then(data => {
				console.log(data);
				this.ArchiveCourseIsLoaded = false;
				try{
					this.archive[course] = data.json();
					localStorage.setItem("archive-course-" + course.id, JSON.stringify(data.json()));
				}catch(e){
					console.log(e);
					console.log(data);
				}
				this.ArchiveCourseIsLoaded = true;
			})
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
