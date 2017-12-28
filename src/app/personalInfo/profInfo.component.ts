import { Component, Input, OnInit } from '@angular/core';
import { Global } from "../global.class";

@Component({
	selector: 'prof-info',
	templateUrl: 'personalInfoTemplates/profInfo.component.html',
	styleUrls: ['../css/personalInfo.component.css'],
})

export class ProfInfoComponent{
	@Input('info') info: any = {};
	@Input('change') change: boolean = false;
	globalPrams: Global = new Global();
}