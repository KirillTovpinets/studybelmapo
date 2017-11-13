import { Component, Input, OnInit } from '@angular/core';
import { ArrivalsService } from "./arrivals.service";

@Component({
	selector: 'arrivals',
	templateUrl: 'templates/personalInfo/arrivals.component.html',
	styleUrls: ['css/personalInfo.component.css'],
	providers: [ArrivalsService]
})

export class ArrivalsInfoComponent implements OnInit{
	@Input() personId: string = "";
	arrivals: any[] = [];
	constructor(public arrivalsService: ArrivalsService){}
	ngOnInit():void{
		// this.arrivalsService.get(this.personId).then(data => this.arrivals = data.json());
		this.arrivalsService.get(this.personId).then(data => console.log(data));
	}
}