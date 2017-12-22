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
	faculties: any[] = [];
	constructor(private infoService: InfoService){}

	ngOnInit(): void{
		this.infoService.getInfo("getStat").then(data => {
			// console.log(data._body);
			this.faculties = data.json().data;
		})
	}

	showListOfListners(course:any): void {
		course.isOpened = !course.isOpened;
	}
}