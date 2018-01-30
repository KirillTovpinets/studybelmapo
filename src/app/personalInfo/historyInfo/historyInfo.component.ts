import { Component, Input, OnInit } from '@angular/core';

@Component({
	selector: 'history-info',
	templateUrl: './historyInfo.component.html',
	styleUrls: ['../personalInfo.component.css'],
})

export class HistoryInfoComponent{
	@Input('info') info: any = {};
}