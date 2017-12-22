import { Injectable } from '@angular/core';
import { Http } from '@angular/http';
import { Observable } from 'rxjs';
@Injectable()
export class NavbarService {
  
  constructor(private http: Http) { }

  getInfo():Observable<any>{
  	return this.http.get("php/checkLogin.php");
  }

  logout():Observable<any>{
  	return this.http.get("php/logout.php");
  }
}
