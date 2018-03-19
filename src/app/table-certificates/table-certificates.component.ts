import { Component, OnInit, Input } from '@angular/core';

@Component({
  selector: 'table-certificates',
  templateUrl: './table-certificates.component.html',
  styleUrls: ['./table-certificates.component.css']
})
export class TableCertificatesComponent implements OnInit {

	@Input("certificates") inputList: any[];
  constructor() { }

  ngOnInit() {
  }

}
