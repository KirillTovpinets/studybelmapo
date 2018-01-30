import { Injectable } from '@angular/core';
import { Http } from "@angular/http";
import { Observable } from 'rxjs';
import { Person } from "../model/person.class";
@Injectable()
export class SaveChangesService {
	
	constructor(private http: Http) {}

	save(person:Person, original:Person): Observable<any>{
		var data = {
			old: original,
			new: person
		}
		return this.http.post("assets/php/saveChanges.php", data);
	}
}