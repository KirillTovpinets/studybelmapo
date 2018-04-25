import { Component, OnInit, Input, ElementRef } from '@angular/core';
import { GlobalParamsService } from '../Globalparams.service';
import { ShareService } from '../share/share.service';
import { DatabaseService } from '../admin/database.service';
import { Global } from '../model/global.class';
import { NotificationsService } from 'angular4-notify';
import { LogService } from '../share/log.service';

@Component({
  selector: 'dep-menu',
  templateUrl: './dep-menu.component.html',
  styleUrls: ['./dep-menu.component.css'],
  providers: [GlobalParamsService, DatabaseService]
})
export class DepMenuComponent implements OnInit {
  constructor(private selectedPage: GlobalParamsService,
    private menuManip: ShareService,
    private element: ElementRef,
    private log: LogService,
    private notify:NotificationsService,
    private database: DatabaseService){
  }
  currentUser: any;
  tables: string[];
  global: Global = new Global();
  ngOnInit(): void{
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
        this.log.SendError({page: 'menu', error: e, response: res._body});
        this.notify.addError("Произошла ошибка. Обратитесь к администратору");
      }
    })
  }
  return;
  }
  selectPage(v:number): void{
  this.selectedPage._selectedPage = v;
  }

}
