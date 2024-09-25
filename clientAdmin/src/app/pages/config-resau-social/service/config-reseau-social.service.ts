import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { environment } from 'src/environments/environment';
import { SocialMediaModel } from '../model/reseau.model';
import { Observable } from 'rxjs';
@Injectable({
  providedIn: 'root'
})
export class ConfigReseauSocialService {

  constructor(private http:HttpClient) { }
  getConfig():Observable<SocialMediaModel>{
    return this.http.get<SocialMediaModel>(environment.urlApi+"api/sociaux")
  }
  updateData(data:any):Observable<any>{
    return this.http.post(environment.urlApi+"api/sociaux",data)
  }
}
