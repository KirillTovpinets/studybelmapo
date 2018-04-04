import { Injectable } from '@angular/core';
import { Http } from '@angular/http';
import { Observable } from 'rxjs';

@Injectable()
export class LogService {
	
	constructor(private http: Http) {}

	SendError(data): Observable<any>{
		return this.http.post("assets/php/log.php", data);
	}
	getLog(): Observable<any>{
		return this.http.get("assets/php/log.php");
	}
}