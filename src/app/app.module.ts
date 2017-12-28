// Modules
import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { HttpModule } from '@angular/http';
import { AppRoutingModule } from './app-routing.module';
import { RouterModule } from '@angular/router';
import { Ng2AutoCompleteModule } from 'ng2-auto-complete';
import { AccordionModule, ModalModule, TabsModule, BsDatepickerModule, TooltipModule } from 'ngx-bootstrap';
// Components
import { AppComponent } from './app.component';
import { LoginComponent } from './loginform.component';
import { MainComponent } from './main.component';
import { MenuComponent } from './menu.component';
import { NavbarComponent } from './navbar.component';
import { StudListComponent } from './studList.component';
import { FillDataComponent } from './fillData.component';
import { TableListCopmonent } from './tableList.component';
import { PersonalInfoComponent } from './personalInfo.component';
import { GeneralInfoComponent } from './personalInfo/generalInfo.component';
import { ProfInfoComponent } from './personalInfo/profInfo.component';
import { PrivateInfoComponent } from './personalInfo/privateInfo.component';
import { HistoryInfoComponent } from './personalInfo/historyInfo.component';
import { OtherInfoComponent } from './personalInfo/otherInfo.component';
import { PostDiplomaInfoComponent } from './personalInfo/postDiploma.component';
import { ArrivalsInfoComponent } from './personalInfo/arrivals.component';
import { SearchStudentComponent } from './searchStudent.component';
import { AddStudentComponent } from './addStudent.component';
import { ReportComponent } from './report.component';
import { OrderComponent } from './order.component';
import { SirnameComponent } from './searchComponents/sirname.component';
import { GenderComponent } from './searchComponents/gender.component';
import { AgeComponent } from './searchComponents/age.component';
import { EstablishmentComponent } from './searchComponents/establishment.component';
import { OrganizationComponent } from './searchComponents/organization.component';
import { AppointmentComponent } from './searchComponents/appointment.component';
import { SpecialityComponent } from './searchComponents/speciality.component';
import { QualificationComponent } from './searchComponents/qualification.component';
import { CategoryComponent } from './searchComponents/category.component';
import { ChooseCourseComponent } from './FillData/chooseCourse.component';
import { ChooseStudentComponent } from './FillData/chooseStudent.component';
import { PreloaderComponent } from './preloader.component';
import { BrowserAnimationsModule } from "@angular/platform-browser/animations";
import { NotificationsModule, NotificationsService } from 'angular4-notify';
import { AuthGuard } from "./auth.guard";
import { LoginService } from './login.service';
import { CurrentCourcesListService } from './FillData/services/getCurrentCourcesList.service';
import { ShowPersonInfoService } from './personalInfo/showPersonalInfo.service';
// Services
import { CookieService } from 'ngx-cookie-service';
import { GlobalParamsService } from './Globalparams.service';
import { CheckAuthService } from './services/checkAuth.service';

import { defineLocale } from 'ngx-bootstrap/bs-moment';
import { ru } from 'ngx-bootstrap/locale';
defineLocale('ru', ru); 

@NgModule({
  declarations: [
    AppComponent,
    LoginComponent,
    MainComponent,
    MenuComponent,
    NavbarComponent,
    StudListComponent,
    TableListCopmonent,
    PersonalInfoComponent,
    GeneralInfoComponent,
    ProfInfoComponent,
    PrivateInfoComponent,
    HistoryInfoComponent,
    OtherInfoComponent,
    PostDiplomaInfoComponent,
    ArrivalsInfoComponent,
    SearchStudentComponent,
    AddStudentComponent,
    ReportComponent,
    SirnameComponent,
    GenderComponent,
    AgeComponent,
    EstablishmentComponent,
    OrganizationComponent,
    AppointmentComponent,
    SpecialityComponent,
    QualificationComponent,
    CategoryComponent,
    PreloaderComponent,
    OrderComponent,
    FillDataComponent,
    ChooseCourseComponent,
    ChooseStudentComponent
  ],
  imports: [
    BrowserModule,
    FormsModule,
    HttpModule,
	AppRoutingModule,
    AccordionModule.forRoot(),
    ModalModule.forRoot(),
    TabsModule.forRoot(),
    BsDatepickerModule.forRoot(),
    TooltipModule.forRoot(),
    BrowserAnimationsModule,
    NotificationsModule,
    Ng2AutoCompleteModule
  ],
  providers: [ CookieService, 
               NotificationsService, 
               AuthGuard, 
               LoginService, 
               CurrentCourcesListService, 
               GlobalParamsService,
               CheckAuthService,
               ShowPersonInfoService],
  entryComponents: [PersonalInfoComponent],
  bootstrap: [AppComponent]
})
export class AppModule { }
