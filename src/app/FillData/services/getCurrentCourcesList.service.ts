import { Injectable } from '@angular/core';
import { Http } from '@angular/http';

import 'rxjs/add/operator/toPromise';
@Injectable()
export class CurrentCourcesListService {
	url = "assets/php/getCurrentCoursesList.php"
	constructor(private http: Http) {}

	get(): Promise<any>{
		return this.http.get(this.url).toPromise();
	}
	getById(id:number):Promise<any>{
		return this.http.get(this.url + "?id=" + id).toPromise();
	}

	getArchive(): Promise<any>{
		return this.http.get("assets/php/getCourseList.php").toPromise();
	}
	getArchiveByYear(year):Promise<any>{
		return this.http.get("assets/php/getCourseList.php?year=" + year).toPromise();
	}
}