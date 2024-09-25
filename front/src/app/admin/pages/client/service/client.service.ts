import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { environment } from 'src/environments/environment';
import { ClientModel } from '../models/client.model';

@Injectable({
  providedIn: 'root'
})
export class ClientService {
  private urlApi:string=environment.urlApi ?? "http://127.0.0.1:8000/";

  constructor(private http:HttpClient) {
   }
  saveClient(data:any){
    return this.http.post(this.urlApi+"admin/client-configuration" , data )
  }
  getClient():Observable<ClientModel[]>{
    return this.http.get<ClientModel[]>(this.urlApi+"admin/client-configuration"  )
  }
  getOneClient(idClient:string):Observable<ClientModel>{
    return this.http.get<ClientModel>(this.urlApi+"admin/client-configuration/"+idClient  )
  }
  loadSiteClient(idClient:string):Observable<ClientModel>{
    return this.http.get<ClientModel>(this.urlApi+"client"  )
  }
}
