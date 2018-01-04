export class Retraining{
	private _name : any;
	private _diploma_number : string;
	private _diploma_start : string;
	private _diploma_startDate : Date;
	public get diploma_startDate() : Date {
		return this._diploma_startDate;
	}
	public set diploma_startDate(v : Date) {
		this._diploma_startDate = v;
	}
	public get diploma_start() : string {
		return this._diploma_start;
	}
	public set diploma_start(v : string) {
		this._diploma_start = v;
	}
	public get diploma_number() : string {
		return this._diploma_number;
	}
	public set diploma_number(v : string) {
		this._diploma_number = v;
	}
	public get name() : any {
		return this._name;
	}
	public set name(v : any) {
		this._name = v;
	}
}
export class ProfesionalInfo{
	private _experiance_general:number;
	private _experiance_special:number;
	private _experiance_last:number;
	private _mainCategory:number;
	private _addCategory:number;
	private _diploma_start: string;
	private _diploma_number:string;
	private _educational_establishment:any;
	private _faculty:any;
	private _speciality_doc:any;
	private _speciality_other:any;
	private _speciality_retraining:Retraining[];
	private _qualification_main:any;
	private _qualification_add:any;
	private _qualification_other:any;
	private _diploma_startDate: Date;
	private _mainCategoryDate: Date;
	private _addCategoryDate: Date;
	private _addCategory_date : string;
	private _mainCategory_date : string;
	public get addCategory_date() : string {
		return this._addCategory_date;
	}
	public set addCategory_date(v : string) {
		this._addCategory_date = v;
	}
	public get mainCategory_date() : string {
		return this._mainCategory_date;
	}
	public set mainCategory_date(v : string) {
		this._mainCategory_date = v;
	}

	public get educational_establishment() :number {
		return this._educational_establishment; 
	}
	public get diploma_start():  string {
		return this._diploma_start; 
	}
	public get diploma_startDate(): Date {
		return this._diploma_startDate; 
	}
	public get experiance_general() :number {
		return this._experiance_general; 
	}
	public get experiance_special() :number {
		return this._experiance_special; 
	}
	public get experiance_last() :number {
		return this._experiance_last; 
	}
	public get faculty() :number {
		return this._faculty; 
	}
	public get speciality_doc() :number {
		return this._speciality_doc; 
	}
	public get speciality_other() :number {
		return this._speciality_other; 
	}
	public get speciality_retraining() :Retraining[] {
		return this._speciality_retraining; 
	}
	public get qualification_main() :number {
		return this._qualification_main; 
	}
	public get qualification_add() :number {
		return this._qualification_add; 
	}
	public get qualification_other() :number {
		return this._qualification_other; 
	}
	public get diploma_number() :string {
		return this._diploma_number; 
	}
	public get mainCategory() : number {
	 	return this._mainCategory;
	 }
	public get addCategory() : number {
	 	return this._addCategory;
	 }
	public get mainCategoryDate() : Date {
		return this._mainCategoryDate;
	}
	public set mainCategoryDate(v : Date) {
		this._mainCategoryDate = v;
	}
	public set experiance_general(v: number) {
		this._experiance_general = v; 
	}
	public set experiance_special(v: number) {
		this._experiance_special = v; 
	}
	public set experiance_last(v: number) {
		this._experiance_last = v; 
	}
	public set faculty(v: number) {
		this._faculty = v; 
	}
	public set speciality_doc(v: number) {
		this._speciality_doc = v; 
	}
	public set speciality_other(v: number) {
		this._speciality_other = v; 
	}
	public set speciality_retraining(v: Retraining[]) {
		this._speciality_retraining = v; 
	}
	public set qualification_main(v: number) {
		this._qualification_main = v; 
	}
	public set qualification_add(v: number) {
		this._qualification_add = v; 
	}
	public set qualification_other(v: number) {
		this._qualification_other = v; 
	}
	public set diploma_number(v: string) {
		this._diploma_number = v; 
	}
	public set mainCategory(v : number) {
		this._mainCategory = v;
	}
	public set addCategory(v : number) {
		this._addCategory = v;
	}
	public get addCategoryDate() : Date {
		return this._addCategoryDate;
	}
	public set addCategoryDate(v : Date) {
		this._addCategoryDate = v;
	}
	public set educational_establishment(v: number) {
		this._educational_establishment = v; 
	}
	public set diploma_startDate(v: Date){
		this._diploma_startDate = v; 
	}
	public set diploma_start(v: string){
		this._diploma_start = v; 
	}
	constructor(){
		this._speciality_retraining = [];
		this._faculty = {id: 152, value: "Автоматизированная система управления"};
		this._educational_establishment = {id: 115, value: "1-й Московский государственный медицинский институт"};
		this._speciality_doc = {id: 21, value: "Валеология"};
		this._speciality_other = {id: 112, value: "Агроном"};
		this._qualification_main = {id: 6, value: "Врач лабораторной диагностики"};
		this._qualification_other = {id: 42, value: "Врач магнито-резонансной томографии"};
		this._qualification_add = {id: 59, value: "Биолог-аналитик, преподаватель биологии"};
		this._diploma_startDate = new Date(2017,3,3);
		this._diploma_number = "13579";	
		this._mainCategoryDate = new Date(2017,2,5);
		this._addCategoryDate = new Date(2017,12,5);
		this._experiance_general = 12;
		this._experiance_special = 20;
		this._experiance_last = 5;
		this._mainCategory = 1;
		this._addCategory = 1;
	}
}