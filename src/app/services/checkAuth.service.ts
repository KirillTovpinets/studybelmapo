import { Injectable } from '@angular/core';
import { Http } from '@angular/http';
import { Observable } from 'rxjs';

@Injectable()
export class CheckAuthService {
	
	constructor(private http: Http) {}

	check():Observable<any>{
		return this.http.get("assets/php/checkLogin.php");
	}
}