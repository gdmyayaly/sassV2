import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Router } from '@angular/router';
import { JwtHelperService } from '@auth0/angular-jwt';
import { environment } from 'src/environments/environment';
import { BehaviorSubject, Observable } from 'rxjs';
@Injectable({
  providedIn: 'root'
})
export class AuthService {
  private urllogin:string=environment.urlApi ?? "http://127.0.0.1:8000/";
  private statusConnexion = new BehaviorSubject<boolean>(false)
  constructor(private http:HttpClient,private router:Router,public jwtHelper: JwtHelperService) {
    console.log(environment.urlApi);
   }
  loggin(data:any){
    return this.http.post(this.urllogin+"api/login_check" , data , {observe:'response'})
  }
  enregistrementToken(jwtToken : string){ 
    localStorage.setItem('token',jwtToken);
    this.isConnected();
    this.router.navigate(['/accueil'])
  }
  getToken(){
    return localStorage.getItem('token');
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