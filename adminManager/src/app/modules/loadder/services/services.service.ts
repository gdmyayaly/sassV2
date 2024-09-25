import { Injectable } from '@angular/core';
import { BehaviorSubject, Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class LoadderService {

  // private loading = false;
  private loading = new BehaviorSubject<boolean>(false)

  constructor() { }

  show() {
    this.loading.next(true);
  }

  hide() {
    this.loading.next(false);
  }

  isLoading(): Observable<boolean> {
    return this.loading;
  }
  
}
