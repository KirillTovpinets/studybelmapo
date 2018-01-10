import { Injectable } from '@angular/core';
import { Headers, Http } from '@angular/http';

import 'rxjs/add/operator/toPromise';


@Injectable()

export class ArrivalsService{
	private path: string = "assets/php/getPersonalArrivals.php";
	constructor(public http: Http){}

	get(id:string): Promise<any>{
		return this.http.get(this.path + "?id=" + id)
					.toPromise();
	}
}