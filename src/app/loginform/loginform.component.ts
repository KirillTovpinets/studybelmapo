import { Component, OnInit } from '@angular/core';
import { LoginService } from './login.service';
import { CookieService } from 'ngx-cookie-service';
import { Router } from '@angular/router';
import { Login } from '../Model/login';
import { User } from '../Model/user';
import { AddUserService } from "./addUser.service";
import { NotificationsService } from 'angular4-notify';
import { LogService } from '../share/log.service';
import { ShareService } from '../share/share.service';

declare var jquery: any;
declare var $: any;
@Component({
	selector: 'login-form',
	templateUrl: './loginform.component.html',
	styleUrls: ['./login.component.css'],
	providers: [LoginService, CookieService, AddUserService]
})

export class LoginComponent implements OnInit{
	user = new User();
	login = new Login();
	isLoged: boolean = false;
	cathedras: any[] = [];
	departments: any[] = [];
	logedUser: any;
	constructor(private loginService: LoginService, 
				private cookieService: CookieService,
				private addUser: AddUserService,
				private notify: NotificationsService,
				private log: LogService,
				private share: ShareService,
				private router: Router){}
	onSubmit(login): void{
		this.loginService.tryLogin(login)
		.then(response => {
			try{
				this.logedUser = response.json();
				this.isLoged = true;
				localStorage.setItem("currentUser", JSON.stringify(this.logedUser));
				this.loginService.setUserLogedIn();
				this.cookieService.set("Login", "true");
				if (this.logedUser.is_cathedra == null) {
					this.router.navigate(["/admin"]);
				}else if(this.logedUser.is_cathedra == 1){
					this.router.navigate(["/main"]);					
				}else{
					this.router.navigate(["/department"]);
				}
				
			}catch(e){
				if(response._body == "pass"){
					this.notify.addError("Неправильный пароль");
				}else if(response._body == "login"){
					this.notify.addError("Неправильный логин");
				}
				this.log.SendError({page: 'loginform', error: e, response: response._body});
				this.notify.addError("Произошла ошибка. Обратитесь к администратору");
			}
		})
		.catch((e) => {
			this.notify.addError("Что-то пошло не так. Обратитесь к администратору");
		});
	}
	ngOnInit(): void {
		this.loginService.getDepList("cathedras").then(data => {
			try{
				this.cathedras = data.json();
			}catch(e){
				this.log.SendError({page: 'loginform', error: e, response: data});
				this.notify.addError("Произошла ошибка. Обратитесь к администратору");
			}
		});

		this.loginService.getDepList("belmapo_departments").then(data => {
			try{
				this.departments = data.json();
			}catch(e){
				this.log.SendError({page: 'loginform', error: e, response: data});
				this.notify.addError("Произошла ошибка. Обратитесь к администратору");
			}
		});
	}
	AddUser(user:User):void{
		this.addUser.add(user).then(data => {
			this.notify.addInfo(data.json().message);
			this.slideUp();
		});
	}
	slideUp(): void{
	  $('form').animate({
	      height: "toggle",
	      opacity: "toggle"
	    }, "slow");
	}
}