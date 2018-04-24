import { Injectable } from '@angular/core';
import { Http } from '@angular/http';
import { Observable } from 'rxjs';

@Injectable()
export class HistoryService {
    constructor(private http: Http){}

    getHistory(personId): Observable<any>{
        return this.http.get("assets/php/getHistory.php?id=" + personId);
    }
}