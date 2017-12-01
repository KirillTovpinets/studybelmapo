import { Component, OnInit } from '@angular/core';
import { PersonalDataService } from "./services/personalData.service";
@Component({
	templateUrl: "templates/addStudent.component.html",
	providers: [PersonalDataService]
})

export class AddStudentComponent implements OnInit{
	private faculties:any[] = [];
	private educTypes: any[] = [];
	constructor(private dataService: PersonalDataService){}
	ngOnInit():void{
		this.dataService.getData().then(data => {
			for (var faculty in data.json().facBel) {
				this.faculties.push(faculty);
			}
			for (var type in data.json().educTypeBel) {
				this.educTypes.push(type);
			}
			for (var type in data.json().educTypeBel) {
				this.educTypes.push(type);
			}
		});
	}
}