import { BehaviorSubject } from "rxjs/BehaviorSubject";
import { Injectable } from '@angular/core';
@Injectable()
export class ShareService {

	public message = new BehaviorSubject<boolean>(true);
	currentMessage = this.message.asObservable();
	totalTasks:number = 0;
	updateData:any[] = [];

	_totalTasks: BehaviorSubject<number> = new BehaviorSubject<number>(0);
	_tasks: BehaviorSubject<Array<any>> = new BehaviorSubject<Array<any>>([]);
	_updateData: BehaviorSubject<Array<any>> = new BehaviorSubject<Array<any>>([]);

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

	setUpdates(list: any[]){
		console.log(list);
		let currentValue = this._updateData.getValue();
		currentValue = currentValue.concat(list);
		this._updateData.next(currentValue);
	}
	deleteUpdates(value: string){
		for(let item of this.updateData){
			if(item.info == value){
				let index = this.updateData.indexOf(item);
				this.updateData.splice(index, 1);
			}
		}
		this._updateData.next(this.updateData);
	}

}
