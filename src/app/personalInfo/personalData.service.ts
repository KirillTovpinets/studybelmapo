import {Injectable } from "@angular/core";
import {Http} from "@angular/http";
import { Person } from '../model/person.class';
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
	check(person: Person): Promise<any>{
		return this.http.post("assets/php/checkPerson.php", person).toPromise();
	}
	getMarkList():Promise<any>{
		return this.http.get("assets/php/getParams.php?marks=1").toPromise();	
	}
	getTypeList():Promise<any>{
		return this.http.get("assets/php/getParams.php?type=1").toPromise();	
	}
	deduct(data:any): Promise<any>{
		return this.http.post("assets/php/deduct.php", data).toPromise();		
	}
}