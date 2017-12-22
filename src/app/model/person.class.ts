export class Person{
	private _birthdayDate: Date;
	private _diploma_startDate: Date;
	private _mainCategoryDate: Date;
	private _addCategoryDate: Date;

	private _isDoctor:boolean;
	private _isCowoker:boolean;
	private _isMale:boolean;
	
	private _id: number;
	private _experiance_general:number;
	private _experiance_special:number;
	private _experiance_last:number;
	private _mainCategory:number;
	private _addCategory:number;
	private _belmapo_faculty:number;
	private _belmapo_cathedra:number;
	private _belmapo_course:number;
	private _belmapo_educType:number;
	private _belmapo_residense:number;
	private _belmapo_educForm:number;
	private _belmapo_paymentData:number;
	private _cityType:number;
	
	private _surname:string;
	private _name: string;
	private _patername:string;
	private _birthday:string;
	private _nameInDativeForm:string;
	private _diploma_start: string;
	private _tel_number:string;
	private _insurance_number:string;
	private _diploma_number:string;
	private _belmapo_docNumber:string;
	private _mainCategory_date: string;
	private _addCategory_date: string;
	private _street: string;
	private _building: string;
	private _flat: string;
	private _tel_number_home:string;
	private _tel_number_work:string;
	private _tel_number_mobile:string;
	private _researchField:string;

	private _educational_establishment:any;
	private _organization:any;
	private _cityzenship:any;
	private _appointment:any;
	private _department:any;
	private _faculty:any;
	private _speciality_doc:any;
	private _speciality_other:any;
	private _speciality_retraining:any;
	private _qualification_main:any;
	private _qualification_add:any;
	private _qualification_other:any;
	private _country:any;
	private _region:any;
	private _city:any;
	private _statusApproveDate: Date;
	private _statusSpeciality: string;
	private _statusCode: string;
	private _patentNumber: number;
	private _publicationsNumb: number;
	private _monografsNumb: number;
	private _ordenNumb: number;
	private _medalNumb: number;
	private _gramotaNumb: number;
	constructor(){
		this._appointment = {id: 4, value: "Акушерка"};
		this._organization = {id: 4639, value: "1-я центральная клиническая районная поликлиника Центрального района г.Минска"};
		this._department = {id: 438, value: "1-е неврологическое отделение"};
		this._faculty = {id: 152, value: "Автоматизированная система управления"};
		this._educational_establishment = {id: 115, value: "1-й Московский государственный медицинский институт"};
		this._speciality_doc = {id: 21, value: "Валеология"};
		this._speciality_other = {id: 112, value: "Агроном"};
		this._speciality_retraining = {id: 17, value: "Аллергология и иммунология"};
		this._qualification_main = {id: 6, value: "Врач лабораторной диагностики"};
		this._qualification_other = {id: 42, value: "Врач магнито-резонансной томографии"};
		this._qualification_add = {id: 59, value: "Биолог-аналитик, преподаватель биологии"};
		this._cityzenship = {id: 3, value: "Армения"};
		this._country = {id: 3, value: "Армения"};
		this._region = {id: 1, value: "Брестская"};
		this._city = {id: 1, value: "Минск"};

		this._surname = "test";
		this._name = "test";
		this._patername = "test";
		this._birthday = "test";
		this._nameInDativeForm = "test";
		this._diploma_start = "";
		this._tel_number = "test";
		this._insurance_number = "test";
		this._diploma_number = "test";
		this._belmapo_docNumber = "test";

		this._id = 1;
		this._experiance_general = 1;
		this._experiance_special = 1;
		this._experiance_last = 1;
		this._belmapo_faculty = 1;
		this._belmapo_cathedra = 1;
		this._belmapo_course = 1;
		this._belmapo_educType = 1;
		this._belmapo_residense = 1;
		this._belmapo_educForm = 1;
		this._belmapo_paymentData = 1;
		this._mainCategory = 1;
		this._addCategory = 1;
		this._cityType = 2;
		this._street = "проспект Пушкина";
		this._building = "29";
		this._flat = "137";
		this._tel_number_home = "+37529853756";
		this._tel_number_work = "80298537596";
		this._tel_number_mobile = "2985396596";
	}
	public get id():  number {
		return this._id; 
	}
	public get surname() :string {
		return this._surname; 
	}
	public get name():  string {
		return this._name; 
	}
	public get patername() :string {
		return this._patername; 
	}
	public get birthday() :string {
		return this._birthday; 
	}
	public get birthdayDate(): Date {
		return this._birthdayDate; 
	}
	public get nameInDativeForm() :string {
		return this._nameInDativeForm; 
	}
	public get educational_establishment() :number {
		return this._educational_establishment; 
	}
	public get cityzenship() :number {
		return this._cityzenship; 
	}
	public get isDoctor(): boolean {
		return this._isDoctor; 
	}
	public get isCowoker(): boolean {
		return this._isCowoker; 
	}
	public get isMale(): boolean {
		return this._isMale; 
	}
	public get diploma_start():  string {
		return this._diploma_start; 
	}
	public get diploma_startDate(): Date {
		return this._diploma_startDate; 
	}
	public get organization() :number {
		return this._organization; 
	}
	public get appointment() :number {
		return this._appointment; 
	}
	public get region() :any {
		return this._region; 
	}
	public get tel_number() :string {
		return this._tel_number; 
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
	public get insurance_number() :string {
		return this._insurance_number; 
	}
	public get department() :number {
		return this._department; 
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
	public get speciality_retraining() :number {
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
	public get belmapo_faculty() :number {
		return this._belmapo_faculty; 
	}
	public get belmapo_cathedra() :number {
		return this._belmapo_cathedra; 
	}
	public get belmapo_course() :number {
		return this._belmapo_course; 
	}
	public get belmapo_educType() :number {
		return this._belmapo_educType; 
	}
	public get belmapo_residense() :number {
		return this._belmapo_residense; 
	}
	public get belmapo_educForm() :number {
		return this._belmapo_educForm; 
	}
	public get belmapo_paymentData() :number {
		return this._belmapo_paymentData; 
	}
	public get belmapo_docNumber() :string {
		return this._belmapo_docNumber; 
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

	public get city() : any {
		return this._city;
	}
	public set city(v : any) {
		this._city = v;
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

	public get addCategoryDate() : Date {
		return this._addCategoryDate;
	}
	public set addCategoryDate(v : Date) {
		this._addCategoryDate = v;
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

	public set id(v: number){
		this._id = v; 
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
	public set birthdayDate(v: Date){
		this._birthdayDate = v; 
	}
	public set nameInDativeForm(v: string) {
		this._nameInDativeForm = v; 
	}
	public set educational_establishment(v: number) {
		this._educational_establishment = v; 
	}
	public set cityzenship(v: number) {
		this._cityzenship = v; 
	}
	public set isDoctor(v: boolean){
		this._isDoctor = v; 
	}
	public set isCowoker(v: boolean){
		this._isCowoker = v; 
	}
	public set isMale(v: boolean){
		this._isMale = v; 
	}
	public set diploma_start(v: string){
		this._diploma_start = v; 
	}
	public set diploma_startDate(v: Date){
		this._diploma_startDate = v; 
	}
	public set organization(v: number) {
		this._organization = v; 
	}
	public set appointment(v: number) {
		this._appointment = v; 
	}
	public set region(v: any) {
		this._region = v; 
	}
	public set tel_number(v: string) {
		this._tel_number = v; 
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
	public set insurance_number(v: string) {
		this._insurance_number = v; 
	}
	public set department(v: number) {
		this._department = v; 
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
	public set speciality_retraining(v: number) {
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
	public set belmapo_faculty(v: number) {
		this._belmapo_faculty = v; 
	}
	public set belmapo_cathedra(v: number) {
		this._belmapo_cathedra = v; 
	}
	public set belmapo_course(v: number) {
		this._belmapo_course = v; 
	}
	public set belmapo_educType(v: number) {
		this._belmapo_educType = v; 
	}
	public set belmapo_residense(v: number) {
		this._belmapo_residense = v; 
	}
	public set belmapo_educForm(v: number) {
		this._belmapo_educForm = v; 
	}
	public set belmapo_paymentData(v: number) {
		this._belmapo_paymentData = v; 
	}
	public set mainCategory(v : number) {
		this._mainCategory = v;
	}
	public set belmapo_docNumber(v: string) {
		this._belmapo_docNumber = v; 
	}
	public set addCategory(v : number) {
		this._addCategory = v;
	}
	
}