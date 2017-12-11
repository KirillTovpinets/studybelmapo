import { Component } from "@angular/core";
import { BsDatepickerConfig } from "ngx-bootstrap/datepicker";
import { listLocales } from 'ngx-bootstrap/bs-moment';
import { MakeOrderService } from "./services/makeOrder.service";
import { Http } from "@angular/http";
import "rxjs/add/operator/toPromise";

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
	minDate = new Date(1970, 1, 1);
  	maxDate = new Date();
  	locale = "ru";
  	locales = listLocales();
  	data:any = {
  		dateTo: new Date()
  	};
  	message: string = "";
  	courses: any[] = [];
  	selectedCourses:any[] = [];
	bsConfig: Partial<BsDatepickerConfig> =  Object.assign({}, { containerClass: "theme-blue", locale: this.locale });

	constructor(private makeOrderService: MakeOrderService,
				private http: Http){}
	EnterAction(flag:number):void{
		this.data.type = flag;
	}
	BuildOrder(): void{
		this.makeOrderService.create(this.data).then(data => {
			console.log(data._body);
            var blob = new Blob([data.data], {type: 'application/vnd.msword'});
            var objectUrl = URL.createObjectURL(blob);   
            var filename = "doc.doc";
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
			}
			catch(e){
				this.courses = [];
				this.message = "Нет курсов удовлетворяющих запросу";
			}
		});
	}
	selectCourse(course:any): void{
		if (this.selectedCourses.indexOf(course) !== -1) {
			var index = this.selectedCourses.indexOf(course);
			this.selectedCourses.splice(index, 1);
		}else{
			this.selectedCourses.push(course);
		}
	}
}