import { Injectable } from '@angular/core';
import { Headers, Http } from '@angular/http';

import 'rxjs/add/operator/toPromise';

const cathedras: string[] = [
	
]
@Injectable()
export class PersonalInfoService{
	private getInfoUrl = 'php/getPersonalInfo.php';
	constructor(private http: Http){};
	getInfo(id:string): Promise<any>{
		return this.http.get(this.getInfoUrl + "?id=" + id)
					.toPromise();
	}
}