import { Component } from '@angular/core';
import { LoginService } from './login.service';
import { CookieService } from 'ngx-cookie-service';
import { Router } from '@angular/router';
import { Login } from './login';
import { User } from './user';


declare var jquery: any;
declare var $: any;
@Component({
	selector: 'login-form',
	templateUrl: 'templates/loginform.component.html',
	styleUrls: ['css/login.component.css'],
	providers: [LoginService, CookieService]
})

export class LoginComponent{
	user = new User();
	login = new Login();
	constructor(private loginService: LoginService, 
				private cookieService: CookieService,
				private router: Router){}
	onSubmit(login): void{
		// this.router.navigate(['/main']);
		this.loginService.tryLogin(login)
		.then(response => {
			if(response._body == "success"){
				this.cookieService.set("Login", "true");
				this.router.navigate(["/main"]);
			}else if(response._body == "pass"){
				alert("Неправильный пароль");
			}else if(response._body == "log"){
				alert("Неправильный логин");
			}
		})
		.catch(this.handleError);
	}
	private handleError(error: any): Promise<any>{
		console.log("An error occurred", error);
		return Promise.reject(error.message || error);
	}
	slideUp(): void{
	  $('form').animate({
	      height: "toggle",
	      opacity: "toggle"
	    }, "slow");
	}
}