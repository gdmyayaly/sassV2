import { Injectable } from '@angular/core';
import { Router, CanActivate } from '@angular/router';
import { AuthService } from '../service/auth.service';

@Injectable({
    providedIn: 'root'
})
export class AuthGuardService implements CanActivate {
  private isAuth:boolean=false;
  constructor(public auth: AuthService, public router: Router) {
    this.auth.isAuthenticated().subscribe(val=>{this.isAuth=val})
  }
  canActivate() {
    if (!this.isAuth) {
    this.auth.logout();
    this.router.navigateByUrl("/login")
      return false;
    }
    return true;
  }
}