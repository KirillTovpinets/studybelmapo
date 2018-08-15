import { Component, OnInit, Input } from '@angular/core';
import { ShowPersonInfoService } from '../personalInfo/showPersonalInfo.service';

@Component({
  selector: 'table-certificates',
  templateUrl: './table-certificates.component.html',
  styleUrls: ['./table-certificates.component.css'],
  providers:[ShowPersonInfoService]
})
export class TableCertificatesComponent implements OnInit {

	@Input("certificates") inputList: any[];
  constructor(private showInfo: ShowPersonInfoService) { }

  ngOnInit() {
  }

}
