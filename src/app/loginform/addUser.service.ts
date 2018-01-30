import { Injectable } from "@angular/core";
import { Http } from "@angular/http";

import "rxjs/add/operator/toPromise";
@Injectable()

export class AddUserService{
	constructor(private http: Http){}

	add(user:any): Promise<any>{
		return this.http.post("assets/php/saveNewUser.php", user).toPromise();
	}
}