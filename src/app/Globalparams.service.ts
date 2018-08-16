import { Injectable } from '@angular/core';

@Injectable()
export class GlobalParamsService {
	private _selectedPage:number = 0;
	constructor() {}

	public get selectedPage() : number {
		return this._selectedPage;
	}
	public set selectedPage(v : number) {
		this._selectedPage = v;
	}
}