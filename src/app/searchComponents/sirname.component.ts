import { Component, OnInit } from '@angular/core';
import { SirnameService } from './services/sirname.service';

@Component({
	templateUrl: "../templates/searchComponents/sirname.component.html",
	providers: [SirnameService]
})

export class SirnameComponent implements OnInit{
	constructor(private sirnameServ: SirnameService){}
	students: any[] = []
	ngOnInit(): void{
		this.sirnameServ.getSirnames().then(data => this.students = data.json());
	}
}