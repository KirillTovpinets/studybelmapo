export class List{
	public id: number;
	private doctors: any[];
	private _currentDoctors : any[];
	public offset: number;
	public limit: number;
	public parameters: any;
	public scrollCounter: number;
	public searchValue: string;
	public searchResult: any[];
	public total: number;
	private _currentTotal : number;
	public name: string;
	public canLoad:boolean;
	public message: string;
	constructor(){
		this.id = 0;
		this.offset = 0;
		this.limit = 30;
		this.doctors = [];
		this.parameters = {};
		this.scrollCounter = 400;
		this.searchValue = "";
		this.searchResult = [];
		this.total = 0;
		this.name = "";
		this.canLoad = true;
	}

	setList(data:any):void{
		this.doctors = this.doctors.concat(data);
	}
	getList(): any[]{
		return this.doctors;
	}

	public get currentTotal() : number {
		return this._currentTotal;
	}
	public set currentTotal(v : number) {
		this._currentTotal = v;
	}
	public get currentDoctors() : any[] {
		return this._currentDoctors;
	}
	public set currentDoctors(v : any[]) {
		this._currentDoctors = v;
	}
}
