import { Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs/BehaviorSubject';
import { Http } from '@angular/http';
import { Observable } from 'rxjs';
@Injectable()
export class StudListService {

	public total = new BehaviorSubject<number>(0);
	currentTotal = this.total.asObservable();
  constructor(private http: Http) { }

  changeTotal(value:number){
  	this.total.next(value);
  }

  saveChanges(person:any): Observable<any>{
  	return this.http.post("assets/php/savePersonArrivalInfo.php", person)
  }
}
