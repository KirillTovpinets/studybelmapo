import { Component, OnInit } from '@angular/core';
import { LoginService } from './login.service';
import { CookieService } from 'ngx-cookie-service';
import { Router } from '@angular/router';
import { Login } from '../Model/login';
import { User } from '../Model/user';
import { AddUserService } from "./addUser.service";
import { NotificationsService } from 'angular4-notify';

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
				private router: Router){}
	onSubmit(login): void{
		// this.router.navigate(['/main']);
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
				}else{
					this.router.navigate(["/main"]);					
				}
				
			}catch(e){
				if(response._body == "pass"){
					this.notify.addError("Неправильный пароль");
				}else if(response._body == "login"){
					this.notify.addError("Неправильный логин");
				}
				console.log(e);
				console.log(response._body);
			}
		})
		.catch(this.handleError);
	}
	ngOnInit(): void {
		console.log("PRIVET")
		this.loginService.getDepList("cathedras").then(data => {
			console.log(data);
			try{
				console.log(data);
				this.cathedras = data.json();
			}catch(e){
				console.log(data._body);
			}
		});

		this.loginService.getDepList("belmapo_departments").then(data => {
			try{
				console.log(data);
				this.departments = data.json();
			}catch(e){
				console.log(data._body);
			}
		});
	}
	AddUser(user:User):void{
		this.addUser.add(user).then(data => {
			console.log(data._body);
			this.notify.addInfo(data.json().message)
		});
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