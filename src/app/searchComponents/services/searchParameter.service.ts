import {Injectable} from '@angular/core';
import { Http } from '@angular/http';

import "rxjs/add/operator/toPromise";
@Injectable()


export class SearchSirnameService{
	constructor(private http: Http){}
	url:string = "php/getPersonList.php";
	params:string = "";
	searchParameter(value, params?:any): Promise<any>{
		if (params !== undefined) {
			for (var key in params) {
				this.params += "&" + key + "=" + params[key];
			}
		}
		return this.http.get(this.url + "?name=" + value + this.params).toPromise()
	}
}