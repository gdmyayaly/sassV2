import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { environment } from 'src/environments/environment';
import { SectionModel } from '../models/section.model';
import { SectionClientModel } from '../models/sectionClient.model';

@Injectable({
  providedIn: 'root'
})
export class SectionWebsiteService {

  private urlApi:string=environment.urlApi ?? "http://127.0.0.1:8000/";

  constructor(private http:HttpClient) {}
  saveSection(data:any){
    return this.http.post(this.urlApi+"section" , data )
  }
  getSection(id:string):Observable<SectionModel[]>{
    return this.http.get<SectionModel[]>(this.urlApi+"section/type/"+id  )
  }
  getAllSection():Observable<SectionModel[]>{
    return this.http.get<SectionModel[]>(this.urlApi+"sectionall"  )
  }
  getClientSection(id:string):Observable<SectionClientModel[]>{
    return this.http.get<SectionClientModel[]>(this.urlApi+"section/client/"+id  )
  }
  attributeClientSection(idClient:string,idSection:string):Observable<any>{
    return this.http.get<any>(this.urlApi+"api/admin/client/"+idClient+"/assign-sections/"+idSection  );
  }
}
