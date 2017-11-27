import {Injectable} from '@angular/core';
import { Http } from '@angular/http';

import "rxjs/add/operator/toPromise";
@Injectable()


export class SearchSirnameService{
	constructor(private http: Http){}
	url:string = "php/SearchPerson.php";
	searchPerson(value): Promise<any>{
		return this.http.get(this.url + "?sirname=" + value).toPromise()
	}
}