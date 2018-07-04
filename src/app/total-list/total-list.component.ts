import { Component, OnInit } from '@angular/core';
import { InfoService } from '../studList/studList.service';
import { Course } from '../model/course.class';
import { Global } from '../model/global.class';
import { NotificationsService } from 'angular4-notify';
import { CurrentCourcesListService } from '../FillData/services/getCurrentCourcesList.service';
import { LogService } from '../share/log.service';
import { PersonalDataService } from '../personalInfo/personalData.service';
import { ShareService } from '../share/share.service';

@Component({
  selector: 'app-total-list',
  templateUrl: './total-list.component.html',
  styleUrls: ['./total-list.component.css'],
  providers: [InfoService, NotificationsService, PersonalDataService]
})
export class TotalListComponent implements OnInit {
  statIsLoaded: boolean = false;
  cathedras: string[] = [];
  faculties: any[] = [];
  newCourse: Course = new Course();
  global: Global = new Global();
  prevRow: any;
  ArchiveIsLoaded:boolean = false;
	archive:any[];
	types: any[];
	shouldUpdateList: boolean = false;
  constructor(private info: InfoService,
              private notify: NotificationsService,
              private getList: CurrentCourcesListService,
							private log: LogService,
							private share: ShareService,
							private data: PersonalDataService) { }

  ngOnInit() {
		this.share._updateData.subscribe(list => {
			for(let item of list){
				if(item.info == "studList"){
					this.shouldUpdateList = true;
				}
			}
		})
    let faculties = localStorage.getItem("faculties");
    if(faculties == null){
      this.info.getInfo("getStat").then(data => {
				this.faculties = data.json().data;
				try{
					localStorage.setItem("faculties", JSON.stringify(this.faculties));
				}catch(e){
					localStorage.clear();
					localStorage.setItem("faculties", JSON.stringify(this.faculties));
				}
        this.statIsLoaded = true;
      });
    }else{
      this.faculties = JSON.parse(faculties);
      this.statIsLoaded = true;
		}
		
		let types = localStorage.getItem("educTypeBel");
		if(types == null){
			this.data.getData("type").then((data) => {
				try{
					this.types = data.json();
					try{
						localStorage.setItem("educTypeBel", JSON.stringify(this.types));
					}catch(e){
						localStorage.clear();
						localStorage.setItem("educTypeBel", JSON.stringify(this.types));
					}
				}catch(e){
					console.log(e);
					console.log(data._body);
				}
				
			})
		}else{
			this.types = JSON.parse(types);
		}
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
	updateList(){
		this.statIsLoaded = false;
		this.info.getInfo("getStat").then(data => {
			try{
				console.log(data.json());
				this.faculties = data.json().data;
			}catch(e){
				console.log(e);
				console.log(data._body);
			}
			
			localStorage.removeItem("faculties");
			try{
				localStorage.setItem("faculties", JSON.stringify(this.faculties));
			}catch(e){
				localStorage.clear();
				localStorage.setItem("faculties", JSON.stringify(this.faculties));
			}
			this.statIsLoaded = true;
			this.shouldUpdateList = false;
			this.share.deleteUpdates("studList");
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
		this.info.saveCourse(this.newCourse).then(res => {
			this.notify.addSuccess("Курс добавлен");
			this.newCourse = new Course();
		})
  }
  ErrorAction(e, data){
		console.log(e);
		console.log(data._body);
		this.notify.addError(data._body);
		this.log.SendError({page: "studList", error: e, response: data});
	}
}

