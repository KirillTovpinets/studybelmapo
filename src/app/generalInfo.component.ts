import { Component, Input, OnInit } from '@angular/core';

@Component({
	selector: 'general-info',
	templateUrl: 'templates/personalInfo/general.component.html',
	styleUrls: ['css/personalInfo.component.css'],
})

export class GeneralInfoComponent{
	@Input('info') info: any = {};
}