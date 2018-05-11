import { Component, OnInit, Output } from '@angular/core';
import { DatabaseService } from '../admin/database.service';
import { tryParse } from 'selenium-webdriver/http';
import { ShareService } from '../share/share.service';

@Component({
  selector: 'app-help',
  templateUrl: './help.component.html',
  styleUrls: ['./help.component.css'],
  providers: [DatabaseService]
})
export class HelpComponent implements OnInit {
  @Output("taskNumber") taskNumber:number;
  constructor(private database: DatabaseService,
              private common: ShareService) { }

  tasks: any[] = [];

  ngOnInit() {
    this.common._tasks.subscribe(list => {
      this.tasks = list;
    })
  }

}
