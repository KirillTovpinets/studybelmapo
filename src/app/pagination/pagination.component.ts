import { Component, OnInit, Input } from '@angular/core';

@Component({
  selector: 'app-pagination',
  templateUrl: './pagination.component.html',
  styleUrls: ['./pagination.component.css']
})
export class PaginationComponent implements OnInit {
	@Input("pagination") pagination: any[];
	@Input("total") numberOfPaginators:number;
  constructor() { }

  ngOnInit() {
  }

}
