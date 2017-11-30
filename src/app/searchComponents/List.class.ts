export class List{
	public id: number;
	private doctors: any[];
	public offset: number;
	public limit: number;
	public parameters: any;
	public scrollCounter: number;
	public searchValue: string;
	public searchResult: any[];
	public total: number;
	public name: string;
	public canLoad:boolean;
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
}
