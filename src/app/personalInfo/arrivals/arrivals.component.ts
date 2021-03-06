import { Component, Input, OnInit } from '@angular/core';
import { ArrivalsService } from "./arrivals.service";
import { Global } from "../../model/global.class";
@Component({
	selector: 'arrivals',
	templateUrl: './arrivals.component.html',
	styleUrls: ['../personalInfo.component.css'],
	providers: [ArrivalsService]
})

export class ArrivalsInfoComponent implements OnInit{
	@Input('personId') personId: string = "";
	arrivals: any[] = [];
	globalPrams: Global = new Global();
	constructor(public arrivalsService: ArrivalsService){}
	ngOnInit():void{
		// this.arrivalsService.get(this.personId).then(data => this.arrivals = data.json());
		this.arrivalsService.get(this.personId).then(data => {
			this.arrivals = data.json();
		});
	}
}