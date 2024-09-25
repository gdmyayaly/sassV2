import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { RouteReuseStrategy } from '@angular/router';

import { IonicModule, IonicRouteStrategy } from '@ionic/angular';

import { AppComponent } from './app.component';
import { AppRoutingModule } from './app-routing.module';
import { ReactiveFormsModule } from '@angular/forms';
import { JwtModule } from "@auth0/angular-jwt";
import { HTTP_INTERCEPTORS, HttpClientModule } from '@angular/common/http';
import { LoadderInterceptor } from './modules/loadder/interceptor/loadder.interceptor';
import { LoadderComponent } from './modules/loadder/loadder.component';
import { AuthService } from './login/services/auth.service';
import { InterceptorService } from './login/interceptor/interceptor.service';
import { ErrorInterceptor } from './login/services/error-interceptor.service';
import { AlertMessageComponent } from './common/modal/alert-message/alert-message.component';
import { PreviewMediaComponent } from './common/modal/preview-media/preview-media.component';
import { SelectMediaComponent } from './common/modal/select-media/select-media.component';
import { provideAnimationsAsync } from '@angular/platform-browser/animations/async';
import { SelectMultiMediaComponent } from './common/modal/select-multi-media/select-media.component';

export function tokenGetter() {
  return localStorage.getItem("token");
}
@NgModule({
  declarations: [AppComponent,LoadderComponent,AlertMessageComponent,PreviewMediaComponent,SelectMediaComponent,SelectMultiMediaComponent],
  imports: [BrowserModule, IonicModule.forRoot(), AppRoutingModule,ReactiveFormsModule,HttpClientModule,
    JwtModule.forRoot({
      config: {
        tokenGetter: tokenGetter,
       // whitelistedDomains: ["example.com"],
       // blacklistedRoutes: ["http://example.com/examplebadroute/"],
      },
    })
  ],
  providers: [
    { provide: RouteReuseStrategy, useClass: IonicRouteStrategy },
    AuthService,
    {
      provide:HTTP_INTERCEPTORS,
      useClass:InterceptorService,
      multi:true
    },
    { provide: HTTP_INTERCEPTORS, useClass: LoadderInterceptor, multi: true },
    { provide: HTTP_INTERCEPTORS, useClass: ErrorInterceptor, multi: true },
    provideAnimationsAsync()
  ],
  bootstrap: [AppComponent],
})
export class AppModule {}
