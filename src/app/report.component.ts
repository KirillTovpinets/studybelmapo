import { Component , OnInit} from "@angular/core";
import { PersonalDataService } from "./services/personalData.service";
import { BuildReportService } from "./services/buildReport.service";
import { Person } from "./model/person.class";

@Component({
	templateUrl: 'templates/report.component.html',
	providers: [PersonalDataService, BuildReportService]
})

export class ReportComponent implements OnInit{

	private personal_faculties: any[] = [];
	private personal_cityzenships: any[] = [];
	private personal_appointments: any[] = [];
	private personal_organizations: any[] = [];
	private personal_regions: any[] = [];
	private personal_departments: any[] = [];
	private personal_establishments: any[] = [];
	private belmapo_courses:any[] = [];

	private selectedCourse:any;
	private faculties: any[] = [];
	private cathedras: any[] = [];
	private educTypes: any[] = [];
	private educForms: any[] = [];
	private residance: any[] = [];

	private isLoaded:boolean = false;
	private parameters:any[] = [];
	// private filterParams: Person = new Person();

    private params:any = {};
    private total: number = 0;
    private filterParams:any = {
    	est: 0,
  		resid: 0,
  		DipDateFrom: 0,
  		DipDateTo: 0,
  		app: 0,
  		isDoctor: 0,
  		org: 0,
  		gender: 0,
  		isCowoker: 0,
  		experiance: 0,
  		dep: 0,
  		fac: 0,
  		cathedra: 0,
  		course: 0,
  		groupNumber: 0,
      regions: []
    };
    private ParamLabels:any = ["Учреждение образования", "Гражданство", "Дата получения диплома", "Должность", "Звание кандидата медицинских нук", "Организация", "Область", "Пол", "Сотрудник", "Опыт работы", "Отдел", "Факультет", "Факультет БелМАПО", "Кафедра БелМАПО", "Курс", "Форма обучения", "Номер группы", "Тип обучения"];
    private LabelsToDisplay:any = [];
	constructor(private dataService: PersonalDataService,
				private buildReport: BuildReportService){}
	ngOnInit():void{
		this.dataService.getData().then(data => {
			for (let faculty of data.json().facBel) {
				this.faculties.push(faculty);
			}
			for (let type of data.json().educTypeBel) {
				this.educTypes.push(type);
			}
			for (let form of data.json().formBel) {
				this.educForms.push(form);
			}
			for (let resid of data.json().belmapo_residence) {
				this.residance.push(resid);
			}
			for (var faculty of data.json().facArr) {
				this.personal_faculties.push(faculty);
			}
			for (var citizenship of data.json().residArr) {
				this.personal_cityzenships.push(citizenship);
			}
			for (var appointment of data.json().appArr) {
				this.personal_appointments.push(appointment);
			}
			for (var organization of data.json().orgArr) {
				this.personal_organizations.push(organization);
			}
			for (var region of data.json().regArr) {
				this.personal_regions.push(region);
			}
			for (var department of data.json().depArr) {
				this.personal_departments.push(department);
			}
			for (var establishment of data.json().estArr) {
				this.personal_establishments.push(establishment);
			}
			for (var citizenship of data.json().residArr) {
				this.personal_cityzenships.push(citizenship);
			}
			for (var course of data.json().coursesBel) {
				this.belmapo_courses.push(course);
			}
			this.isLoaded = true;
		});
	}

	SelectRegionAction($event:any):void {
  // console.log("SelectRegionAction");
      if (this.filterParams.regions === undefined || this.filterParams.regions.length === 0) {
        this.filterParams.regions = [];
      }
      var value = $event.currentTarget.value * 1;
      if (this.filterParams.regions.indexOf(value) == -1) {
        this.filterParams.regions.push(value);
      }else{
        var index = this.filterParams.regions.indexOf(value);
        this.filterParams.regions.splice(index, 1);
      }
    this.LabelsToDisplay = this.ParamLabels[5];
    return this.reportAction(1);
  };
  reportAction(flag?:number): void {
    // console.log("reportAction");
    this.parameters = [];
    var data, index;
    if (this.filterParams.est === void 0 && this.filterParams.resid === void 0 && this.filterParams.DipDateFrom === void 0 && this.filterParams.DipDateTo === void 0 && this.filterParams.app === void 0 && this.filterParams.isDoctor === void 0 && this.filterParams.org === void 0 && this.filterParams.gender === void 0 && this.filterParams.isCowoker === void 0 && this.filterParams.experiance === void 0 && this.filterParams.dep === void 0 && this.filterParams.fac === void 0) {
      index = this.filterParams.tableIds.indexOf(1);
      if (index > -1) {
        this.filterParams.tableIds.splice(index, 1);
        flag = 0;
      }
    }
    if (this.filterParams.cathedra === void 0 && this.filterParams.course === void 0 && this.filterParams.groupNumber === void 0 && (this.filterParams.regions === void 0 || this.filterParams.regions.length === 0) && (this.filterParams.faculties === void 0 || this.filterParams.faculties.length === 0) && (this.filterParams.forms === void 0 || this.filterParams.forms.length === 0) && (this.filterParams.educTypes === void 0 || this.filterParams.educTypes.length === 0)) {
      index = this.filterParams.tableIds.indexOf(2);
      if (index > -1) {
        this.filterParams.tableIds.splice(index, 1);
        flag = 0;
      }
    }
    if (flag) {
      if(this.filterParams.tableIds === undefined){
        this.filterParams.tableIds = [];
      }

      var value = flag * 1;
      if (this.filterParams.tableIds.indexOf(value) == -1) {
        this.filterParams.tableIds.push(value);
      }
    }
    data = this.filterParams;
    console.log(data);
    this.buildReport.build(data).then(data => {
      console.log(data._body);
      var i, len, ref, value;
      ref = data.json();
      this.parameters = [];
      for (i = 0, len = ref.length; i < len; i++) {
        value = ref[i];
        if (value.label !== "total") {
          this.parameters.push(value);
        } else {
          this.total = value.value;
        }
      }
      if (this.parameters.length === 1) {
        this.total = this.parameters[0].value;
      }
    });
  };
  ResetService():void{
    this.filterParams.est = undefined;
    this.filterParams.resid = undefined;
    this.filterParams.dipdatefrom = undefined;
    this.filterParams.dipdateto = undefined;
    this.filterParams.app = undefined;
    this.filterParams.isDoctor = undefined;
    this.filterParams.org = undefined;
    this.filterParams.isMale = undefined;
    this.filterParams.isCowoker = undefined;
    this.filterParams.experiance_general = undefined;
    this.filterParams.dep = undefined;
    this.filterParams.fac = undefined;
    this.filterParams.cathedra = undefined;
    this.filterParams.course = undefined;
    this.parameters = [];
    this.total = 0;
  }
  SelectFacultyAction($event:any): void {
    if (this.filterParams.faculties === void 0) {
      this.filterParams.faculties = [];
    }
    var value = $event.currentTarget.value * 1;
      if (this.filterParams.faculties.indexOf(value) == -1) {
        this.filterParams.faculties.push(value);
      }else{
        var index = this.filterParams.faculties.indexOf(value);
        this.filterParams.faculties.splice(index, 1);
      }
    this.LabelsToDisplay = this.ParamLabels[11];
    return this.reportAction(2);
  };
  SelectFormAction($event:any): void {
    if (this.filterParams.forms === void 0) {
      this.filterParams.forms = [];
    }
    var value = $event.currentTarget.value * 1;
    if (this.filterParams.forms.indexOf(value) == -1) {
      this.filterParams.forms.push(value);
    }else{
      var index = this.filterParams.forms.indexOf(value);
      this.filterParams.forms.splice(index, 1);
    }
    this.LabelsToDisplay = this.ParamLabels[14];
    return this.reportAction(2);
  };
  SelectEducTypeAction($event:any): void {
    if (this.filterParams.educTypes === void 0) {
      this.filterParams.educTypes = [];
    }
    var value = $event.currentTarget.value * 1;
    if (this.filterParams.educTypes.indexOf(value) == -1) {
      this.filterParams.educTypes.push(value);
    }else{
      var index = this.filterParams.educTypes.indexOf(value);
      this.filterParams.educTypes.splice(index, 1);
    }
    
    this.LabelsToDisplay = this.ParamLabels[16];
    return this.reportAction(2);
  };
  checkValue(value:any, array:any[], flag?): any[] {
    console.log("array = " + array.length);
    var contain, i, len, valueArr, valueToRemove;
    contain = false;
    for (i = 0, len = array.length; i < len; i++) {
      valueArr = array[i];
      if (valueArr === value) {
        contain = true;
      }
    }
    if (!contain) {
      array.push(value);
    } else {
      if (flag !== 1) {
        valueToRemove = array.indexOf(value);
        if (valueToRemove > -1) {
          array.splice(valueToRemove, 1);
        }
      }
    }
    return array;
  };
}