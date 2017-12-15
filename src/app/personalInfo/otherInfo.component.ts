import { Component, Input, OnInit } from '@angular/core';

@Component({
	selector: 'other-info',
	templateUrl: 'personalInfoTemplates/otherInfo.component.html',
	styleUrls: ['../css/personalInfo.component.css'],
})

export class OtherInfoComponent{
	@Input() info: any = {};
}