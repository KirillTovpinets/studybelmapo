import { Component, Input, OnInit } from '@angular/core';
import { BsModalRef } from "ngx-bootstrap/modal/modal-options.class"
import { TableListCopmonent } from "./tableList.component";

@Component({
	selector: 'personal-info',
	templateUrl: 'templates/personalInfo.component.html',
	styleUrls: ['css/personalInfo.component.css'],
})

export class PersonalInfoComponent{
	title: string = "";
	person: any = {};
	
	constructor(public PIModal: BsModalRef ){
		
	}
}