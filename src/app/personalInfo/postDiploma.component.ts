import { Component, Input, OnInit } from '@angular/core';
import { PostDiplomaService } from "./services/postDiploma.service";

@Component({
	selector: 'post-diploma',
	templateUrl: 'personalInfoTemplates/postDiploma.component.html',
	styleUrls: ['../css/personalInfo.component.css'],
	providers: [PostDiplomaService]
})

export class PostDiplomaInfoComponent implements OnInit{
	@Input() personId: string = "";
	arrivals: any[] = [];
	constructor(public arrivalsService: PostDiplomaService){}
	ngOnInit():void{
		// this.arrivalsService.get(this.personId).then(data => this.arrivals = data.json());
		this.arrivalsService.get(this.personId).then(data => console.log(data));
	}
}