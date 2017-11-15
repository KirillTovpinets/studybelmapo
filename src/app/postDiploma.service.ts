import { Injectable } from '@angular/core';
import { Headers, Http } from '@angular/http';

import 'rxjs/add/operator/toPromise';


@Injectable()

export class PostDiplomaService{
	private path: string = "php/getPostDiploma.php";
	constructor(public http: Http){}

	get(id:string): Promise<any>{
		return this.http.get(this.path + "?id=" + id)
					.toPromise();
	}
}