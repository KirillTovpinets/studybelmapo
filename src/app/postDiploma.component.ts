import { Component, Input, OnInit } from '@angular/core';

@Component({
	selector: 'post-diploma',
	templateUrl: 'templates/personalInfo/postDiploma.component.html',
	styleUrls: ['css/personalInfo.component.css'],
})

export class PostDiplomaInfoComponent{
	@Input() info: any = {};
}