import { Injectable } from '@angular/core';
import { Headers, Http } from '@angular/http';

import 'rxjs/add/operator/toPromise';

const cathedras: string[] = [
	
]
@Injectable()
export class InfoService{
	private getInfoUrl = 'assets/php/getInfo.php';
	constructor(private http: Http){};
	getInfo(info:string): Promise<any>{
		return this.http.get(this.getInfoUrl + "?info=" + info)
					.toPromise();
	}
	saveCourse(data:any): Promise<any>{
		return this.http.post("assets/php/saveCourse.php", data).toPromise();
	}
}