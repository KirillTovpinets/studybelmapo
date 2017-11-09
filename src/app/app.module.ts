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
    PersonalInfoComponent
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
