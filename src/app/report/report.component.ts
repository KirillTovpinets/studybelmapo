import { Component , OnInit} from "@angular/core";
import { PersonalDataService } from "../personalInfo/personalData.service";
import { BuildReportService } from "./buildReport.service";
import { Person } from "../model/person.class";

@Component({
	templateUrl: './report.component.html',
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
  private years:any[] = [];
	private selectedCourse:any;
	private faculties: any[] = [];
	private cathedras: any[] = [];
	private educTypes: any[] = [];
	private educForms: any[] = [];
	private residance: any[] = [];

	private isLoaded:boolean = false;
  private getResult:boolean = true;
	private parameters:any[] = [];

  private PROFESIONAL: string = "personal_prof_info";
  private PERSONAL: string = "personal_private_info";
  private GENERAL: string = "personal_card";
  private SCIENCE: string = "personal_sience";
  private ARRIVAL: string = "arrivals";
  private ARRIVAL_ZIP: string = "arrivals_zip";
  private COURSE: string = "cources";


	// private filterParams: Person = new Person();

    private params:any = {};
    private total: number = 0;
    private filterParams:any = {
    	establishmentId: "",
  		cityzenship: "",
  		DipDateFrom: 0,
  		DipDateTo: 0,
  		appointment: "",
  		isDoctor: "",
  		organization: "",
  		gender: "",
  		isCowoker: "",
  		experiance: "",
  		department: "",
  		facultyId: "",
  		cathedra: "",
  		course: "",
  		groupNumber: 0
    };

    private fieldAndArray:any = {
      region: this.personal_regions,
      FormEduc: this.educForms,
      Type: this.educTypes,
      years: this.years
    };
    private ParamLabels:any = ["Учреждение образования", "Гражданство", "Дата получения диплома", "Должность", "Звание кандидата медицинских нук", "Организация", "Область", "Пол", "Сотрудник", "Опыт работы", "Отдел", "Факультет", "Факультет БелМАПО", "Кафедра БелМАПО", "Курс", "Форма обучения", "Номер группы", "Тип обучения"];
    private LabelsToDisplay:any = {};
	constructor(private dataService: PersonalDataService,
				      private buildReport: BuildReportService){
    this.filterParams.region = [];
    this.filterParams.faculties = [];
    this.filterParams.FormEduc = [];
    this.filterParams.Type = [];
    this.filterParams.tableIds = [];
    this.filterParams.years = [];
  }
	ngOnInit():void{
    let today = new Date();
    let year = today.getFullYear();
    for(let i = 2007; i <= year; i ++){
      this.years.push({
        id: i,
        value: i
      });
    }
		this.dataService.getData().then(data => {
      let response = data.json();
      
      response.facBel.forEach((element, index, arr) => this.faculties.push(element));
      response.educTypeBel.forEach((element, index, arr) => this.educTypes.push(element));
      response.formBel.forEach((element, index, arr) => this.educForms.push(element));
      response.belmapo_residence.forEach((element, index, arr) => this.residance.push(element));
      response.facArr.forEach((element, index, arr) => this.personal_faculties.push(element));
      response.residArr.forEach((element, index, arr) => this.personal_cityzenships.push(element));
      response.appArr.forEach((element, index, arr) => this.personal_appointments.push(element));
      response.orgArr.forEach((element, index, arr) => this.personal_organizations.push(element));
      response.regArr.forEach((element, index, arr) => this.personal_regions.push(element));
      response.depArr.forEach((element, index, arr) => this.personal_departments.push(element));
      response.estArr.forEach((element, index, arr) => this.personal_establishments.push(element));
      response.residArr.forEach((element, index, arr) => this.personal_cityzenships.push(element));
      response.coursesBel.forEach((element, index, arr) => this.belmapo_courses.push(element));

			this.isLoaded = true;
		});
	}

	SelectRegionAction(region:any):void {
    if (this.filterParams.region.indexOf(region.id) < 0) {
      this.filterParams.region.push(region.id);
    }else{
      this.filterParams.region.splice(this.filterParams.region.indexOf(region.id), 1);
    }
    return this.reportAction(this.PERSONAL);
  };
  SelectYear(year){
    if (this.filterParams.years.indexOf(year.id) < 0) {
      this.filterParams.years.push(year.id);
    }else{
      this.filterParams.years.splice(this.filterParams.years.indexOf(year.id), 1);
    }
    return this.reportAction(this.ARRIVAL_ZIP);
  }
  reportAction(table:string): void {
    if (this.filterParams.tableIds.indexOf(table) < 0) {
      this.filterParams.tableIds.push(table);
    }
    this.buildReport.build(this.filterParams).then(data => {
      console.log(data);
      var i, len, ref, value;
      try{
        console.log(data.json());
        ref = data.json();
        this.parameters = [];
        for (i = 0, len = ref.length; i < len; i++) {
          value = ref[i];
          if (value.label !== "total" && value.label !== undefined) {
            for (var key in this.filterParams) {
              if (key === value.label) {
                value.label = this.filterParams[key];
                break;
              }else{
                var str = value.label + '';
                var index = str.split("-")[1];
                if (index == undefined) {
                  continue;
                }
                var field = str.split("-")[0];
                var indexNumber = Number(index);
                var flag = false;
                for(let obj of this.fieldAndArray[field]){
                  if(obj.id == indexNumber){
                    value.label = obj.value;
                    flag = true;
                    break;
                  }
                }
                if (!flag) {
                  switch (field) {
                    case "region":
                      value.label = "Всего по регионам"
                      break;
                    case "FormEduc":
                      value.label = "Всего по форме обучения"
                      break;
                    case "Type":
                      value.label = "Всего по типам обучения"
                      break;
                    case "years":
                      value.label = "Всего по годам"
                      break;
                  }
                }
                break;
              }
            }
            this.parameters.push(value);
          } else {
            this.total = value.value;
          }
        }
        if (this.parameters.length === 1) {
          this.total = this.parameters[0].value;
        }
      }catch(e){
        this.parameters = [];
        this.total = 0;
        // console.log(data._body);
      }
      this.getResult = true;
    });
  };
  ResetService():void{
    this.filterParams.establishmentId = "",
    this.filterParams.cityzenship = "",
    this.filterParams.DipDateFrom = 0,
    this.filterParams.DipDateTo = 0,
    this.filterParams.appointment = "",
    this.filterParams.isDoctor = "",
    this.filterParams.organization = "",
    this.filterParams.gender = "",
    this.filterParams.isCowoker = "",
    this.filterParams.experiance = "",
    this.filterParams.department = "",
    this.filterParams.facultyId = "",
    this.filterParams.cathedra = "",
    this.filterParams.course = "",
    this.filterParams.groupNumber = 0
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
    // return this.reportAction(2);
  };
  SelectFormAction(form:any): void {
    if (this.filterParams.FormEduc.indexOf(form.id) < 0) {
      this.filterParams.FormEduc.push(form.id);
    }else{
      var index = this.filterParams.FormEduc.indexOf(form.id);
      this.filterParams.FormEduc.splice(index, 1);
    }
    this.LabelsToDisplay = this.ParamLabels[14];
    return this.reportAction(this.ARRIVAL);
  };
  SelectEducTypeAction(type:any): void {
    if (this.filterParams.Type === undefined) {
      this.filterParams.Type = [];
    }
    if (this.filterParams.Type.indexOf(type.id) < 0) {
      this.filterParams.Type.push(type.id);
    }else{
      var index = this.filterParams.Type.indexOf(type.id);
      this.filterParams.Type.splice(index, 1);
    }
    
    this.LabelsToDisplay = this.ParamLabels[16];
    return this.reportAction(this.COURSE);
  };
}