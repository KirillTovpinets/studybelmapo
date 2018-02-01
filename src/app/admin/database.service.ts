import { Injectable } from '@angular/core';
import { Http } from '@angular/http';
import { Observable } from 'rxjs';	
@Injectable()
export class DatabaseService {

  constructor(private http: Http) { }

  getDatabaseInfo(param:string, table?:string, data?:any): Observable<any>{
  	var url = 'assets/php/getDatabaseInfo.php?param=' + param;
  	if (table !== undefined) {
  		url += '&table=' + table; 
  	}
  	if( data !== undefined){
  		for (var i in data) {
  			url += "&" + i + "=" + data[i];
  		}
  	}
  	return this.http.get(url);
  }
  saveRowChanges(row:any, action: string){
    var url = 'assets/php/setDatabaseInfo.php';
    row.action = action;
    return this.http.post(url, row);
  }
}
