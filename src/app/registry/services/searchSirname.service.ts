import {Injectable} from '@angular/core';
import { Http } from '@angular/http';

import "rxjs/add/operator/toPromise";
@Injectable()


export class SearchSirnameService{
	constructor(private http: Http){}
	url:string = "assets/php/SearchPerson.php";
	params:string = "";
	searchPerson(value, params?:any): Promise<any>{
		if (params !== undefined) {
			for (var key in params) {
				this.params += "&" + key + "=" + params[key];
			}
		}
		return this.http.get(this.url + "?sirname=" + value + this.params).toPromise()
	}
}