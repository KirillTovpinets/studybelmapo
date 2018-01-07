import { Injectable } from '@angular/core';
import { Http } from '@angular/http';

import 'rxjs/add/operator/toPromise';
@Injectable()
export class StudentListService {
	url = "assets/php/getStudList.php"
	constructor(private http: Http) {}

	get(): Promise<any>{
		return this.http.get(this.url).toPromise();
	}
}