import {Injectable } from "@angular/core";
import {Http} from "@angular/http";

import "rxjs/add/operator/toPromise";

@Injectable()

export class SavePersonService{
	constructor(private http: Http){}
	save(person:any): Promise<any>{
		return this.http.post("php/savePerson.php", person).toPromise();
	}
}