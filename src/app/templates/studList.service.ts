import { Injectable } from '@angular/core';
import { Headers, Http } from '@angular/http';

import 'rxjs/add/operator/toPromise';

@Injectable()
export class InfoService{
	private getInfoUrl = 'php/getInfo.php';
	constructor(private http: Http){};
	getInfo(info:string): Promise<any>{
		return this.http.get(this.getInfoUrl + "?info=${info}")
					.toPromise();
	}
}