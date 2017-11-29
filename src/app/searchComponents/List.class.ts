export class List{
	private doctors: any[];
	public offset: number;
	public limit: number;
	public parameters: any;
	public scrollCounter: number;
	public searchValue: string;
	public searchResult: any[];
	public total: number;
	public name: string;
	constructor(){
		this.offset = 0;
		this.limit = 30;
		this.doctors = [];
		this.parameters = {};
		this.scrollCounter = 400;
		this.searchValue = "";
		this.searchResult = [];
		this.total = 0;
		this.name = "";
	}

	setList(data:any):void{
		this.doctors = this.doctors.concat(data);
	}
	getList(): any[]{
		return this.doctors;
	}
}
