import { Injectable } from '@angular/core';
import {
  HttpRequest,
  HttpHandler,
  HttpEvent,
  HttpInterceptor
} from '@angular/common/http';
import { Observable, finalize } from 'rxjs';
import { LoadderService } from '../services/services.service';

@Injectable()
export class LoadderInterceptor implements HttpInterceptor {

  constructor(private loaderService: LoadderService) {}

  intercept(request: HttpRequest<unknown>, next: HttpHandler): Observable<HttpEvent<unknown>> {
    // return next.handle(request);
    this.loaderService.show();
    return next.handle(request).pipe(
      finalize(() => this.loaderService.hide())
    );
  }
}
