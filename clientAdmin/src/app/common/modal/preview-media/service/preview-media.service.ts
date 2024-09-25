import { Injectable } from '@angular/core';
import { BehaviorSubject, Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class PreviewMediaService {

  private showAlert = new BehaviorSubject<boolean>(false);
  private image = new BehaviorSubject<{type:string,url:string}>({type:"",url:""})

  constructor() { }

  show(data:{type:string,url:string}) {
    this.image.next(data);
    this.showAlert.next(true);
  }

  hide() {
    this.image.next({type:"",url:""});
    this.showAlert.next(false);
  }

  statusAlert(): Observable<boolean> {
    return this.showAlert;
  }
  getImage(): Observable<{type:string,url:string}> {
    return this.image;
  }
}
