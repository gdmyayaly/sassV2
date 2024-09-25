import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { AuthComponent } from './auth/auth.component';
import { JwtModule } from "@auth0/angular-jwt";
import { AuthService } from './auth/service/auth.service';
import { HTTP_INTERCEPTORS, HttpClientModule } from '@angular/common/http';
import { LoadderInterceptor } from './modules/loadder/interceptor/loadder.interceptor';
import { ErrorInterceptor } from './auth/service/error-interceptor.service';
import { InterceptorService } from './auth/interceptor/interceptor.service';
import { LoadderComponent } from './modules/loadder/loadder.component';
import { HomeComponent } from './home/home.component';
import { ReactiveFormsModule } from '@angular/forms';
import { AdminComponent } from './admin/admin.component';
import { UtilisateurComponent } from './utilisateur/utilisateur.component';
import { HomeAdminComponent } from './admin/pages/home-admin/home-admin.component';

export function tokenGetter() {
  return localStorage.getItem("token");
}
@NgModule({
  declarations: [
    AppComponent,
    AuthComponent,
    LoadderComponent,
    // HomeComponent,
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    HttpClientModule,
    ReactiveFormsModule,
    JwtModule.forRoot({
      config: {
        tokenGetter: tokenGetter,
       // whitelistedDomains: ["example.com"],
       // blacklistedRoutes: ["http://example.com/examplebadroute/"],
      },
    })
  ],
  providers: [
    AuthService,
    {
      provide:HTTP_INTERCEPTORS,
      useClass:InterceptorService,
      multi:true
    },
    { provide: HTTP_INTERCEPTORS, useClass: LoadderInterceptor, multi: true },
    { provide: HTTP_INTERCEPTORS, useClass: ErrorInterceptor, multi: true },
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
