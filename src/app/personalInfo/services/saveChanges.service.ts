import { Injectable } from '@angular/core';
import { Http } from "@angular/http";
import { Observable } from 'rxjs';
import { Person } from "../../model/person.class";
@Injectable()
export class SaveChangesService {
	
	constructor(private http: Http) {}

	save(person:Person): Observable<any>{
		return this.http.post("php/saveChanges.php", person);
	}
}