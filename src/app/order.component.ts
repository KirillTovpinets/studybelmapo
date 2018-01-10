import { Component } from "@angular/core";
import { BsDatepickerConfig } from "ngx-bootstrap/datepicker";
import { listLocales } from 'ngx-bootstrap/bs-moment';
import { MakeOrderService } from "./services/makeOrder.service";
import { Http } from "@angular/http";
import { Global } from './global.class';
import "rxjs/add/operator/toPromise";
import {NotificationsService} from 'angular4-notify';

@Component({
	templateUrl: './templates/order.component.html',
	providers: [MakeOrderService],
	styles:[`
		.table-striped>tbody>tr.selected{
			background-color: #9368E9;
			color:#fff;
		}
		.btn.selected{
			background:#888888;
			color:#fff;
		}
	`]
})

export class OrderComponent{
	bsValue: Date = new Date();
	globalParams: Global = new Global();
  	locales = listLocales();
  	data:any = {
  		dateTo: new Date(),
  		selectedCourses: [],
  		dateFrom: new Date()
  	};
  	message: string = "";
  	courses: any[] = [];
  	
	bsConfig: Partial<BsDatepickerConfig> =  Object.assign({}, { containerClass: "theme-blue", locale: this.globalParams.locale });

	constructor(private makeOrderService: MakeOrderService,
				private http: Http,
				private notify: NotificationsService){}
	EnterAction(flag:number):void{
		this.data.type = flag;
	}
	BuildOrder(): void{
		if (this.data.selectedCourses.length === 0) {
			this.notify.addError("Виберите курс");
			return;
		}else if(this.data.type == undefined){
			this.notify.addError("Виберите приказ");
			return;
		}
		this.makeOrderService.create(this.data).then(data => {
            var blob = new Blob([data._body], {type: 'application/vnd.msword'});
            var objectUrl = URL.createObjectURL(blob);   
            var filename = "doc.doc";
            var a = document.createElement("a");
            a.href = objectUrl;
            a["download"] = filename;

            var e = document.createEvent("MouseEvents");
            e.initMouseEvent("click", true, false,
			    document.defaultView, 0, 0, 0, 0, 0,
			    false, false, false, false, 0, null);
			a.dispatchEvent(e);
        });
	}
	GetCoursesList(value:Date, flag:number){
		if (flag === 0) {
			this.data.dateFrom = value.toISOString().slice(0, 10);
		}else{
			this.data.dateTo = value.toISOString().slice(0, 10);
		}
		this.makeOrderService.getList(this.data).then(data => {
			try{
				this.courses = data.json();
				this.message = "";
			}
			catch(e){
				console.log(data._body);
				this.courses = [];
				this.message = "Нет курсов удовлетворяющих запросу";
			}
		});
	}
	selectCourse(course:any): void{
		if (this.data.selectedCourses.indexOf(course) !== -1) {
			var index = this.data.selectedCourses.indexOf(course);
			this.data.selectedCourses.splice(index, 1);
		}else{
			this.data.selectedCourses.push(course);
		}
	}
}