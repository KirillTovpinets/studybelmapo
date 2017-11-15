import { Injectable } from "@angular/core";
import { Http } from "@angular/http";

import 'rxjs/add/operator/toPromise';
@Injectable()

export class SirnameService{
	constructor(private http: Http){}

	url:string = "php/getSirnames.php";
	getSirnames(): Promise<any>{
		return this.http.get(this.url).toPromise();
	}
}