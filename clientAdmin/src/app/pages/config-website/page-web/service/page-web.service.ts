import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { environment } from 'src/environments/environment';
import { Observable } from 'rxjs';
import { ModuleClientModel } from '../models/moduleClient.model';
import { SectionTypeDefaultModel } from '../models/sectionTypeDefault.model';


@Injectable({
  providedIn: 'root'
})
export class PageWebService {

  constructor(private http:HttpClient) { }

  loadAllModulesClient():Observable<ModuleClientModel[]>{
    return this.http.get<ModuleClientModel[]>(environment.urlApi+"api/client/clientmodules");
  }
  loadAllSectionTypeDefault():Observable<SectionTypeDefaultModel[]>{
    return this.http.get<SectionTypeDefaultModel[]>(environment.urlApi+"api/client/clientdefaultsectiontype");
  } 
  loadAllSectionTypeDefaultDetail(id:string):Observable<ModuleClientModel[]>{
    return this.http.get<ModuleClientModel[]>(environment.urlApi+"api/client/clientdefaultsectiontypedetail/"+id);
  } 
  
}
