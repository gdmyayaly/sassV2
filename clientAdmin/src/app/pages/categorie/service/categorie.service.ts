import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { environment } from 'src/environments/environment';
import { CategoryModel } from '../model/category.model';
import { Observable } from 'rxjs';
@Injectable({
  providedIn: 'root'
})
export class CategorieService {

  constructor(private http:HttpClient) { }
  listCategorie():Observable<CategoryModel[]>{
    return this.http.get<CategoryModel[]>(environment.urlApi+"api/client/category");
  }
  saveCategorie(data:any):Observable<any>{
    return this.http.post(environment.urlApi+"api/client/category",data);
  }
  updateCategorie(data:any):Observable<any>{
    return this.http.post(environment.urlApi+"api/client/category/update",data);
  }
  removeCategorie(data:any):Observable<any>{
    return this.http.post(environment.urlApi+"api/client/category/remove",data);
  }
  detailCategorie(data:string):Observable<CategoryModel>{
    return this.http.get<CategoryModel>(environment.urlApi+"api/client/category/detail/"+data);
  }
  detailSousCategorie(data:{idCat:string,idSousCat:string}):Observable<any>{
    return this.http.get<any>(environment.urlApi+"api/client/souscategory/detail/"+data.idCat+"/"+data.idSousCat);
  }
  addSousCategorie(data:any):Observable<any>{
    return this.http.post(environment.urlApi+"api/client/souscategory/add",data);
  }
  removeSousCategorie(data:any):Observable<any>{
    return this.http.post(environment.urlApi+"api/client/souscategory/remove",data);
  }
  updateSousCategorie(data:any):Observable<any>{
    return this.http.post(environment.urlApi+"api/client/souscategory/update",data);
  }
}
