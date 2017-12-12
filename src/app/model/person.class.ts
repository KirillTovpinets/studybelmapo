export class Person{
	private surname:string;
	private name: string;
	private patername:string;
	private birthday:string;
	private birthdayDate: Date;
	private nameInDativeForm:string;
	private educational_establishment:number;
	private cityzenship:number;
	private isDoctor:boolean;
	private isCowoker:boolean;
	private isMale:boolean;
	private diploma_start: string;
	private diploma_startDate: Date;
	private organization:number;
	private appointment:number;
	private region:number;
	private tel_number:string;
	private experiance_general:number;
	private experiance_special:number;
	private insurance_number:string;
	private department:number;
	private faculty:number;
	private diploma_number:string;
	private belmapo_faculty:number;
	private belmapo_cathedra:number;
	private belmapo_course:number;
	private belmapo_educType:number;
	private belmapo_residense:number;
	private belmapo_educForm:number;
	private belmapo_paymentData:number;
	private belmapo_docNumber:string;

	constructor(){
		this.educational_establishment = 1;
		this.cityzenship = 1;
		this.isDoctor = true;
		this.isCowoker = true;
		this.isMale = true;
		this.organization = 5333;
		this.appointment = 1;
		this.region = 1;
		this.experiance_general = 1;
		this.experiance_special = 1;
		this.department = 1;
		this.faculty = 1;
		this.belmapo_faculty = 1;
		this.belmapo_cathedra = 1;
		this.belmapo_course = 1;
		this.belmapo_educType = 1;
		this.belmapo_residense = 1;
		this.belmapo_educForm = 1;
		this.belmapo_paymentData = 1;

		this.surname = "Товпинец";
		this.name = "Кирилл";
		this.patername = "Александрович";
		this.nameInDativeForm = "Товпинцу Кириллу Александровичу";
		this.tel_number = "+375 29 853 75 96";
		this.insurance_number = "1234556";
		this.diploma_number = "654321";
		this.belmapo_docNumber = "1234556";
	}

	get_surname():string{
		return this.surname;
	};
	get_name(): string{
		return this.name;
	};
	get_patername():string{
		return this.patername;
	};
	get_birthday():string{
		return this.birthday;
	};
	get_nameInDativeForm():string{
		return this.nameInDativeForm;
	};
	get_educational_establishment():number{
		return this.educational_establishment;
	};
	get_cityzenship():number{
		return this.cityzenship;
	};
	get_isDoctor():boolean{
		return this.isDoctor;
	};
	get_isCowoker():boolean{
		return this.isCowoker;
	};
	get_isMale():boolean{
		return this.isMale;
	};
	get_diploma_start(): string{
		return this.diploma_start;
	};
	get_organization():number{
		return this.organization;
	};
	get_appointment():number{
		return this.appointment;
	};
	get_region():number{
		return this.region;
	};
	get_tel_number():string{
		return this.tel_number;
	};
	get_experiance_general():number{
		return this.experiance_general;
	};
	get_experiance_special():number{
		return this.experiance_special;
	};
	get_insurance_number():string{
		return this.insurance_number;
	};
	get_department():number{
		return this.department;
	};
	get_faculty():number{
		return this.faculty;
	};
	get_diploma_number():string{
		return this.diploma_number;
	};
	get_belmapo_faculty():number{
		return this.belmapo_faculty;
	};
	get_belmapo_cathedra():number{
		return this.belmapo_cathedra;
	};
	get_belmapo_course():number{
		return this.belmapo_course;
	};
	get_belmapo_educType():number{
		return this.belmapo_educType;
	};
	get_belmapo_residense():number{
		return this.belmapo_residense;
	};
	get_belmapo_educForm():number{
		return this.belmapo_educForm;
	};
	get_belmapo_paymentData():number{
		return this.belmapo_paymentData;
	};
	get_belmapo_docNumber():string{
		return this.belmapo_docNumber;
	};

	set_ame(value:string):void{
		this.surname = value;
	};
	set_name(value:string): void{
		this.name = value;
	};
	set_patername(value:string):void{
		this.patername = value;
	};
	set_birthday(value:string):void{
		this.birthday = value;
	};
	set_nameInDativeForm(value:string):void{
		this.nameInDativeForm = value;
	};
	set_educational_establishment(value:number):void{
		this.educational_establishment = value;
	};
	set_cityzenship(value:number):void{
		this.cityzenship = value;
	};
	set_isDoctor(value:boolean):void{
		this.isDoctor = value;
	};
	set_isCowoker(value:boolean):void{
		this.isCowoker = value;
	};
	set_isMale(value:boolean):void{
		this.isMale = value;
	};
	set_diploma_start(value:string): void{
		this.diploma_start = value;
	};
	set_organization(value:number):void{
		this.organization = value;
	};
	set_appointment(value:number):void{
		this.appointment = value;
	};
	set_region(value:number):void{
		this.region = value;
	};
	set_tel_number(value:string):void{
		this.tel_number = value;
	};
	set_experiance_general(value:number):void{
		this.experiance_general = value;
	};
	set_experiance_special(value:number):void{
		this.experiance_special = value;
	};
	set_insurance_number(value:string):void{
		this.insurance_number = value;
	};
	set_department(value:number):void{
		this.department = value;
	};
	set_faculty(value:number):void{
		this.faculty = value;
	};
	set_diploma_number(value:string):void{
		this.diploma_number = value;
	};
	set_belmapo_faculty(value:number):void{
		this.belmapo_faculty = value;
	};
	set_belmapo_cathedra(value:number):void{
		this.belmapo_cathedra = value;
	};
	set_belmapo_course(value:number):void{
		this.belmapo_course = value;
	};
	set_belmapo_educType(value:number):void{
		this.belmapo_educType = value;
	};
	set_belmapo_residense(value:number):void{
		this.belmapo_residense = value;
	};
	set_belmapo_educForm(value:number):void{
		this.belmapo_educForm = value;
	};
	set_belmapo_paymentData(value:number):void{
		this.belmapo_paymentData = value;
	};
	set_belmapo_docNumber(value:string):void{
		this.belmapo_docNumber = value;
	};
}