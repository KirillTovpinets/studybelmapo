import { Injectable } from '@angular/core';
import { Router } from '@angular/router';
import { CanActivate, ActivatedRouteSnapshot, RouterStateSnapshot } from '@angular/router';
import { Observable } from 'rxjs/Observable';
import { CookieService } from 'ngx-cookie-service';
import { CheckAuthService } from './checkAuth.service';
import { LoginService } from './loginform/login.service';
import { ShareService } from './share/share.service';

@Injectable()
export class AuthGuard implements CanActivate {
	constructor(private router: Router,
              private checkAuth: CheckAuthService,
              private loginService: LoginService,
              private share: ShareService){}
  public isLoggedIn:boolean = false;
  public redirectUrl: string;
  canActivate(next: ActivatedRouteSnapshot, state: RouterStateSnapshot): boolean {
    this.redirectUrl = state.url;
      this.checkUpdates();
     return this.checkAuthAction();
  }

  checkAuthAction():boolean{
    if (this.isLoggedIn) {
      return true;
    }else{
      this.checkAuth.check().subscribe(response => {
       try{
         var user = response.json();
         this.isLoggedIn =  true;
         this.router.navigateByUrl(this.redirectUrl);
       }catch(e){
         this.isLoggedIn = false;
         this.router.navigate(["/login"]);
       }
     });
    }
  }
  checkUpdates():void{
    this.loginService.getUpdates().then(data => {
      console.log(data._body);
      this.share.setUpdates(data.json());
    })
  }
}


