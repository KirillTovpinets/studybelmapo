import { Component, Input, OnInit } from '@angular/core';
import { ArrivalsService } from "./services/arrivals.service";
import { Global } from "../global.class";
@Component({
	selector: 'arrivals',
	templateUrl: 'personalInfoTemplates/arrivals.component.html',
	styleUrls: ['../css/personalInfo.component.css'],
	providers: [ArrivalsService]
})

export class ArrivalsInfoComponent implements OnInit{
	@Input() personId: string = "";
	arrivals: any[] = [];
	globalPrams: Global = new Global();
	constructor(public arrivalsService: ArrivalsService){}
	ngOnInit():void{
		// this.arrivalsService.get(this.personId).then(data => this.arrivals = data.json());
		console.log(this.personId);
		this.arrivalsService.get(this.personId).then(data => {
			console.log(data._body);
			this.arrivals = data.json();
		});
	}
}