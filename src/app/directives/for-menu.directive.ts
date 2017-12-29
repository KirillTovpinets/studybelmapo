import { Directive, ElementRef, OnInit } from '@angular/core';
import { ShareService } from '../services/share.service';
@Directive({
  selector: '[appformenu]'
})
export class ForMenuDirective implements OnInit{

  constructor(private element: ElementRef,
  			private menu: ShareService) { 
  }

  ngOnInit(): void{
  	console.log(this.element);
  	this.menu.currentMessage.subscribe(message => {
  		console.log("mesage");
  		this.element.nativeElement.style.transform = "translateX(-280px);"
  	})
  }

}
