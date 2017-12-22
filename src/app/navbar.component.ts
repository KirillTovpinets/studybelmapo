import { Component, OnInit } from '@angular/core';
import { NavbarService } from './navbar.service';
import { Router } from '@angular/router';
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
				private router: Router){

	}
	loginInfo:any;
	ngOnInit():void{
		this.navInfo.getInfo().subscribe(response => this.loginInfo = response.json());
	}
	Logout():void{
		this.navInfo.logout().subscribe(response => this.router.navigate(['/login']))
	}
}