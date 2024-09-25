import { Injectable } from '@angular/core';
import { BehaviorSubject, Observable } from 'rxjs';
import { SocialMediaModel } from '../model/social-media.model';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root'
})
export class InfosClientService {
  private socialMediaInfos: BehaviorSubject<SocialMediaModel> = new BehaviorSubject<SocialMediaModel>({
    facebook:"",
    homemessage:"",
    id:undefined,
    instagram:"",
    numero:"",
    shopmessage:"",
    snapchat:"",
  });

  constructor(private http:HttpClient) { }
  
  getInfosReseau(){
    this.http.get<SocialMediaModel>(environment.apiUrl+"social").subscribe(
      res=>{this.socialMediaInfos.next(res)},
      error=>{this.checkDefaultData()}
    )
  }

  getData():Observable<SocialMediaModel>{
    return this.socialMediaInfos;
  }
  checkDefaultData(){
    this.socialMediaInfos.next({
      facebook:"",
      homemessage:"Bonjour *SnackLand* je viens de visiter votre site web et je serais intéresser par :",
      id:0,
      instagram:"",
      numero:"784338388",
      shopmessage:"Bonjour *SnackLand* je viens de visiter votre site web et je serais intéresser par le produit suivant:",
      snapchat:"",
    })
  }
}
