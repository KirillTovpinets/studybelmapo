import { Component, OnInit } from "@angular/core";
import { GetListService } from "./services/getPersonList.service";
@Component({
	templateUrl: "../templates/searchComponents/establishment.component.html",
	providers:[GetListService]
})

export class EstablishmentComponent implements OnInit{
	constructor(private establService: GetListService){}
	establs: any[] = [];
	offset: number = 0;
	limit: number = 30;
	ngOnInit(): void{
		this.establService.getList(this.limit, this.offset, "establishment").then(data => {
			console.log(data._body);
			this.establs = data.json();
		});
	}
}