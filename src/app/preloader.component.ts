import { Component } from "@angular/core";

@Component({
	selector: "preloader",
	template: `
		<div id='jpreloader' class='preloader-overlay'>
		    <div class='loader' style='text-align: center;width:10%; margin:0 auto;'>
		      <img src='assets/img/preloader.gif'/> <br/>
		      Идёт загрузка...
		    </div>
		  </div>
	`
})

export class PreloaderComponent{
	
}