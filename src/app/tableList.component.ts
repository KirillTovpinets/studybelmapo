import { Component, Input, OnInit, Directive } from "@angular/core";
import { ShowPersonInfoService } from "./personalInfo/showPersonalInfo.service";
import { PersonalInfoService } from './personalInfo.service';
import { BsModalService } from "ngx-bootstrap/modal";
@Component({
	selector: "table-list",
	templateUrl: "./templates/tableList.component.html",
	providers:[ShowPersonInfoService,PersonalInfoService,BsModalService]
})

export class TableListCopmonent{
	@Input('course') course: any;
	data: any;
	constructor(private showInfo: ShowPersonInfoService){}
}


