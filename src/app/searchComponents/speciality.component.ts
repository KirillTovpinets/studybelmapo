import { Component, OnInit } from "@angular/core";
import { GetListService } from "./services/getPersonList.service";
@Component({
	templateUrl: "../templates/searchComponents/speciality.component.html",
	providers:[GetListService]
})

export class SpecialityComponent implements OnInit{
	constructor(private establService: GetListService){}
	specialities_main: any[] = [];
	specialities_retraining: any[] = [];
	specialities_others: any[] = [];
	offset: number = 0;
	limit: number = 30;
	ngOnInit(): void{
		this.establService.getList(this.limit, this.offset, "speciality").then(data => {
			console.log(data._body);
			this.specialities_main = data.json().main;
			this.specialities_retraining = data.json().retraining;
			this.specialities_others = data.json().others;
		});
	}
}