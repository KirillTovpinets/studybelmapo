import { Injectable } from '@angular/core';
import { BehaviorSubject } from "rxjs/BehaviorSubject";

@Injectable()
export class ShareService {

	public message = new BehaviorSubject<boolean>(true);
	currentMessage = this.message.asObservable();
  	constructor() { }

  	changeMessage(message: boolean){
  		this.message.next(message);
  	}

}
