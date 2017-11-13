import { Component, Input, OnInit } from '@angular/core';

@Component({
	selector: 'private-info',
	templateUrl: 'templates/personalInfo/private.component.html',
	styleUrls: ['css/personalInfo.component.css'],
})

export class PrivateInfoComponent{
	@Input() info: any = {};
}