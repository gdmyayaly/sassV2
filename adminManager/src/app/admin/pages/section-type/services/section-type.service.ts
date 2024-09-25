import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { environment } from 'src/environments/environment';
import { SectionTypeModel } from '../models/section-type.model';

@Injectable({
  providedIn: 'root'
})
export class SectionTypeService {

  private urlApi:string=environment.urlApi ?? "http://127.0.0.1:8000/";

  constructor(private http:HttpClient) {}

  getAllSectionType():Observable<SectionTypeModel[]>{
    return this.http.get<SectionTypeModel[]>(this.urlApi+"admin/sectiontype")
  }
  saveSectionType(data:any){
    return this.http.post(this.urlApi+"admin/sectiontype" , data )
  }
  // getSection():Observable<SectionModel[]>{
  //   return this.http.get<SectionModel[]>(this.urlApi+"section"  )
  // }
  // getClientSection(id:string):Observable<SectionClientModel[]>{
  //   return this.http.get<SectionClientModel[]>(this.urlApi+"section/client/"+id  )
  // }
  // attributeClientSection(idClient:string,idSection:string):Observable<any>{
  //   return this.http.get<any>(this.urlApi+"api/admin/client/"+idClient+"/assign-sections/"+idSection  );
  // }
}
