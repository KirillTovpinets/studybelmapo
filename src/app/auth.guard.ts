import { Injectable } from '@angular/core';
import { Router } from '@angular/router';
import { CanActivate, ActivatedRouteSnapshot, RouterStateSnapshot } from '@angular/router';
import { Observable } from 'rxjs/Observable';
import { CookieService } from 'ngx-cookie-service';

@Injectable()
export class AuthGuard implements CanActivate {
	constructor(private router: Router,
				private cookieService: CookieService){}
  canActivate(next: ActivatedRouteSnapshot, state: RouterStateSnapshot): boolean {
  	if (this.cookieService.get("Login") === undefined) {
  		console.log("unloged");
  		this.router.navigate(["/login"]);
  	}else if (this.cookieService.get("Login") == "true") {
  		console.log("loged");
  		return true;
  	}
  }
}


