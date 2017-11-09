import { Component, OnInit, ViewChild } from '@angular/core';
import { InfoService } from './studList.service';
import { AccordionModule } from 'ngx-bootstrap';

import { Preloader } from './ts/preloader';

declare var $: any;
@Component({
	selector: "studlist",
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
		this.infoService.getInfo("getStat").then(data => {
			this.coursesList = data.json().courseList
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