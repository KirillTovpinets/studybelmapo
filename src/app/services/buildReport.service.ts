import {Injectable } from "@angular/core";
import {Http} from "@angular/http";

import "rxjs/add/operator/toPromise";

@Injectable()

export class BuildReportService{
	constructor(private http: Http){}
	build(params:any): Promise<any>{
		return this.http.post("assets/php/buildReport.php", params).toPromise();
	}
}