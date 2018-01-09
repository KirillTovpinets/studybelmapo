export class Course {
	private _number : number;
	private _type : number;
	private _name : string;
	private _start : Date;
	private _startStr : string;
	private _finish : Date;
	private _finishStr : string;
	private _ducation : number;
	private _size : number;
	private _notes : string;
	public get notes() : string {
		return this._notes;
	}
	public set notes(v : string) {
		this._notes = v;
	}
	public get size() : number {
		return this._size;
	}
	public set size(v : number) {
		this._size = v;
	}
	public get ducation() : number {
		return this._ducation;
	}
	public set ducation(v : number) {
		this._ducation = v;
	}
	public get finishStr() : string {
		return this._finishStr;
	}
	public set finishStr(v : string) {
		this._finishStr = v;
	}
	public get finish() : Date {
		return this._finish;
	}
	public set finish(v : Date) {
		this._finish = v;
	}
	public get startStr() : string {
		return this._startStr;
	}
	public set startStr(v : string) {
		this._startStr = v;
	}
	public get start() : Date {
		return this._start;
	}
	public set start(v : Date) {
		this._start = v;
	}	
	public get name() : string {
		return this._name;
	}
	public set name(v : string) {
		this._name = v;
	}
	public get type() : number {
		return this._type;
	}
	public set type(v : number) {
		this._type = v;
	}
	public get number() : number {
		return this._number;
	}
	public set number(v : number) {
		this._number = v;
	}
}