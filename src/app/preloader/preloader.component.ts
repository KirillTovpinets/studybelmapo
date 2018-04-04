import { Component, Input } from "@angular/core";

@Component({
	selector: "preloader",
	template: `
		<div id='jpreloader' class='preloader-overlay'>
		    <div class='loader' style='text-align: center;width:10%; margin:0 auto;'>
		      <img [src]="path !== undefined ? path : 'assets/img/preloader.gif'"/> <br/>
		      <span *ngIf="path === undefined">Идёт загрузка...</span>
		    </div>
		  </div>
	`,
	styles: [`
		:host.preloader .preloader-overlay{
	    height: 100%;
	    display: table;
	    width: 100%;
	}

	:host.preloader .loader{
	    text-align: center;
	    width:10%;
	    margin:0 auto;
	    display: table-cell;
	    vertical-align: middle;
	}`]
})

export class PreloaderComponent{
	@Input() path: string;
}	