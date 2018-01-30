export class PrivateInfo{
	private _isMale:boolean;
	private _cityType:number;
	private _birthday:string;
	// private _tel_number:string;
	private _insurance_number:string;
	private _street: string;
	private _building: string;
	private _flat: string;
	private _tel_number_home:string;
	private _tel_number_work:string;
	private _tel_number_mobile:string;
	private _cityzenship:any;
	private _country:any;
	private _region:any;
	private _city:any;
	private _pasport_seria: string;
	private _pasport_number: string;
	private _pasportDate: Date;
	private _pasport_date: string;
	private _pasport_organ: string;
	private _birthdayDate : Date;

	public get birthdayDate() : Date {
		return this._birthdayDate;
	}
	public set birthdayDate(v : Date) {
		this._birthdayDate = v;
	}
	public get birthday() :string {
		return this._birthday; 
	}
	public get cityzenship() :number {
		return this._cityzenship; 
	}
	public get isMale(): boolean {
		return this._isMale; 
	}
	public get region() :any {
		return this._region; 
	}
	// public get tel_number() :string {
	// 	return this._tel_number; 
	// }
	public get insurance_number() :string {
		return this._insurance_number; 
	}
	public get city() : any {
		return this._city;
	}
	public set city(v : any) {
		this._city = v;
	}
	public get cityType() : number {
		return this._cityType;
	}
	public set cityType(v : number) {
		this._cityType = v;
	}
	public get country() : any {
		return this._country;
	}
	public set country(v : any) {
		this._country = v;
	}
	public get street() : string {
		return this._street;
	}
	public set street(v : string) {
		this._street = v;
	}

	public get building() : string {
		return this._building;
	}
	public set building(v : string) {
		this._building = v;
	}
	public get flat() : string {
		return this._flat;
	}
	public set flat(v : string) {
		this._flat = v;
	}
	public set tel_number_home(v : string) {
		this._tel_number_home = v;
	}
	public get tel_number_home() : string {
		return this._tel_number_home;
	}

	public set tel_number_work(v : string) {
		this._tel_number_work = v;
	}
	public get tel_number_work() : string {
		return this._tel_number_work;
	}

	public set tel_number_mobile(v : string) {
		this._tel_number_mobile = v;
	}
	public get tel_number_mobile() : string {
		return this._tel_number_mobile;
	}
	public set birthday(v: string) {
		this._birthday = v; 
	}
	public set cityzenship(v: number) {
		this._cityzenship = v; 
	}
	public set isMale(v: boolean){
		this._isMale = v; 
	}
	public set region(v: any) {
		this._region = v; 
	}
	// public set tel_number(v: string) {
	// 	this._tel_number = v; 
	// }
	public set insurance_number(v: string) {
		this._insurance_number = v; 
	}
	public get pasport_seria() : string {
		return this._pasport_seria;
	}
	public set pasport_seria(v : string) {
		this._pasport_seria = v;
	}
	public get pasport_number() : string {
			return this._pasport_number;
		}	
	public set pasport_number(v : string) {
		this._pasport_number = v;
	}
	public get pasportDate() : Date {
			return this._pasportDate;
		}	
	public set pasportDate(v : Date) {
		this._pasportDate = v;
	}
	public get pasport_date() : string {
			return this._pasport_date;
		}	
	public set pasport_date(v : string) {
		this._pasport_date = v;
	}
	public get pasport_organ() : string {
			return this._pasport_organ;
		}	
	public set pasport_organ(v : string) {
		this._pasport_organ = v;
	}
	constructor(){
		// this._cityzenship = {id: 5, value: "Беларусь"};
		// this._country = {id: 5, value: "Беларусь"};
		// this._region = {id: 2, value: "Витебская"};
		// this._city = {id: 54, value: "Новолукомль"};
		// // this._tel_number = "+375298537596";
		// this._insurance_number = "4230653Е014РВ2";
		// this._cityType = 2;
		// this._street = "бульвар Озмителя";
		// this._building = "2";
		// this._flat = "37";
		// this._tel_number_home = "(29)853-75-96";
		// this._tel_number_work = "(29)853-75-96";
		// this._tel_number_mobile = "(29)853-75-96";
		// this._isMale = true;
		// this._birthdayDate = new Date(2009,30,1);
		// this._pasport_seria = "BM";
		// this._pasport_number = "1770368" 
		// this._pasportDate = new Date(2009,30,1);
		// this._pasport_organ = "Новолукомльское ГОМ Чашникского РОВД Витебской облалсти";
	}
}