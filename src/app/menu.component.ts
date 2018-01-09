import { Component, OnInit, Input, ElementRef } from '@angular/core';
import { GlobalParamsService } from './Globalparams.service';
import { ShareService } from './services/share.service';
@Component({
	selector: 'menu',
	templateUrl: 'templates/menu.component.html',
	styleUrls: ["../css/pe-icon-7-stroke.css"],
	providers: [GlobalParamsService]
})

export class MenuComponent implements OnInit{
	constructor(private selectedPage: GlobalParamsService,
				private menuManip: ShareService,
				private element: ElementRef){
	}
	currentUser: any;
	ngOnInit(): void{
		this.currentUser = localStorage.getItem('currentUser');
		console.log(this.currentUser);
		this.menuManip.currentMessage.subscribe(message =>{
			this.element.nativeElement.style.display = message ? "block": "none";
			this.element.nativeElement.style.right = "0";
			this.element.nativeElement.style.left = "initial";
		 });
		this.selectedPage._selectedPage = 1;
		return;
	}
	selectPage(v:number): void{
		this.selectedPage._selectedPage = v;
	}
}