import { Component } from "@angular/core";
import { GetListService } from "./services/getPersonList.service";
@Component({
	templateUrl: "../templates/searchComponents/organization.component.html",
	providers:[GetListService]
})

export class OrganizationComponent{
	constructor(private establService: GetListService){}
	organizations: any[] = [];
	offset: number = 0;
	limit: number = 30;
	ngOnInit(): void{
		this.establService.getList(this.limit, this.offset, "job").then(data => {
			console.log(data._body);
			this.organizations = data.json();
		});
	}
}