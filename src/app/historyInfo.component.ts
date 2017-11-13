import { Component, Input, OnInit } from '@angular/core';

@Component({
	selector: 'history-info',
	templateUrl: 'templates/personalInfo/historyInfo.component.html',
	styleUrls: ['css/personalInfo.component.css'],
})

export class HistoryInfoComponent{
	@Input() info: any = {};
}