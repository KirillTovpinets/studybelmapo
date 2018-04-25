import { Component, OnInit, Input, ElementRef } from '@angular/core';
import { GlobalParamsService } from '../Globalparams.service';
import { ShareService } from '../share/share.service';
@Component({
  selector: 'dep-mob-menu',
  templateUrl: './dep-mob-menu.component.html',
  styleUrls: ['./dep-mob-menu.component.css'],
  providers: [GlobalParamsService]
})
export class DepMobMenuComponent implements OnInit {

  constructor(private selectedPage: GlobalParamsService,
    private menuManip: ShareService,
    private element: ElementRef){
  }
  currentUser:any;
  ngOnInit(): void{
  this.currentUser = JSON.parse(localStorage.getItem('currentUser'));
  this.menuManip.currentMessage.subscribe(message =>{
    this.element.nativeElement.style.display = message ? "block": "none";
    this.element.nativeElement.style.right = "0";
    this.element.nativeElement.style.left = "initial";
  });
  this.selectedPage._selectedPage = 1;
  return;
  }
  selectPage(v:number): void{
  this.selectedPage._selectedPage = v;
  }

}
