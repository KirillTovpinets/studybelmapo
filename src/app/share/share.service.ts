import { BehaviorSubject } from "rxjs/BehaviorSubject";
import { Injectable } from '@angular/core';
@Injectable()
export class ShareService {

	public message = new BehaviorSubject<boolean>(true);
	currentMessage = this.message.asObservable();
	totalTasks:number = 0;

	_totalTasks: BehaviorSubject<number> = new BehaviorSubject<number>(0);
	_tasks: BehaviorSubject<Array<any>> = new BehaviorSubject<Array<any>>([]);
  	constructor() { }

  	changeMessage(message: boolean){
  		this.message.next(message);
	  }
	  
	setNumberOfTasks(total:number){
		this._totalTasks.next(total);
	}
	setTasks(list: any[]){
		this._tasks.next(list);
	}

}
