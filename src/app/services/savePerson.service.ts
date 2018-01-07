import {Injectable } from "@angular/core";
import {Http} from "@angular/http";

import "rxjs/add/operator/toPromise";

@Injectable()

export class PersonService{
	constructor(private http: Http){}
	save(person:any): Promise<any>{
		return this.http.post("assets/php/savePerson.php", person).toPromise();
	}
	saveParameter(newValue:any): Promise<any>{
		return this.http.post("assets/php/saveParameter.php", newValue).toPromise();
	}
}