import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { DatabaseService } from '../admin/database.service';
@Component({
  selector: 'app-table-content',
  templateUrl: './table-content.component.html',
  providers: [DatabaseService],
  styleUrls: ['./table-content.component.css']
})
export class TableContentComponent implements OnInit {

  constructor(private router: ActivatedRoute,
  			  private database: DatabaseService) { }
  tablesLabel =  new Map<string, string>();
  thisTable:string;
  table: string;
  content:any[] = []
  fields: string[] = []
  details:string = ""
  isLoading: boolean = false;
  offset:number = 0;
  limit:number = 25;
  pagination: any[] = [];
  numberOfPaginators: number = 0;
  ngOnInit() {
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

    this.router.paramMap.subscribe( params => this.getData(25, 0));
    this.getData();
  }
  getData(limit?:number, offset?:number){
    this.isLoading = true;
    if (limit !== undefined && offset != undefined) {
      this.limit = limit;
      this.offset = offset;
    }
    var data = {
      limit: this.limit,
      offset: this.offset
    }
    this.table = this.router.snapshot.params["table"];
    this.thisTable = this.tablesLabel.get(this.table);
    this.database.getDatabaseInfo("tablecontent", this.table, data).subscribe(res => {
      try{
        this.content = res.json().tablecontent;
        if (limit == undefined && offset == undefined) {
          var totalData = res.json().Total;
          this.numberOfPaginators = Math.floor(totalData / this.limit);
          var offset = this.offset;
          var limit = this.limit;
          for (var i = 0; i < this.numberOfPaginators; i++) {
            var paginator = {
              limit: limit,
              offset: offset
            }
            offset += this.limit;
            this.pagination.push(paginator);
          }
        }
        var row = this.content[0];
        this.fields = [];
        for (var field in row) {
          this.fields.push(field);
        }
      }catch(e){
        console.log(e);
        console.log(res._body);
      }
      this.isLoading = false;
    });
  }
  Details(row:any, field:string){
    this.details = "";
    var data = {
      row: row,
      field: field
    }
    this.database.getDatabaseInfo("fieldcontent", this.table, data).subscribe(res => {
      try{
        this.details = res.json().fieldcontent[0].name
      }catch(e){
        this.details = "Нет информации"
        console.log(e);
        console.log(res._body);
      }

    });
  }
}
