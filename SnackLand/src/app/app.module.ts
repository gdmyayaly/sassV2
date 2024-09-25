import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { MenuWebComponent } from './commons/menu-web/menu-web.component';
import { AccueilComponent } from './pages/accueil/accueil.component';
import { BoutiqueComponent } from './pages/boutique/boutique.component';
import { ContactComponent } from './pages/contact/contact.component';
import { ProductComponent } from './pages/product/product.component';
import { FooterComponent } from './commons/footer/footer.component';
import { CardProductComponent } from './commons/card-product/card-product.component';
import { Banner1Component } from './components/banner/banner1/banner1.component';
import { Banner2Component } from './components/banner/banner2/banner2.component';
import { AboutMeComponent } from './components/about-me/about-me.component';
import { LoadderComponent } from './commons/loadder/loadder.component';
import { HTTP_INTERCEPTORS, HttpClientModule } from '@angular/common/http';
import { LoadderInterceptor } from './commons/loadder/interceptor/loadder.interceptor';
import { FeatherModule } from 'angular-feather';
import { Facebook,Instagram,Twitter,Menu,XCircle } from 'angular-feather/icons';
import { MenuMobileComponent } from './commons/menu-mobile/menu-mobile.component';
import { ReactiveFormsModule } from '@angular/forms';

// Select some icons (use an object, not an array)
const icons = {
  Facebook,
  Instagram,
  Twitter,
  Menu,
  XCircle
};
@NgModule({
  declarations: [
    AppComponent,
    MenuWebComponent,
    AccueilComponent,
    BoutiqueComponent,
    ContactComponent,
    ProductComponent,
    FooterComponent,
    CardProductComponent,
    Banner1Component,
    Banner2Component,
    AboutMeComponent,
    LoadderComponent,
    MenuMobileComponent,
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    HttpClientModule,
    ReactiveFormsModule,
    FeatherModule.pick(icons)
  ],
  providers: [
    { provide: HTTP_INTERCEPTORS, useClass: LoadderInterceptor, multi: true }
  ],
  exports: [
    FeatherModule
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
