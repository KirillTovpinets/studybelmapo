import {Injectable } from "@angular/core";
import {Http} from "@angular/http";

import "rxjs/add/operator/toPromise";

@Injectable()

export class MakeOrderService{
	constructor(private http: Http){}
	create(data:any): Promise<any>{
		return this.http.post("php/makeOrder.php", data).toPromise();
	}
	getList(data:any): Promise<any>{
		return this.http.post("php/getCourseList.php", data).toPromise();
	}
}