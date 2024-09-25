import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { environment } from 'src/environments/environment';
import { ProductModel } from '../model/product.model';

@Injectable({
  providedIn: 'root'
})
export class ProductService {

  constructor(private http:HttpClient) { }
  saveMedia(data:any):Observable<any>{
    return this.http.post(environment.urlApi+"api/client/product", data);
  }
  listMedia():Observable<ProductModel[]>{
    return this.http.get<ProductModel[]>(environment.urlApi+"api/client/product");
  }
  removeMedia(data:any):Observable<any>{
    return this.http.post(environment.urlApi+"api/client/product/remove", data);
  }
  detailOneProduct(data:string):Observable<any>{
    return this.http.get<any>(environment.urlApi+"api/client/product/detail/"+data);
  }
  updateProduct(data:any,id:string):Observable<any>{
    return this.http.post(environment.urlApi+"api/client/product/edit/"+id, data);
  }
}
