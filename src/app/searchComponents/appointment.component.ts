import { Component, OnInit } from "@angular/core";
import { GetListService } from "./services/getPersonList.service";
@Component({
	templateUrl: "../templates/searchComponents/appointment.component.html",
	providers:[GetListService]
})

export class AppointmentComponent implements OnInit{
	constructor(private establService: GetListService){}
	appointments: any[] = [];
	offset: number = 0;
	limit: number = 30;
	ngOnInit(): void{
		this.establService.getList(this.limit, this.offset, "appointment").then(data => {
			console.log(data._body);
			this.appointments = data.json();
		});
	}
}