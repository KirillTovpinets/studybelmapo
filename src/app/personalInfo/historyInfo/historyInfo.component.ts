import { Component, Input, OnInit } from '@angular/core';
import { HistoryService } from './history.service';

@Component({
	selector: 'history-info',
	templateUrl: './historyInfo.component.html',
	styleUrls: ['../personalInfo.component.css'],
	providers: [HistoryService]
})

export class HistoryInfoComponent{
	@Input('personId') personId: number = 0;
	constructor(private history: HistoryService){}
	historyInfo: any[] = [];
	ngOnInit(): void {
		//Called after the constructor, initializing input properties, and the first call to ngOnChanges.
		//Add 'implements OnInit' to the class.
		this.history.getHistory(this.personId).subscribe(res => {
			try{
				this.historyInfo = res.json();
			}catch(e){
				console.log(e);
				console.log(res._body);
			}
		});
	}
}