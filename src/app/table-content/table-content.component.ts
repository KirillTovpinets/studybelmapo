import { Component, OnInit, ViewChild, TemplateRef } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { DatabaseService } from '../admin/database.service';
import { BsModalService, BsModalRef } from 'ngx-bootstrap';
import { NotificationsService } from 'angular4-notify';
import { Global } from '../model/global.class';
@Component({
  selector: 'app-table-content',
  templateUrl: './table-content.component.html',
  providers: [DatabaseService, BsModalService],
  styleUrls: ['./table-content.component.css']
})
export class TableContentComponent implements OnInit {
  constructor(private router: ActivatedRoute,
  			  private database: DatabaseService,
          private modal: BsModalService,
          private notify: NotificationsService) { }
  thisTable:string;
  table: string;
  content:any[] = []
  fields: string[] = []
  details:string = "Ошибка"
  isLoading: boolean = false;
  offset:number = 0;
  limit:number = 25;
  pagination: any[] = [];
  numberOfPaginators: number = 0;
  totalData:number = 0;
  selectedButton: number = 0;
  edit: boolean = false;
  modalRef: BsModalRef;
  global: Global = new Global();
  confirmMessageStr:string = "";
  changedField: string = "";
  newValue: string = "";
  newData:any[] = [];
  ngOnInit() {
    this.router.paramMap.subscribe( params => this.getData(25, 0));
    this.getData();
  }
  getData(limit?:number, offset?:number, button?:number){
    this.isLoading = true;
    if (limit !== undefined && offset !== undefined) {
      this.limit = limit;
      this.offset = offset;
      this.selectedButton = button;
    }
    if (button == undefined) {
      this.selectedButton = 0;
      this.totalData = 0;
    }
    var data = {
      limit: this.limit,
      offset: this.offset
    }
    this.table = this.router.snapshot.params["table"];
    this.thisTable = this.global.tablesLabel.get(this.table);
    this.database.getDatabaseInfo("tablecontent", this.table, data).subscribe(res => {
      try{
        this.content = res.json().tablecontent;
        if (button == undefined) {
          this.pagination = [];
          this.totalData = res.json().Total;
          this.numberOfPaginators = Math.floor(this.totalData / this.limit);
          var balance = this.totalData % limit;
          if (balance !== 0 && this.numberOfPaginators != 0) {
            this.numberOfPaginators++;
          }
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
  EditAction(){
    this.edit = !this.edit;
  }
  ConfirmChanges(row:any){
    row.table = this.router.snapshot.params["table"];
    row.field = this.changedField;
    this.database.saveRowChanges(row, "edit").subscribe(res => {
      this.getData(25, 0)
      this.notify.addSuccess("Изменения сохранены");
      this.edit = false;
    })
  }
  setChangedField(field:string){
    this.changedField = field;
  }
  DeleteRow(row){
    this.database.saveRowChanges(row, "delete").subscribe(res => {
      this.getData(25, 0)
      this.notify.addSuccess("Изменения сохранены");
      this.edit = false;
    })
  }
  AddRow(){
    this.newData.push({});
  }
}
