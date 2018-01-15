import { Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs/BehaviorSubject';

@Injectable()
export class StudListService {

	public total = new BehaviorSubject<number>(0);
	currentTotal = this.total.asObservable();
  constructor() { }

  changeTotal(value:number){
  	this.total.next(value);
  }

}
