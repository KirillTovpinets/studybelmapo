export class Certificate {
	private _courseId : number;
	private _DateGet : string;
	private _DateGetDate : Date;
	private _arrivalId : number;
	private _mark : number;
	private _docNumber : string;
	public get docNumber() : string {
		return this._docNumber;
	}
	public set docNumber(v : string) {
		this._docNumber = v;
	}
	public get mark() : number {
		return this._mark;
	}
	public set mark(v : number) {
		this._mark = v;
	}
	public get arrivalId() : number {
		return this._arrivalId;
	}
	public set arrivalId(v : number) {
		this._arrivalId = v;
	}
	public get DateGetDate() : Date {
		return this._DateGetDate;
	}
	public set DateGetDate(v : Date) {
		this._DateGetDate = v;
	}
	public get DateGet() : string {
		return this._DateGet;
	}
	public set DateGet(v : string) {
		this._DateGet = v;
	}
	public get courseId() : number {
		return this._courseId;
	}		
	public set courseId(v : number) {
		this._courseId = v;
	}
}