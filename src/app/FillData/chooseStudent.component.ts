import { Component, OnInit } from '@angular/core';
import { GetListService } from '../searchComponents/services/getPersonList.service';
import { ActivatedRoute } from '@angular/router';
@Component({
	template: `
	<div class="row">
		<a [routerLink]="['../../chooseCourse']" class="btn btn-primary pull-right">Назад</a>
		<a [routerLink]="['../../addNew', courseId]" class="btn btn-success pull-right">Создать</a>
	</div>
		<form>
			<label for="">Поиск по фамилии</label>
			<input type="text" class="form-control" (keyup)="Search($event)">
		</form>
		<div class="content table-responsive table-full-width">
			<table class="table table-striped table-hover" *ngIf="searchResult.length === 0">
				<tr>
					<th>Фамилия</th>
					<th>Имя</th>
					<th>Отчество</th>
					<th>Дата рождения</th>
				</tr>
				<tr *ngFor="let doctor of students" routerLink='checkInfo(doctor.id)'>
					<td>{{ doctor.surname }}</td>
					<td>{{ doctor.name }}</td>
					<td>{{ doctor.patername }}</td>
					<td>{{ doctor.birthday | date: "dd.MM.yyyy"}}</td>
				</tr>
				<tr *ngIf="message.length != 0">
					<td>{{ message }}</td>
				</tr>
			</table>
			<table class="table table-striped table-hover" *ngIf="searchResult.length !== 0">
				<tr>
					<th>Фамилия</th>
					<th>Имя</th>
					<th>Отчество</th>
					<th>Дата рождения</th>
				</tr>
				<tr *ngFor="let doctor of searchResult" routerLink='checkInfo(doctor.id)'>
					<td>{{ doctor.surname }}</td>
					<td>{{ doctor.name }}</td>
					<td>{{ doctor.patername }}</td>
					<td>{{ doctor.birthday | date: "dd.MM.yyyy"}}</td>
				</tr>
				<tr *ngIf="message.length != 0">
					<td>{{ message }}</td>
				</tr>
			</table>
		</div>
	`,
	providers: [GetListService]
})
export class ChooseStudentComponent implements OnInit {
	constructor(private getList: GetListService,
				private router: ActivatedRoute) {}

	students: any[] = [];
	message: string = "";
	offset: number = 0;
	courseId:number = 0;
	searchResult: any[] = [];
	ngOnInit() {
		this.getList.getList(30, this.offset, "all").then(response =>{
			this.students = response.json().data;
		})

		this.courseId = this.router.snapshot.params["id"];
	}
	Search($event):void{

	}
	checkInfo():void{

	}
}