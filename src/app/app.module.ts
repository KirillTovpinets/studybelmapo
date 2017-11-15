// Modules
import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { HttpModule } from '@angular/http';
import { AppRoutingModule } from './app-routing.module';
import { RouterModule } from '@angular/router';
import { AccordionModule, ModalModule, TabsModule } from 'ngx-bootstrap';
// Components
import { AppComponent } from './app.component';
import { LoginComponent } from './loginform.component';
import { MainComponent } from './main.component';
import { MenuComponent } from './menu.component';
import { NavbarComponent } from './navbar.component';
import { StudListComponent } from './studList.component';
import { TableListCopmonent } from './tableList.component';
import { PersonalInfoComponent } from './personalInfo.component';
import { GeneralInfoComponent } from './generalInfo.component';
import { ProfInfoComponent } from './profInfo.component';
import { PrivateInfoComponent } from './privateInfo.component';
import { HistoryInfoComponent } from './historyInfo.component';
import { OtherInfoComponent } from './otherInfo.component';
import { PostDiplomaInfoComponent } from './postDiploma.component';
import { ArrivalsInfoComponent } from './arrivals.component';
import { SearchStudentComponent } from './searchStudent.component';
import { AddStudentComponent } from './addStudent.component';
import { ReportComponent } from './report.component';
import { SirnameComponent } from './searchComponents/sirname.component';
// Services
import { CookieService } from 'ngx-cookie-service';

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
    SirnameComponent
  ],
  imports: [
    BrowserModule,
    FormsModule,
    HttpModule,
	  AppRoutingModule,
    AccordionModule.forRoot(),
    ModalModule.forRoot(),
    TabsModule.forRoot()
  ],
  providers: [ CookieService ],
  entryComponents: [PersonalInfoComponent],
  bootstrap: [AppComponent]
})
export class AppModule { }
