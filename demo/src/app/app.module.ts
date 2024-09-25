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

// import ngx-translate and the http loader
import {HttpClient, HttpClientModule} from '@angular/common/http';
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
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    // ngx-translate and the loader module
    HttpClientModule,
    
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
// required for AOT compilation
