import { Injectable } from '@angular/core';
import { Http } from '@angular/http';

import 'rxjs/add/operator/toPromise';
@Injectable()
export class SaveArrivalService {
	url = "php/saveNewArrival.php"
	constructor(private http: Http) {}
	private data: any = {};
	save(person:any, course:any): Promise<any>{
		this.data.person = person;
		this.data.course = course;
		return this.http.post(this.url, this.data).toPromise();
	}
}