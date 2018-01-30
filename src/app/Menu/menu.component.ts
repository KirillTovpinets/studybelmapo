import { Component, OnInit, Input, ElementRef } from '@angular/core';
import { GlobalParamsService } from '../Globalparams.service';
import { ShareService } from '../share/share.service';
import { DatabaseService } from '../admin/database.service';
@Component({
	selector: 'menu',
	templateUrl: './menu.component.html',
	styleUrls: ["../../css/pe-icon-7-stroke.css"],
	providers: [GlobalParamsService, DatabaseService]
})

export class MenuComponent implements OnInit{
	constructor(private selectedPage: GlobalParamsService,
				private menuManip: ShareService,
				private element: ElementRef,
				private database: DatabaseService){
	}
	currentUser: any;
	tables: string[];
	tablesLabel =  new Map<string, string>();
	ngOnInit(): void{
		this.tablesLabel.set("arrivals", "Приезды");
		this.tablesLabel.set("arrivals_zip", "Приезды (архив)");
		this.tablesLabel.set("belmapo_departments", "Отделы БелМАПО");
		this.tablesLabel.set("cathedras", "Кафедры");
		this.tablesLabel.set("certificates", "Свидетельства");
		this.tablesLabel.set("cities", "Города");
		this.tablesLabel.set("cities_backup", "Города (архив)");
		this.tablesLabel.set("countries", "Страны");
		this.tablesLabel.set("cources", "Сводный план");
		this.tablesLabel.set("cources_zip", "Сводных план (архив)");
		this.tablesLabel.set("department", "Отделы (ЛКС)");
		this.tablesLabel.set("district", "Области");
		this.tablesLabel.set("eductype", "Типы обучения");
		this.tablesLabel.set("faculties", "Факультеты БелМАПО");
		this.tablesLabel.set("formofeducation", "Формы обучений");
		this.tablesLabel.set("history_of_changes", "История изменений");
		this.tablesLabel.set("loginusers", "Авторизованные пользователи");
		this.tablesLabel.set("marks", "Оценки");
		this.tablesLabel.set("minsk_region", "Районы Минска");
		this.tablesLabel.set("organization_forms", "Формы организаций");
		this.tablesLabel.set("personal_appointment", "Должности");
		this.tablesLabel.set("personal_card", "Личные данные слушателей");
		this.tablesLabel.set("personal_department", "Отделы (ЛКС)");
		this.tablesLabel.set("personal_establishment", "Учебные заведения");
		this.tablesLabel.set("personal_faculty", "Факультеты");
		this.tablesLabel.set("personal_organizations", "Организации");
		this.tablesLabel.set("personal_organizations_new_backup", "Организации (архив)");
		this.tablesLabel.set("personal_organizations_new_backup_2", "Организации (архив 2)");
		this.tablesLabel.set("personal_private_info", "Персональные данные");
		this.tablesLabel.set("personal_prof_info", "Профессиональные данные");
		this.tablesLabel.set("personal_retrainings", "Переподготовки");
		this.tablesLabel.set("personal_sience", "Научная деятельность");
		this.tablesLabel.set("qual_spec_id", "Квал. спец-ти");
		this.tablesLabel.set("qualification_add", "Доп. квалификации");
		this.tablesLabel.set("qualification_main", "Осн. квалификации");
		this.tablesLabel.set("qualification_other", "Прочие квалификации");
		this.tablesLabel.set("regions", "Области");
		this.tablesLabel.set("residence", "Место жительства");
		this.tablesLabel.set("speciality_doct", "Врачебная специальность");
		this.tablesLabel.set("speciality_other", "Прочие специальности");
		this.tablesLabel.set("speciality_retraining", "Специальности по переподготовке");
		this.tablesLabel.set("status", "Статус");
		this.tablesLabel.set("table 39", "table 39");
		this.tablesLabel.set("table 43", "table 43");
		this.tablesLabel.set("users", "Пользователи");
		this.currentUser = JSON.parse(localStorage.getItem('currentUser'));
		this.menuManip.currentMessage.subscribe(message =>{
			this.element.nativeElement.style.display = message ? "block": "none";
			this.element.nativeElement.style.right = "0";
			this.element.nativeElement.style.left = "initial";
		 });
		this.selectedPage._selectedPage = 1;

		if (this.currentUser.login == "admin") {
			this.database.getDatabaseInfo("schema").subscribe(res => {
				try{
					this.tables = res.json().schema;
				}catch(e){
					console.log(e);
					console.log(res._body);
				}
			})
		}
		return;
	}
	selectPage(v:number): void{
		this.selectedPage._selectedPage = v;
	}
}