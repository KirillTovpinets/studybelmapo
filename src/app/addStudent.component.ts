import { Component, OnInit } from '@angular/core';
import { PersonalDataService } from "./services/personalData.service";
@Component({
	templateUrl: "templates/addStudent.component.html",
	providers: [PersonalDataService]
})

export class AddStudentComponent implements OnInit{
	constructor(private dataService: PersonalDataService){}
	ngOnInit():void{
		this.dataService.getData().then(data => console.log(data._body));
	}
}