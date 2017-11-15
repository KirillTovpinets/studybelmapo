import { Component, OnInit, ViewChild } from '@angular/core';
import { InfoService } from './studList.service';
import { AccordionModule } from 'ngx-bootstrap';

import { Preloader } from './ts/preloader';

declare var $: any;
const DATA: any = {
	cathedraInfo:[
		{
			faculty:"Терапевтический",
			cathedra: "Гастроэнтерологии и нутрициологии"
		}
	],
	courseList: [
		{
			id: "163",
			Number: "233",
			name: "Достижения в диагностике заболеваний органов пищеварения", 
			Start: "2017-05-15", 
			Finish: "2017-05-19",
			list: [
				{
					Date: "2017-05-15", 
					id: "7310", 
					birthday:"1966-05-04",
					surname: "Ковш", 
					name: "Ольга", 
					patername: "Анатольевна"
				},
				{
					Date: "2017-05-15", 
					id: "7310", 
					birthday:"1966-05-04",
					surname: "Ковш", 
					name: "Ольга", 
					patername: "Анатольевна"
				},
				{
					Date: "2017-05-15", 
					id: "7310", 
					birthday:"1966-05-04",
					surname: "Ковш", 
					name: "Ольга", 
					patername: "Анатольевна"
				},
				{
					Date: "2017-05-15", 
					id: "7310", 
					birthday:"1966-05-04",
					surname: "Ковш", 
					name: "Ольга", 
					patername: "Анатольевна"
				},
				{
					Date: "2017-05-15", 
					id: "7310", 
					birthday:"1966-05-04",
					surname: "Ковш", 
					name: "Ольга", 
					patername: "Анатольевна"
				},
				{
					Date: "2017-05-15", 
					id: "7310", 
					birthday:"1966-05-04",
					surname: "Ковш", 
					name: "Ольга", 
					patername: "Анатольевна"
				},
				{
					Date: "2017-05-15", 
					id: "7310", 
					birthday:"1966-05-04",
					surname: "Ковш", 
					name: "Ольга", 
					patername: "Анатольевна"
				},
				{
					Date: "2017-05-15", 
					id: "7310", 
					birthday:"1966-05-04",
					surname: "Ковш", 
					name: "Ольга", 
					patername: "Анатольевна"
				},
				{
					Date: "2017-05-15", 
					id: "7310", 
					birthday:"1966-05-04",
					surname: "Ковш", 
					name: "Ольга", 
					patername: "Анатольевна"
				},
			]
		},
		{
			id: "163",
			Number: "233",
			name: "Достижения в диагностике заболеваний органов пищеварения", 
			Start: "2017-05-15", 
			Finish: "2017-05-19",
			list: [
				{
					Date: "2017-05-15", 
					id: "7310", 
					birthday:"1966-05-04",
					surname: "Ковш", 
					name: "Ольга", 
					patername: "Анатольевна"
				},
				{
					Date: "2017-05-15", 
					id: "7310", 
					birthday:"1966-05-04",
					surname: "Ковш", 
					name: "Ольга", 
					patername: "Анатольевна"
				},
				{
					Date: "2017-05-15", 
					id: "7310", 
					birthday:"1966-05-04",
					surname: "Ковш", 
					name: "Ольга", 
					patername: "Анатольевна"
				},
				{
					Date: "2017-05-15", 
					id: "7310", 
					birthday:"1966-05-04",
					surname: "Ковш", 
					name: "Ольга", 
					patername: "Анатольевна"
				},
				{
					Date: "2017-05-15", 
					id: "7310", 
					birthday:"1966-05-04",
					surname: "Ковш", 
					name: "Ольга", 
					patername: "Анатольевна"
				},
				{
					Date: "2017-05-15", 
					id: "7310", 
					birthday:"1966-05-04",
					surname: "Ковш", 
					name: "Ольга", 
					patername: "Анатольевна"
				},
				{
					Date: "2017-05-15", 
					id: "7310", 
					birthday:"1966-05-04",
					surname: "Ковш", 
					name: "Ольга", 
					patername: "Анатольевна"
				},
				{
					Date: "2017-05-15", 
					id: "7310", 
					birthday:"1966-05-04",
					surname: "Ковш", 
					name: "Ольга", 
					patername: "Анатольевна"
				},
				{
					Date: "2017-05-15", 
					id: "7310", 
					birthday:"1966-05-04",
					surname: "Ковш", 
					name: "Ольга", 
					patername: "Анатольевна"
				},
			]
		},
		{
			id: "163",
			Number: "233",
			name: "Достижения в диагностике заболеваний органов пищеварения", 
			Start: "2017-05-15", 
			Finish: "2017-05-19",
			list: [
				{
					Date: "2017-05-15", 
					id: "7310", 
					birthday:"1966-05-04",
					surname: "Ковш", 
					name: "Ольга", 
					patername: "Анатольевна"
				},
				{
					Date: "2017-05-15", 
					id: "7310", 
					birthday:"1966-05-04",
					surname: "Ковш", 
					name: "Ольга", 
					patername: "Анатольевна"
				},
				{
					Date: "2017-05-15", 
					id: "7310", 
					birthday:"1966-05-04",
					surname: "Ковш", 
					name: "Ольга", 
					patername: "Анатольевна"
				},
				{
					Date: "2017-05-15", 
					id: "7310", 
					birthday:"1966-05-04",
					surname: "Ковш", 
					name: "Ольга", 
					patername: "Анатольевна"
				},
				{
					Date: "2017-05-15", 
					id: "7310", 
					birthday:"1966-05-04",
					surname: "Ковш", 
					name: "Ольга", 
					patername: "Анатольевна"
				},
				{
					Date: "2017-05-15", 
					id: "7310", 
					birthday:"1966-05-04",
					surname: "Ковш", 
					name: "Ольга", 
					patername: "Анатольевна"
				},
				{
					Date: "2017-05-15", 
					id: "7310", 
					birthday:"1966-05-04",
					surname: "Ковш", 
					name: "Ольга", 
					patername: "Анатольевна"
				},
				{
					Date: "2017-05-15", 
					id: "7310", 
					birthday:"1966-05-04",
					surname: "Ковш", 
					name: "Ольга", 
					patername: "Анатольевна"
				},
				{
					Date: "2017-05-15", 
					id: "7310", 
					birthday:"1966-05-04",
					surname: "Ковш", 
					name: "Ольга", 
					patername: "Анатольевна"
				},
			]
		},
		{
			id: "163",
			Number: "233",
			name: "Достижения в диагностике заболеваний органов пищеварения", 
			Start: "2017-05-15", 
			Finish: "2017-05-19",
			list: [
				{
					Date: "2017-05-15", 
					id: "7310", 
					birthday:"1966-05-04",
					surname: "Ковш", 
					name: "Ольга", 
					patername: "Анатольевна"
				},
				{
					Date: "2017-05-15", 
					id: "7310", 
					birthday:"1966-05-04",
					surname: "Ковш", 
					name: "Ольга", 
					patername: "Анатольевна"
				},
				{
					Date: "2017-05-15", 
					id: "7310", 
					birthday:"1966-05-04",
					surname: "Ковш", 
					name: "Ольга", 
					patername: "Анатольевна"
				},
				{
					Date: "2017-05-15", 
					id: "7310", 
					birthday:"1966-05-04",
					surname: "Ковш", 
					name: "Ольга", 
					patername: "Анатольевна"
				},
				{
					Date: "2017-05-15", 
					id: "7310", 
					birthday:"1966-05-04",
					surname: "Ковш", 
					name: "Ольга", 
					patername: "Анатольевна"
				},
				{
					Date: "2017-05-15", 
					id: "7310", 
					birthday:"1966-05-04",
					surname: "Ковш", 
					name: "Ольга", 
					patername: "Анатольевна"
				},
				{
					Date: "2017-05-15", 
					id: "7310", 
					birthday:"1966-05-04",
					surname: "Ковш", 
					name: "Ольга", 
					patername: "Анатольевна"
				},
				{
					Date: "2017-05-15", 
					id: "7310", 
					birthday:"1966-05-04",
					surname: "Ковш", 
					name: "Ольга", 
					patername: "Анатольевна"
				},
				{
					Date: "2017-05-15", 
					id: "7310", 
					birthday:"1966-05-04",
					surname: "Ковш", 
					name: "Ольга", 
					patername: "Анатольевна"
				},
			]
		},
		{
			id: "163",
			Number: "233",
			name: "Достижения в диагностике заболеваний органов пищеварения", 
			Start: "2017-05-15", 
			Finish: "2017-05-19",
			list: [
				{
					Date: "2017-05-15", 
					id: "7310", 
					birthday:"1966-05-04",
					surname: "Ковш", 
					name: "Ольга", 
					patername: "Анатольевна"
				},
				{
					Date: "2017-05-15", 
					id: "7310", 
					birthday:"1966-05-04",
					surname: "Ковш", 
					name: "Ольга", 
					patername: "Анатольевна"
				},
				{
					Date: "2017-05-15", 
					id: "7310", 
					birthday:"1966-05-04",
					surname: "Ковш", 
					name: "Ольга", 
					patername: "Анатольевна"
				},
				{
					Date: "2017-05-15", 
					id: "7310", 
					birthday:"1966-05-04",
					surname: "Ковш", 
					name: "Ольга", 
					patername: "Анатольевна"
				},
				{
					Date: "2017-05-15", 
					id: "7310", 
					birthday:"1966-05-04",
					surname: "Ковш", 
					name: "Ольга", 
					patername: "Анатольевна"
				},
				{
					Date: "2017-05-15", 
					id: "7310", 
					birthday:"1966-05-04",
					surname: "Ковш", 
					name: "Ольга", 
					patername: "Анатольевна"
				},
				{
					Date: "2017-05-15", 
					id: "7310", 
					birthday:"1966-05-04",
					surname: "Ковш", 
					name: "Ольга", 
					patername: "Анатольевна"
				},
				{
					Date: "2017-05-15", 
					id: "7310", 
					birthday:"1966-05-04",
					surname: "Ковш", 
					name: "Ольга", 
					patername: "Анатольевна"
				},
				{
					Date: "2017-05-15", 
					id: "7310", 
					birthday:"1966-05-04",
					surname: "Ковш", 
					name: "Ольга", 
					patername: "Анатольевна"
				},
			]
		},
		{
			id: "163",
			Number: "233",
			name: "Достижения в диагностике заболеваний органов пищеварения", 
			Start: "2017-05-15", 
			Finish: "2017-05-19",
			list: [
				{
					Date: "2017-05-15", 
					id: "7310", 
					birthday:"1966-05-04",
					surname: "Ковш", 
					name: "Ольга", 
					patername: "Анатольевна"
				},
				{
					Date: "2017-05-15", 
					id: "7310", 
					birthday:"1966-05-04",
					surname: "Ковш", 
					name: "Ольга", 
					patername: "Анатольевна"
				},
				{
					Date: "2017-05-15", 
					id: "7310", 
					birthday:"1966-05-04",
					surname: "Ковш", 
					name: "Ольга", 
					patername: "Анатольевна"
				},
				{
					Date: "2017-05-15", 
					id: "7310", 
					birthday:"1966-05-04",
					surname: "Ковш", 
					name: "Ольга", 
					patername: "Анатольевна"
				},
				{
					Date: "2017-05-15", 
					id: "7310", 
					birthday:"1966-05-04",
					surname: "Ковш", 
					name: "Ольга", 
					patername: "Анатольевна"
				},
				{
					Date: "2017-05-15", 
					id: "7310", 
					birthday:"1966-05-04",
					surname: "Ковш", 
					name: "Ольга", 
					patername: "Анатольевна"
				},
				{
					Date: "2017-05-15", 
					id: "7310", 
					birthday:"1966-05-04",
					surname: "Ковш", 
					name: "Ольга", 
					patername: "Анатольевна"
				},
				{
					Date: "2017-05-15", 
					id: "7310", 
					birthday:"1966-05-04",
					surname: "Ковш", 
					name: "Ольга", 
					patername: "Анатольевна"
				},
				{
					Date: "2017-05-15", 
					id: "7310", 
					birthday:"1966-05-04",
					surname: "Ковш", 
					name: "Ольга", 
					patername: "Анатольевна"
				},
			]
		},
	]
}
@Component({
	templateUrl: "templates/studList.component.html",
	providers: [InfoService, Preloader]
})

export class StudListComponent implements OnInit{
	coursesList: string[] = [];
	cathedras: string[] = [];
	faculties: string[] = [];
	constructor(private infoService: InfoService,
				private preloader: Preloader
		){}

	ngOnInit(): void{
		this.preloader.start(".main-panel > .content");
		// this.coursesList = DATA.courseList;
		// for(var i = 0;  i < DATA.cathedraInfo.length; i++){
		// 	this.cathedras.push("Кафедра " + DATA.cathedraInfo[i].cathedra.toLowerCase());
  //           this.faculties.push(DATA.cathedraInfo[i].faculty);
		// }
		this.preloader.stop(".main-panel > .content");
		this.infoService.getInfo("getStat").then(data => {
			this.coursesList = data.json().courseList;
			for(var i = 0;  i < data.json().cathedraInfo.length; i++){
				this.cathedras.push("Кафедра " + data.json().cathedraInfo[i].cathedra.toLowerCase());
                this.faculties.push(data.json().cathedraInfo[i].faculty);
			}
			this.preloader.stop(".main-panel > .content");
		})
	}

	showListOfListners(course:any): void {
		course.isOpened = !course.isOpened;
	}
}