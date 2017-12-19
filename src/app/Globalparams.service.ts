import { Injectable } from '@angular/core';

@Injectable()
export class GlobalParamsService {
	private selectedPage:number = 0;
	constructor() {}

	public get _selectedPage() : number {
		return this.selectedPage;
	}
	public set _selectedPage(v : number) {
		this.selectedPage = v;
	}
}