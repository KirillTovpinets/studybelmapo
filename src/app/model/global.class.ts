import { BsDatepickerConfig } from "ngx-bootstrap/datepicker";
export class Global {
	_bsConfig: Partial<BsDatepickerConfig>;
	_locale:string;
	_bsValue: Date;
	_minDate: Date;
  	_maxDate: Date;
  	private _maxDateCourse : Date;
  	private _maxCourse : Date;
  	private _tablesLabel: Map<string, string>; 
	constructor(){
		this.locale = "ru";
		this.bsConfig = Object.assign({}, { containerClass: "theme-blue", locale: this.locale, dateInputFormat: 'DD.MM.YYYY' });
		this._bsValue= new Date();
		this._minDate= new Date(1900, 1, 1);
		this._maxDate= new Date();
		this._maxCourse = new Date();
		this._maxCourse.setFullYear(this._maxCourse.getFullYear() + 1);

		this._tablesLabel = new Map<string, string>();
		this._tablesLabel.set("arrivals", "Приезды");
	    this._tablesLabel.set("arrivals_zip", "Приезды (архив)");
	    this._tablesLabel.set("belmapo_departments", "Отделы БелМАПО");
	    this._tablesLabel.set("cathedras", "Кафедры");
	    this._tablesLabel.set("certificates", "Свидетельства");
	    this._tablesLabel.set("cities", "Города");
	    this._tablesLabel.set("bel_city_type", "Виды городов");
	    this._tablesLabel.set("bel_districts", "Районы Беларуси");
	    this._tablesLabel.set("bel_sovets", "Местные советы");
	    this._tablesLabel.set("cities_backup", "Города (архив)");
	    this._tablesLabel.set("countries", "Страны");
	    this._tablesLabel.set("cources", "Сводный план");
	    this._tablesLabel.set("cources_zip", "Сводных план (архив)");
	    this._tablesLabel.set("department", "Отделы (ЛКС)");
	    this._tablesLabel.set("district", "Области");
	    this._tablesLabel.set("eductype", "Типы обучения");
	    this._tablesLabel.set("faculties", "Факультеты БелМАПО");
	    this._tablesLabel.set("formofeducation", "Формы обучений");
	    this._tablesLabel.set("history_of_changes", "История изменений");
	    this._tablesLabel.set("loginusers", "Авторизованные пользователи");
	    this._tablesLabel.set("marks", "Оценки");
	    this._tablesLabel.set("minsk_region", "Районы Минска");
	    this._tablesLabel.set("organization_forms", "Формы организаций");
	    this._tablesLabel.set("personal_appointment", "Должности");
	    this._tablesLabel.set("personal_card", "Личные данные слушателей");
	    this._tablesLabel.set("personal_department", "Отделы (ЛКС)");
	    this._tablesLabel.set("personal_establishment", "Учебные заведения");
	    this._tablesLabel.set("personal_faculty", "Факультеты");
	    this._tablesLabel.set("personal_organizations", "Организации");
	    this._tablesLabel.set("personal_organizations_new_backup", "Организации (архив)");
	    this._tablesLabel.set("personal_organizations_new_backup_2", "Организации (архив 2)");
	    this._tablesLabel.set("personal_private_info", "Персональные данные");
	    this._tablesLabel.set("personal_prof_info", "Профессиональные данные");
	    this._tablesLabel.set("personal_retrainings", "Переподготовки");
	    this._tablesLabel.set("personal_sience", "Научная деятельность");
	    this._tablesLabel.set("qual_spec_id", "Квал. спец-ти");
	    this._tablesLabel.set("qualification_add", "Доп. квалификации");
	    this._tablesLabel.set("qualification_main", "Осн. квалификации");
	    this._tablesLabel.set("qualification_other", "Прочие квалификации");
	    this._tablesLabel.set("regions", "Области");
	    this._tablesLabel.set("residence", "Место жительства");
	    this._tablesLabel.set("speciality_doct", "Врачебная специальность");
	    this._tablesLabel.set("speciality_other", "Прочие специальности");
	    this._tablesLabel.set("speciality_retraining", "Специальности по переподготовке");
	    this._tablesLabel.set("status", "Статус");
	    this._tablesLabel.set("table 39", "table 39");
	    this._tablesLabel.set("table 43", "table 43");
	    this._tablesLabel.set("users", "Пользователи");
	}

	public get tablesLabel() : Map<string,string> {
		return this._tablesLabel;
	}
	public set tablesLabel(v : Map<string,string>) {
		this._tablesLabel = v;
	}
	public get maxDateCourse() : Date {
  		return this._maxDateCourse;
  	}
  	public set maxDateCourse(v : Date) {
  		this._maxDateCourse = v;
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