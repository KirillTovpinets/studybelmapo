import { BsDatepickerConfig } from "ngx-bootstrap/datepicker";
export class Global {
	_bsConfig: Partial<BsDatepickerConfig>;
	_locale:string;
	_bsValue: Date;
	_minDate: Date;
  	_maxDate: Date;
  	private _maxCourse : Date;
	constructor(){
		this.locale = "ru";
		this.bsConfig = Object.assign({}, { containerClass: "theme-blue", locale: this.locale });
		this._bsValue= new Date();
		this._minDate= new Date(1900, 1, 1);
		this._maxDate= new Date();
		this._maxCourse = new Date();
		this._maxCourse.setFullYear(this._maxCourse.getFullYear() + 1);
	}

  	public get maxCourse() : Date {
  		return this._maxCourse;
  	}
  	public set maxCourse(v : Date) {
  		this._maxCourse = v;
  	}

	public get  bsConfig() : Partial<BsDatepickerConfig> {
		return this._bsConfig
	}
	public set bsConfig(v : Partial<BsDatepickerConfig>) {
		this._bsConfig = v;
	}
	public get locale() : string {
		return this._locale
	}
	public set locale(v : string) {
		this._locale = v;
	}
	public get bsValue	() : Date {
				return this._bsValue
			}		
	public set 	bsValue(v : Date) {
		this._bsValue = v;
	}
	
	public get minDate	() : Date {
					return this._minDate
				}			
	public set 	minDate(v : Date) {
			this._minDate = v;
		}	
	
	public get maxDate	() : Date {
					return this._maxDate
				}			
	public set 	maxDate(v : Date) {
			this._maxDate = v;
		}	
	
}