import { Injectable } from '@angular/core';
import { Http } from '@angular/http';

import 'rxjs/add/operator/toPromise';
@Injectable()
export class CurrentCourcesListService {
	url = "assets/php/getCurrentCoursesList.php"
	constructor(private http: Http) {}

	get(param?): Promise<any>{
		return this.http.get(this.url + "?time=" + param).toPromise();
	}
	getById(id:number):Promise<any>{
		return this.http.get(this.url + "?id=" + id).toPromise();
	}

	getArchive(): Promise<any>{
		return this.http.get("assets/php/getCourseList.php").toPromise();
	}
	getArchiveByYear(year, params):Promise<any>{
		return this.http.get(`assets/php/getCourseList.php?year=${year}&limit=${params.limit}&offset=${params.offset}`).toPromise();
	}
	getArchiveByYearForCathedra(year, cathedra){
		return this.http.get(`assets/php/getCourseList.php?year=${year}&cathedra=${cathedra}`).toPromise();
	}
	getArchiveByCourse(course, params){
		return this.http.get(`assets/php/getArchiveInfo.php?course=${course}&limit=${params.limit}&offset=${params.offset}`).toPromise();
	}
}