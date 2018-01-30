import { Injectable } from '@angular/core';
import { Http } from '@angular/http';
import { Observable } from 'rxjs';	
@Injectable()
export class DatabaseService {

  constructor(private http: Http) { }

  getDatabaseInfo(param:string, table?:string): Observable<any>{
  	var url = 'assets/php/getDatabaseInfo.php?param=' + param;
  	if (table !== undefined) {
  		url += 'table=' + table; 
  	}
  	return this.http.get(url);
  }
}
