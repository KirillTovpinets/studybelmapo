import { Injectable } from '@angular/core';
import { Headers, Http } from '@angular/http';
import { Login } from './login';

import 'rxjs/add/operator/toPromise';

@Injectable()
export class LoginService{
	private loginUrl = 'assets/php/login.php';
	private isLogedIn = false;

	constructor(private http: Http){};

	tryLogin(login): Promise<any>{
		return this.http.post(this.loginUrl, login)
					.toPromise();
	}
	getDepList(table:string): Promise<any>{
		return this.http.get("assets/php/getDepList.php?table=" + table).toPromise();
	}
	setUserLogedIn(): void {
		this.isLogedIn = true;
	}
	getUserLogedIn(): boolean{
		return this.isLogedIn;
	}
}