import { Component, Input, OnInit } from '@angular/core';

@Component({
	selector: 'history-info',
	templateUrl: 'personalInfoTemplates/historyInfo.component.html',
	styleUrls: ['../css/personalInfo.component.css'],
})

export class HistoryInfoComponent{
	@Input('info') info: any = {};
}