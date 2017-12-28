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
	postDiplomas: any[] = [];
	constructor(public postDiploma: PostDiplomaService){}
	ngOnInit():void{
		this.postDiploma.get(this.personId).then(data => {
			console.log(this.personId);
				console.log(data._body);
			this.postDiplomas = data.json()
		});
	}
}