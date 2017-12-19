import { Component, OnInit } from '@angular/core';
import { NavbarService } from './navbar.service';
@Component({
	selector: 'navbar',
	templateUrl: 'templates/navbar.component.html',
	providers: [NavbarService]
})

export class NavbarComponent implements OnInit{
	constructor(private navInfo: NavbarService){

	}
	loginInfo:any;
	ngOnInit():void{
		this.navInfo.getInfo().subscribe(response => this.loginInfo = response.json());
	}
}