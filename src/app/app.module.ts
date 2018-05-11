// Modules
import { BrowserModule } from '@angular/platform-browser';
import { NgModule, enableProdMode } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { HttpModule } from '@angular/http';
import { AppRoutingModule } from './app-routing.module';
import { Ng2AutoCompleteModule } from 'ng2-auto-complete';
import { DragDropDirectiveModule} from "angular4-drag-drop";

import { AccordionModule, 
        ModalModule, 
        TabsModule, 
        BsDatepickerModule, 
        TooltipModule, 
        BsDropdownModule, 
        ProgressbarModule  } from 'ngx-bootstrap';
// Components
import { AppComponent } from './app.component';
import { LoginComponent } from './loginform/loginform.component';
import { MainComponent } from './main/main.component';
import { StudListComponent } from './studList/studList.component';
import { FillDataComponent } from './fillData/fillData.component';
import { TableListCopmonent } from './tableList/tableList.component';

import { SearchStudentComponent } from './registry/searchStudent.component';
import { AddStudentComponent } from './addStudent/addStudent.component';
import { ReportComponent } from './report/report.component';
import { OrderComponent } from './order/order.component';

import { ChooseCourseComponent } from './FillData/chooseCourse.component';
import { ChooseStudentComponent } from './FillData/chooseStudent.component';
import { BrowserAnimationsModule } from "@angular/platform-browser/animations";
import { NotificationsModule, NotificationsService } from 'angular4-notify';
import { AuthGuard } from "./auth.guard";
import { LoginService } from './loginform/login.service';
import { CurrentCourcesListService } from './FillData/services/getCurrentCourcesList.service';
import { ShowPersonInfoService } from './personalInfo/showPersonalInfo.service';
import { ShareService } from './share/share.service';
import { LogService } from './share/log.service';
// Services
import { CookieService } from 'ngx-cookie-service';
import { GlobalParamsService } from './Globalparams.service';
import { CheckAuthService } from './checkAuth.service';
import { ForMenuDirective } from './directives/for-menu.directive';
import { StudListService } from './studList/stud-list.service';
import { AdminComponent } from './admin/admin.component';
import { HelpComponent } from './help/help.component';
import { TableContentComponent } from './table-content/table-content.component';
import { PaginationComponent } from './pagination/pagination.component';
import { defineLocale } from 'ngx-bootstrap/chronos';
import { ruLocale } from 'ngx-bootstrap/locale';
import { ArchiveComponent } from './archive/archive.component';
import { TableCertificatesComponent } from './table-certificates/table-certificates.component';
import { LogComponent } from './log/log.component';
import { StatementsComponent } from './statements/statements.component';
import { TotalListComponent } from './total-list/total-list.component';
import { DepartmentComponent } from './department/department.component';
import { PersonInfoModule } from './person-info/person-info.module';
import { RegistryModule } from './registry/registry.module';
import { MenuModule } from './Menu/menu.module';
import { DropdownModule } from 'ngx-dropdown';

enableProdMode();
defineLocale('ru', ruLocale);

@NgModule({
  declarations: [
    AppComponent,
    LoginComponent,
    MainComponent,
    StudListComponent,
    TableListCopmonent,
    SearchStudentComponent,
    AddStudentComponent,
    ReportComponent,
    OrderComponent,
    FillDataComponent,
    ChooseCourseComponent,
    ChooseStudentComponent,
    ForMenuDirective,
    AdminComponent,
    HelpComponent,
    TableContentComponent,
    PaginationComponent,
    ArchiveComponent,
    TableCertificatesComponent,
    LogComponent,
    StatementsComponent,
    TotalListComponent,
    DepartmentComponent,
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
    ProgressbarModule.forRoot(),
    BsDropdownModule.forRoot(),
    DropdownModule,
    PersonInfoModule,
    RegistryModule,
    MenuModule
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
               StudListService,
               LogService],
  bootstrap: [AppComponent]
})
export class AppModule { }
