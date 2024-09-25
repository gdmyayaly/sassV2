import { Injectable } from '@angular/core';
import { Utilisateur } from '../model/utilisateur';
import { environment } from 'src/environments/environment';
import { HttpClient } from '@angular/common/http';
import { BehaviorSubject, Observable } from 'rxjs';
import { map } from 'rxjs/operators';
import { AlertMessageService } from '../modal/alert-message/service/alert-message.service';

type UtilisateurNullable = Utilisateur | null;

@Injectable({
  providedIn: 'root'
})

export class UserInformationService {
  // public User?:Utilisateur;
  // private User = new BehaviorSubject<Utilisateur>(null);
  // private User: BehaviorSubject<Utilisateur> = new BehaviorSubject<Utilisateur>(null);
  private User: BehaviorSubject<UtilisateurNullable> = new BehaviorSubject<UtilisateurNullable>(null);

  constructor(private http:HttpClient,private modalMessageService:AlertMessageService) { }
  getInfos(){
    this.http.get<UtilisateurNullable>(environment.urlApi+"api/client/user"  , {observe:'response'}).subscribe(
      res=>{this.setUserData(res.body)},
      error=>{this.modalMessageService.show(error.error);}
    )
    // .pipe(
    //   map(response => response.body) // Extraction de l'objet UtilisateurNullable de la réponse HTTP
    // );
  }
  getUserData():Observable<UtilisateurNullable>{
    return this.User;
  }
  setUserData(data:UtilisateurNullable){
    this.User.next(data);
  }
  resetData(){

  }
}
