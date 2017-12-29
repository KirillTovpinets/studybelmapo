import { Component, OnInit, Input } from '@angular/core';
import { NavbarService } from './navbar.service';
import { Router } from '@angular/router';
import { ShareService } from './services/share.service';
@Component({
	selector: 'navbar',
	templateUrl: 'templates/navbar.component.html',
	styles: [`
		.navbar-right li:hover{
			cursor:pointer;
		}
	`],
	providers: [NavbarService]
})

export class NavbarComponent implements OnInit{
	constructor(private navInfo: NavbarService,
				private router: Router,
				private menuManip: ShareService){

	}
	loginInfo:any;
	message:boolean;
	ngOnInit():void{
		this.navInfo.getInfo().subscribe(response => this.loginInfo = response.json());
		this.menuManip.currentMessage.subscribe(message =>{
		 	this.message = message
		 });
	}
	Logout():void{
		this.navInfo.logout().subscribe(response => this.router.navigate(['/login']))
	}
	ToggleMenu(){
		this.menuManip.changeMessage(!this.message);
	}
}