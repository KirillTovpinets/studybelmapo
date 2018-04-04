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
    let that = this;
  	setInterval(function(){
        that.log.getLog().subscribe(res => {
          var element = document.querySelector("#content");
          if(element !== null){
            element.innerHTML = res._body;
          }
        });
    }, 1000)
  }
}
