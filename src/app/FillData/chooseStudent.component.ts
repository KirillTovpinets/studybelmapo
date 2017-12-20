import { Component, OnInit, TemplateRef } from '@angular/core';
import { GetListService } from '../searchComponents/services/getPersonList.service';
import { ActivatedRoute } from '@angular/router';
import { BsModalService } from "ngx-bootstrap/modal";
import { BsModalRef } from 'ngx-bootstrap/modal/modal-options.class'
import { CurrentCourcesListService } from './services/getCurrentCourcesList.service';
@Component({
	template: `
	<div class="row">
		<div class="col-md-12">
			<a [routerLink]="['../../chooseCourse']" class="btn btn-primary pull-right">Назад</a>
			<a [routerLink]="['../../addNew', courseId]" class="btn btn-success pull-right">Создать</a>
		</div>
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
				<tr *ngFor="let doctor of students" (click)='confirm(doctor.id, template)' [ngClass]="{'active': selectedPerson === doctor}">
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
				<tr *ngFor="let doctor of searchResult" (click)='confirm(doctor, template)'>
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
		<ng-template #template>
			<div class="modal-body text-center">
				<p>Вы действительно хотите зачислить этого слушателя?</p>
				<button type="button" class="btn btn-success" (click)="forward()">Да</button>
				<button type="button" class="btn btn-danger" (click)="reject()">Нет</button>
			</div>
		</ng-template>
	`,
	styles: [`
		.active{
			background:#2e68c0;
		}
	`],
	providers: [GetListService, BsModalService, CurrentCourcesListService]
})
export class ChooseStudentComponent implements OnInit {
	constructor(private getList: GetListService,
				private getCourse: CurrentCourcesListService,
				private router: ActivatedRoute,
				private modalService: BsModalService) {}

	students: any[] = [];
	message: string = "";
	offset: number = 0;
	courseId:number = 0;
	modalRef: BsModalRef;
	courseName: string;
	selectedPerson: any;
	searchResult: any[] = [];
	ngOnInit() {
		this.getList.getList(30, this.offset, "all").then(response =>{
			this.students = response.json().data;
		})

		this.courseId = this.router.snapshot.params["id"];
	}
	Search($event):void{

	}
	confirm(person:any, template: TemplateRef<any>): void{
		this.selectedPerson = person;
		this.getCourse.getById(this.courseId).then(data => {
			this.courseName = data.json().name;
		});
		this.modalRef = this.modalService.show(template, {class: 'modal-md'})
	}	
	forward(): void{
		this.modalRef.hide();
	}
	reject(): void{
		this.modalRef.hide();
	}
}