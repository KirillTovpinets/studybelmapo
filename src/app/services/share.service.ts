import { BehaviorSubject } from "rxjs/BehaviorSubject";
import { Injectable } from '@angular/core';
@Injectable()
export class ShareService {

	public message = new BehaviorSubject<boolean>(true);
	currentMessage = this.message.asObservable();
  	constructor() { }

  	changeMessage(message: boolean){
  		this.message.next(message);
  	}

}
