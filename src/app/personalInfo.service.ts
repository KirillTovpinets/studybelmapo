import { Injectable } from '@angular/core';
import { Headers, Http } from '@angular/http';

import 'rxjs/add/operator/toPromise';

const cathedras: string[] = [
	
]
@Injectable()
export class PersonalInfoService{
	private getInfoUrl = 'assets/php/getPersonalInfo.php';
	private saveChangesUrl = 'assets/php/saveChanges.php'
	constructor(private http: Http){};
	getInfo(id:string, selected?:boolean): Promise<any>{
		return this.http.get(this.getInfoUrl + "?id=" + id + "&selected=" + selected)
					.toPromise();
	}
	saveChanges(person:any){
		return this.http.post(this.saveChangesUrl, person).toPromise();
	}

	Deduct(person:any){
		
	}
}