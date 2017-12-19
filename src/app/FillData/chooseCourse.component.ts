import { Component, OnInit } from '@angular/core';
import { CurrentCourcesListService } from './services/getCurrentCourcesList.service';

@Component({
	template: `
		<div class="content table-responsive table-full-width">
			<table class="table table-striped table-hover">
				<tr>
					<th>Номер</th>
					<th>Название</th>
					<th>Начало</th>
					<th>Конец</th>
					<th>Набор</th>
					<th>Инфо</th>
				</tr>
				<tr *ngFor="let course of CourseList" [routerLink]="['../chooseStudent', course.id]">
					<td>{{ course.Number }}</td>
					<td>{{ course.name }}</td>
					<td>{{ course.Start | date: "dd.MM" }}</td>
					<td>{{ course.Finish | date: "dd.MM" }}</td>
					<td>{{ course.Size }}</td>
					<td>{{ course.Notes }}</td>
				</tr>
				<tr *ngIf="message.length != 0">
					<td>{{ message }}</td>
				</tr>
			</table>
		</div>
	`,
	providers: [CurrentCourcesListService]
})
export class ChooseCourseComponent implements OnInit {
	constructor(private getList: CurrentCourcesListService) {}

	CourseList: any[] = [];
	message: string = "";
	ngOnInit() {
		this.getList.get().then(data => {
			try{
				this.CourseList = data.json();
			}catch(e){
				this.message = data._body;
			}
		});
	}
}