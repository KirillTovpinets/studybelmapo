import { Component, OnInit } from '@angular/core';
import { GlobalParamsService } from './Globalparams.service';
@Component({
	selector: 'menu',
	templateUrl: 'templates/menu.component.html',
	styleUrls: ["../css/pe-icon-7-stroke.css"],
	providers: [GlobalParamsService]
})

export class MenuComponent implements OnInit{
	constructor(private selectedPage: GlobalParamsService){
	}
	ngOnInit(): void{
		this.selectedPage._selectedPage = 1;
		return;
	}
	selectPage(v:number): void{
		this.selectedPage._selectedPage = v;
	}
}