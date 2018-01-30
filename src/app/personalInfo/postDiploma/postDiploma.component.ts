import { Component, Input, OnInit } from '@angular/core';
import { PostDiplomaService } from "./postDiploma.service";

@Component({
	selector: 'post-diploma',
	templateUrl: './postDiploma.component.html',
	styleUrls: ['../personalInfo.component.css'],
	providers: [PostDiplomaService]
})

export class PostDiplomaInfoComponent implements OnInit{
	@Input('personId') personId: string = "";
	postDiplomas: any[] = [];
	constructor(public postDiploma: PostDiplomaService){}
	ngOnInit():void{
		this.postDiploma.get(this.personId).then(data => {
			this.postDiplomas = data.json()
		});
	}
}