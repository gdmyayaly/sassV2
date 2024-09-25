import { Injectable } from '@angular/core';
import { BehaviorSubject, Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class AlertMessageService {
  private showAlert = new BehaviorSubject<boolean>(false);
  private message = new BehaviorSubject<string[]>([])

  constructor() { }

  show(data:any) {
    
    if (data.message) {this.message.next([data.message]);}
    else{this.message.next(["",data]);}
    this.showAlert.next(true);
  }

  hide() {
    this.message.next([]);
    this.showAlert.next(false);
    // location.reload();
  }

  statusAlert(): Observable<boolean> {
    return this.showAlert;
  }
  getMessage(): Observable<string[]> {
    return this.message;
  }
}
