import { GeneralInfo } from './generalInfo.class';
import { ProfesionalInfo } from './profesionInfo.class';
import { PrivateInfo } from './privateInfo.class';
import { SienceInfo } from './sienceInfo.class';

export class Person{
	public general: GeneralInfo;
	public profesional: ProfesionalInfo;
	public personal: PrivateInfo;
	public sience: SienceInfo;
	private _isCowoker:boolean;
	
	private _id: number;
	private _belmapo_faculty:number;
	private _belmapo_cathedra:number;
	private _belmapo_course:number;
	private _belmapo_educType:number;
	private _belmapo_residense:number;
	private _belmapo_educForm:number;
	private _belmapo_paymentData:number;
	
	private _belmapo_docNumber:string;

	public get id():  number {
		return this._id; 
	}
	public get isCowoker(): boolean {
		return this._isCowoker; 
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
	public set isCowoker(v: boolean){
		this._isCowoker = v; 
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
	
	constructor(){
		this.general = new GeneralInfo();
		this.profesional = new ProfesionalInfo();
		this.personal = new PrivateInfo();
		this.sience = new SienceInfo();
		// this._belmapo_docNumber = "test";

		// this._id = 1;
		// this._belmapo_faculty = 1;
		// this._belmapo_cathedra = 1;
		// this._belmapo_course = 1;
		// this._belmapo_educType = 1;
		// this._belmapo_residense = 1;
		// this._belmapo_educForm = 1;
		// this._belmapo_paymentData = 1;
	}
}