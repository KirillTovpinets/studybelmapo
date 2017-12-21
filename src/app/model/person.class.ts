export class Person{
	private _id: number;
	private _surname:string;
	private _name: string;
	private _patername:string;
	private _birthday:string;
	private _birthdayDate: Date;
	private _nameInDativeForm:string;
	private _educational_establishment:number;
	private _cityzenship:number;
	private _isDoctor:boolean;
	private _isCowoker:boolean;
	private _isMale:boolean;
	private _diploma_start: string;
	private _diploma_startDate: Date;
	private _organization:number;
	private _appointment:number;
	private _region:number;
	private _tel_number:string;
	private _experiance_general:number;
	private _experiance_special:number;
	private _experiance_last:number;
	private _insurance_number:string;
	private _department:number;
	private _faculty:number;
	private _speciality_doc:number;
	private _speciality_other:number;
	private _speciality_retraining:number;
	private _qualification_main:number;
	private _qualification_add:number;
	private _qualification_other:number;
	private _diploma_number:string;
	private _belmapo_faculty:number;
	private _belmapo_cathedra:number;
	private _belmapo_course:number;
	private _belmapo_educType:number;
	private _belmapo_residense:number;
	private _belmapo_educForm:number;
	private _belmapo_paymentData:number;
	private _belmapo_docNumber:string;

	constructor(){
		// this.educational_establishment = 1;
		// this.cityzenship = 1;
		// this.isDoctor = true;
		// this.isCowoker = true;
		// this.isMale = true;
		// this.organization = 5333;
		// this.appointment = 1;
		// this.region = 1;
		// this.experiance_general = 1;
		// this.experiance_special = 1;
		// this.experiance_last = 1;
		// this.department = 1;
		// this.faculty = 1;
		// this.belmapo_faculty = 1;
		// this.belmapo_cathedra = 1;
		// this.belmapo_course = 1;
		// this.belmapo_educType = 1;
		// this.belmapo_residense = 1;
		// this.belmapo_educForm = 1;
		// this.belmapo_paymentData = 1;
		// this.speciality_doc = 1;
		// this.speciality_other = 1;
		// this.speciality_retraining = 1;
		// this.qualification_main = 1;
		// this.qualification_add = 1;
		// this.qualification_other = 1;

		// this.surname = "Товпинец";
		// this.name = "Кирилл";
		// this.patername = "Александрович";
		// this.nameInDativeForm = "Товпинцу Кириллу Александровичу";
		// this.tel_number = "+375 29 853 75 96";
		// this.insurance_number = "1234556";
		// this.diploma_number = "654321";
		// this.belmapo_docNumber = "1234556";
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
	public get region() :number {
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
	public set region(v: number) {
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
	public set belmapo_docNumber(v: string) {
		this._belmapo_docNumber = v; 
	}

}