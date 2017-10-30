// Modules
import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { HttpModule } from '@angular/http';
import { AppRoutingModule } from './app-routing.module';
import { RouterModule } from '@angular/router';
import { AccordionModule } from 'ngx-bootstrap';
// Components
import { AppComponent } from './app.component';
import { LoginComponent } from './loginform.component';
import { MainComponent } from './main.component';
import { MenuComponent } from './menu.component';
import { NavbarComponent } from './navbar.component';
import { StudListComponent } from './studList.component';
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
  ],
  imports: [
    BrowserModule,
    FormsModule,
    HttpModule,
	  AppRoutingModule,
    AccordionModule.forRoot()
  ],
  providers: [ CookieService ],
  bootstrap: [AppComponent]
})
export class AppModule { }
