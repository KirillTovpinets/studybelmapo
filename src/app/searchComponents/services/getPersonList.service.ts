import { Injectable } from "@angular/core";
import { Http } from "@angular/http";

import 'rxjs/add/operator/toPromise';

@Injectable()
export class GetListService{
	constructor(private http: Http){}

	url:string = "php/getPersonList.php";
	data:any = {};
	getList(limit:number, offset:number, info:string, parameters?:any): Promise<any>{
		this.data.limit = limit;
		this.data.offset = offset;
		this.data.info = info;
		if (parameters !== undefined) {
			this.data.params = parameters;
		}

		console.log(parameters);
		return this.http.post(this.url, this.data).toPromise();
	}
}