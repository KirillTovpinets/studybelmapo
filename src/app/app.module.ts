// Modules
import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { HttpModule } from '@angular/http';
import { AppRoutingModule } from './app-routing.module';
import { RouterModule } from '@angular/router';
import { Ng2AutoCompleteModule } from 'ng2-auto-complete';

import { DragDropDirectiveModule} from "angular4-drag-drop";

import { AccordionModule, ModalModule, TabsModule, BsDatepickerModule, TooltipModule, BsDropdownModule } from 'ngx-bootstrap';
// Components
import { AppComponent } from './app.component';
import { LoginComponent } from './loginform/loginform.component';
import { MainComponent } from './main/main.component';
import { MenuComponent } from './menu/menu.component';
import { NavbarComponent } from './navbar/navbar.component';
import { StudListComponent } from './studList/studList.component';
import { FillDataComponent } from './fillData/fillData.component';
import { TableListCopmonent } from './tableList/tableList.component';
import { PersonalInfoComponent } from './personalInfo/personalInfo.component';
import { GeneralInfoComponent } from './personalInfo/generalInfo/generalInfo.component';
import { ProfInfoComponent } from './personalInfo/prof/profInfo.component';
import { PrivateInfoComponent } from './personalInfo/private/privateInfo.component';
import { HistoryInfoComponent } from './personalInfo/historyInfo/historyInfo.component';
import { OtherInfoComponent } from './personalInfo/otherInfo/otherInfo.component';
import { PostDiplomaInfoComponent } from './personalInfo/postDiploma/postDiploma.component';
import { ArrivalsInfoComponent } from './personalInfo/arrivals/arrivals.component';
import { SearchStudentComponent } from './registry/searchStudent.component';
import { AddStudentComponent } from './addStudent/addStudent.component';
import { ReportComponent } from './report/report.component';
import { OrderComponent } from './order/order.component';
import { SirnameComponent } from './registry/sirname/sirname.component';
import { GenderComponent } from './registry/gender/gender.component';
import { AgeComponent } from './registry/age/age.component';
import { EstablishmentComponent } from './registry/establishment/establishment.component';
import { OrganizationComponent } from './registry/organization/organization.component';
import { AppointmentComponent } from './registry/appointment/appointment.component';
import { SpecialityComponent } from './registry/speciality/speciality.component';
import { QualificationComponent } from './registry/qualification/qualification.component';
import { CategoryComponent } from './registry/category/category.component';
import { ChooseCourseComponent } from './FillData/chooseCourse.component';
import { ChooseStudentComponent } from './FillData/chooseStudent.component';
import { PreloaderComponent } from './preloader/preloader.component';
import { BrowserAnimationsModule } from "@angular/platform-browser/animations";
import { NotificationsModule, NotificationsService } from 'angular4-notify';
import { AuthGuard } from "./auth.guard";
import { LoginService } from './loginform/login.service';
import { CurrentCourcesListService } from './FillData/services/getCurrentCourcesList.service';
import { ShowPersonInfoService } from './personalInfo/showPersonalInfo.service';
import { ShareService } from './share/share.service';
// Services
import { CookieService } from 'ngx-cookie-service';
import { GlobalParamsService } from './Globalparams.service';
import { CheckAuthService } from './checkAuth.service';
import { ForMenuDirective } from './directives/for-menu.directive';
import { MobilemenuComponent } from './mobilemenu/mobilemenu.component';
import { StudListService } from './studList/stud-list.service';
import { AdminComponent } from './admin/admin.component';
import { HelpComponent } from './help/help.component';
import { TableContentComponent } from './table-content/table-content.component';
import { PaginationComponent } from './pagination/pagination.component';
import { defineLocale } from 'ngx-bootstrap/chronos';
import { ruLocale } from 'ngx-bootstrap/locale';
import { ArchiveComponent } from './archive/archive.component';
import { TableCertificatesComponent } from './table-certificates/table-certificates.component';

defineLocale('ru', ruLocale);

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
    ChooseStudentComponent,
    ForMenuDirective,
    MobilemenuComponent,
    AdminComponent,
    HelpComponent,
    TableContentComponent,
    PaginationComponent,
    ArchiveComponent,
    TableCertificatesComponent
  ],
  imports: [
    BrowserModule,
    FormsModule,
    HttpModule,
    DragDropDirectiveModule,
	  AppRoutingModule,
    AccordionModule.forRoot(),
    ModalModule.forRoot(),
    TabsModule.forRoot(),
    BsDatepickerModule.forRoot(),
    TooltipModule.forRoot(),
    BrowserAnimationsModule,
    NotificationsModule,
    Ng2AutoCompleteModule,
    BsDropdownModule.forRoot()
  ],
  providers: [ CookieService, 
               NotificationsService, 
               AuthGuard, 
               LoginService, 
               CurrentCourcesListService, 
               GlobalParamsService,
               CheckAuthService,
               ShowPersonInfoService,
               ShareService,
               StudListService],
  entryComponents: [PersonalInfoComponent],
  bootstrap: [AppComponent]
})
export class AppModule { }
