import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { environment } from 'src/environments/environment';
import { VariationModel } from '../model/variation.model';
import { Observable } from 'rxjs';
{environment}
@Injectable({
  providedIn: 'root'
})
export class VariationProductService {

  constructor(private http:HttpClient) { }
  
  listVariation():Observable<VariationModel[]>{
    return this.http.get<VariationModel[]>(environment.urlApi+"api/client/variation-product");
  }
  detailOneVariation(data:any):Observable<VariationModel>{
    return this.http.post<VariationModel>(environment.urlApi+"api/client/variation-product/detail",data);
  }
  saveVariation(data:any):Observable<any>{
    return this.http.post(environment.urlApi+"api/client/variation-product",data);
  }
  updateVariation(data:any):Observable<any>{
    return this.http.post(environment.urlApi+"api/client/variation-product/update",data);
  }
  removeVariation(data:any):Observable<any>{
    return this.http.post(environment.urlApi+"api/client/variation-product/remove",data);
  }
}
