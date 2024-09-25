import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Router } from '@angular/router';
import { JwtHelperService } from '@auth0/angular-jwt';
import { BehaviorSubject, Observable } from 'rxjs';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root'
})
export class AuthService {
  private urllogin:string=environment.urlApi ?? "http://127.0.0.1:8000/";
  private statusConnexion = new BehaviorSubject<boolean>(false);
  private isSuperAdmin = new BehaviorSubject<boolean>(false);
  private isAdminClient = new BehaviorSubject<boolean>(false);
  private isUserClient = new BehaviorSubject<boolean>(false);

  constructor(private http:HttpClient,private router:Router,public jwtHelper: JwtHelperService) {
    console.log(environment.urlApi);
   }
  loggin(data:any){
    return this.http.post(this.urllogin+"api/login_check" , data , {observe:'response'})
  }
  enregistrementToken(jwtToken : string){ 
    localStorage.setItem('token',jwtToken);
    this.isConnected();
    console.log(this.getUserRoles());
    
    this.router.navigate(['/admin'])
  }
  getToken(){
    let token=localStorage.getItem('token') ?? "";
    let roles:Array<string> = this.jwtHelper.decodeToken(token).roles;
    if (roles.includes("ROLE_ADMIN")) {
      
    }
    else if (roles.includes("ROLE_CLIENT_ADMIN")) {
      
    }
    else if (roles.includes("ROLE_CLIENT")) {
      
    }
    return localStorage.getItem('token' ?? '');
  }
  getUserRoles():Array<string>{
    let token=this.getToken() ?? "";
    return this.jwtHelper.decodeToken(token).roles;
  }
  public isAuthenticated(): Observable<boolean> {
    const token = localStorage.getItem('token');
    this.statusConnexion.next(!this.jwtHelper.isTokenExpired(token));
    return this.statusConnexion;
  }
  logout() {
    this.isDeconnected();
    localStorage.removeItem('token');
  }
  isConnected() {
    this.statusConnexion.next(true);
  }

  isDeconnected() {
    this.statusConnexion.next(false);
  }
}
