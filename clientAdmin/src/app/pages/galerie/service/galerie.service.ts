import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { environment } from 'src/environments/environment';
import { GalerieModel } from '../model/galerie.model';
@Injectable({
  providedIn: 'root'
})
export class GalerieService {

  constructor(private http:HttpClient) { }
  saveMedia(data:any):Observable<any>{
    return this.http.post(environment.urlApi+"api/client/galerie", data);
  }
  listMedia():Observable<GalerieModel[]>{
    return this.http.get<GalerieModel[]>(environment.urlApi+"api/client/galerie");
  }
  removeMedia(data:any):Observable<any>{
    return this.http.post(environment.urlApi+"api/client/galerie/remove", data);
  }
}
