import { Component, OnInit } from '@angular/core';
import { LoginService } from './login.service';
import { CookieService } from 'ngx-cookie-service';
import { Router } from '@angular/router';
import { Login } from './login';
import { User } from './user';
import { AddUserService } from "./services/addUser.service";
import { NotificationsService } from 'angular4-notify';

declare var jquery: any;
declare var $: any;
@Component({
	selector: 'login-form',
	templateUrl: 'templates/loginform.component.html',
	styleUrls: ['css/login.component.css'],
	providers: [LoginService, CookieService, AddUserService, NotificationsService]
})

export class LoginComponent implements OnInit{
	user = new User();
	login = new Login();
	isLoged: boolean = false;
	cathedras: any[] = [];
	departments: any[] = [];
	constructor(private loginService: LoginService, 
				private cookieService: CookieService,
				private addUser: AddUserService,
				private notify: NotificationsService,
				private router: Router){}
	onSubmit(login): void{
		// this.router.navigate(['/main']);
		this.loginService.tryLogin(login)
		.then(response => {
			if(response._body == "success"){
				this.isLoged = true;
				this.loginService.setUserLogedIn();
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
	ngOnInit(): void {
		this.loginService.getDepList("cathedras").then(data => this.cathedras = data.json());
		this.loginService.getDepList("belmapo_departments").then(data => this.departments = data.json());
	}
	AddUser(user:User):void{
		this.addUser.add(user).then(data => this.notify.addInfo("Пользователь добавлен"));
	}
	private handleError(error: any): Promise<any>{
		return Promise.reject(error.message || error);
	}
	slideUp(): void{
	  $('form').animate({
	      height: "toggle",
	      opacity: "toggle"
	    }, "slow");
	}
}