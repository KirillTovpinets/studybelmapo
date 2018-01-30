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

  ngOnInit() {
  	var table = this.router.snapshot.params["table"];
  	this.database.getDatabaseInfo("tablecontent", table).subscribe(res => console.log(res._body));
  }

}
