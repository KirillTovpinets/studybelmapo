import { Component, Input, OnInit } from '@angular/core';

@Component({
	selector: 'other-info',
	templateUrl: './otherInfo.component.html',
	styleUrls: ['../personalInfo.component.css'],
})

export class OtherInfoComponent{
	@Input('personId') info: any = {};
}