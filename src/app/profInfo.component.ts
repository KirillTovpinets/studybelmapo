import { Component, Input, OnInit } from '@angular/core';

@Component({
	selector: 'prof-info',
	templateUrl: 'templates/personalInfo/profInfo.component.html',
	styleUrls: ['css/personalInfo.component.css'],
})

export class ProfInfoComponent{
	@Input() info: any = {};
}