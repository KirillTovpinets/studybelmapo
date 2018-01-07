import {Injectable } from "@angular/core";
import {Http} from "@angular/http";

import "rxjs/add/operator/toPromise";

@Injectable()

export class PersonalDataService{
	constructor(private http: Http){}
	getData(): Promise<any>{
		return this.http.get("assets/php/getParams.php").toPromise();
	}
	DropdownList(data:any):string{
		return data.value;
	}
}