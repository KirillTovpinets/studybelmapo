export class SienceInfo{
	private _statusApproveDate: Date;
	private _statusApprove_date: string;
	private _statusSpeciality: string;
	private _statusCode: string;
	private _patentNumber: number;
	private _publicationsNumb: number;
	private _monografsNumb: number;
	private _ordenNumb: number;
	private _medalNumb: number;
	private _gramotaNumb: number;
	private _isDoctor: number;
	private _researchField:string;
	public get isDoctor(): number {
		return this._isDoctor; 
	}
	public get statusApproveDate() : Date {
		return this._statusApproveDate
	}
	public set statusApproveDate(v : Date) {
		this._statusApproveDate = v;
	}

	public get statusSpeciality() : string {
		return this._statusSpeciality
	}
	public set statusSpeciality(v : string) {
		this._statusSpeciality = v;
	}

	public get statusApprove_date() : string {
		return this._statusApprove_date
	}
	public set statusApprove_date(v : string) {
		this._statusApprove_date = v;
	}
	
	public get statusCode() : string {
		return this._statusCode;
	}
	public set statusCode(v : string) {
		this._statusCode = v;
	}

	public get researchField() : string {
		return this._researchField;
	}
	public set researchField(v : string) {
		this._researchField = v;
	}
	
	public get patentNumber() : number {
		return this._patentNumber;
	}
	public set patentNumber(v : number) {
		this._patentNumber = v;
	}
	
	public get publicationsNumb() : number {
		return this._publicationsNumb;
	}
	public set publicationsNumb(v : number) {
		this._publicationsNumb = v;
	}
	
	public get monografsNumb() : number {
		return this._monografsNumb;
	}
	public set monografsNumb(v : number) {
		this._monografsNumb = v;
	}
	
	public get ordenNumb() : number {
		return this._ordenNumb;
	}
	public set ordenNumb(v : number) {
		this._ordenNumb = v;
	}
	
	public get medalNumb() : number {
		return this._medalNumb;
	}
	public set medalNumb(v : number) {
		this._medalNumb = v;
	}
	
	public get gramotaNumb() : number {
		return this._gramotaNumb;
	}
	public set gramotaNumb(v : number) {
		this._gramotaNumb = v;
	}
	public set isDoctor(v: number){
		this._isDoctor = v; 
	}
	constructor(){
		// this._statusSpeciality = "12313";
		// this._statusCode = '1';
		// this._patentNumber = 1;
		// this._publicationsNumb = 1;
		// this._monografsNumb = 1;
		// this._ordenNumb = 1;
		// this._medalNumb = 1;
		// this._gramotaNumb = 1;
		// this._isDoctor = 1;
		// this._researchField = '1';
		// this._statusApprove_date = "";
	}
}