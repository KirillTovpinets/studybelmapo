export class GeneralInfo{
	private _surname:string;
	private _name: string;
	private _patername:string;
	private _nameInDativeForm:string;
	private _organization:any;
	private _appointment:any;
	private _department:any;

	public get surname() :string {
		return this._surname; 
	}
	public get name():  string {
		return this._name; 
	}
	public get patername() :string {
		return this._patername; 
	}

	public set surname(v: string) {
		this._surname = v; 
	}
	public set name(v: string){
		this._name = v; 
	}
	public set patername(v: string) {
		this._patername = v; 
	}
	public get nameInDativeForm() :string {
		return this._nameInDativeForm; 
	}

	public get organization() :number {
		return this._organization; 
	}
	public get appointment() :number {
		return this._appointment; 
	}
	public get department() :number {
		return this._department; 
	}

	public set nameInDativeForm(v: string) {
		this._nameInDativeForm = v; 
	}
	public set organization(v: number) {
		this._organization = v; 
	}
	public set appointment(v: number) {
		this._appointment = v; 
	}
	public set department(v: number) {
		this._department = v; 
	}
	constructor(){
		this._appointment = {id: 4, value: "Акушерка"};
		this._organization = {id: 4639, value: "1-я центральная клиническая районная поликлиника Центрального района г.Минска"};
		this._department = {id: 438, value: "1-е неврологическое отделение"};
		this._surname = "test";
		this._name = "test";
		this._patername = "test";
		this._nameInDativeForm = "test";
	}
}