import { Injectable } from '@angular/core';
import { Headers, Http } from '@angular/http';
import { Login } from './login';

import 'rxjs/add/operator/toPromise';

@Injectable()
export class LoginService{
	private loginUrl = 'php/login.php';
	constructor(private http: Http){};
	tryLogin(login): Promise<any>{
		return this.http.post(this.loginUrl, login)
					.toPromise();
	}
}