import { Component, OnInit, ViewChild } from '@angular/core';
import { InfoService } from './studList.service';
import { AccordionModule } from 'ngx-bootstrap';

import { PreloaderComponent } from './preloader.component';

declare var $: any;
@Component({
	templateUrl: "templates/studList.component.html",
	providers: [InfoService]
})

export class StudListComponent implements OnInit{
	coursesList: string[] = [];
	cathedras: string[] = [];
	faculties: string[] = [];
	constructor(private infoService: InfoService){}

	ngOnInit(): void{
		this.infoService.getInfo("getStat").then(data => {
			this.coursesList = data.json().courseList;
			for(var i = 0;  i < data.json().cathedraInfo.length; i++){
				this.cathedras.push("Кафедра " + data.json().cathedraInfo[i].cathedra.toLowerCase());
                this.faculties.push(data.json().cathedraInfo[i].faculty);
			}
		})
	}

	showListOfListners(course:any): void {
		course.isOpened = !course.isOpened;
	}
}