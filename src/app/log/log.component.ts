import { Component, OnInit } from '@angular/core';
import { LogService } from '../share/log.service';
@Component({
  selector: 'app-log',
  templateUrl: './log.component.html',
  styleUrls: ['./log.component.css']
})
export class LogComponent implements OnInit {

  constructor(private log: LogService) { }

  ngOnInit() {
  	var intervar = setInterval(this.getContent(), 1000);
  }

  getContent(){
    console.log("HELLO");
    this.log.getLog().subscribe(res => {
      var element = document.querySelector("#content");
      element.innerHTML = res._body;
    });
  }
}
