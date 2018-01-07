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
	providers: [LoginService, CookieService, AddUserService]
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
			try{
				if(response._body == "success"){
					this.isLoged = true;
					this.loginService.setUserLogedIn();
					this.cookieService.set("Login", "true");
					this.router.navigate(["/main"]);
				}else if(response._body == "pass"){
					this.notify.addError("Нерпавильный пароль");
				}else if(response._body == "login"){
					this.notify.addError("Нерпавильный логин");
				}
			}catch(e){
				console.log(e);
				console.log(response._body);
			}
		})
		.catch(this.handleError);
	}
	ngOnInit(): void {
		this.loginService.getDepList("cathedras").then(data => {
			try{
				this.cathedras = data.json();
			}catch(e){
				console.log(data._body);
			}
		});

		this.loginService.getDepList("belmapo_departments").then(data => {
			try{
				this.departments = data.json();
			}catch(e){
				console.log(data._body);
			}
		});
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