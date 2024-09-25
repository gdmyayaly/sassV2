import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { ConfigWebsitePageRoutingModule } from './config-website-routing.module';

import { ConfigWebsitePage } from './config-website.page';
import { AddVariationProductComponent } from './variation-product/add-vation-product/add-vation-product.component';
import { ListVariationProductComponent } from './variation-product/list-vation-product/list-vation-product.component';
import { UpdateVationProductComponent } from './variation-product/update-vation-product/update-vation-product.component';
import { ModulesClientComponent } from './page-web/modules-client/modules-client.component';
import { ListCustomPageWebComponent } from './page-web/custom/list-custom-page-web/list-custom-page-web.component';
import { DetailCustomPageWebComponent } from './page-web/custom/detail-custom-page-web/detail-custom-page-web.component';
import { ListPageWebComponent } from './page-web/list-page-web/list-page-web.component';
import { ListDefaultSectionComponent } from './page-web/default-section/list-default-section/list-default-section.component';
@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    ReactiveFormsModule,
    ConfigWebsitePageRoutingModule
  ],
  declarations: [
    ConfigWebsitePage,
    AddVariationProductComponent,
    ListVariationProductComponent,
    UpdateVationProductComponent,
    ModulesClientComponent,
    ListPageWebComponent,
    ListCustomPageWebComponent,
    DetailCustomPageWebComponent,
    ListDefaultSectionComponent
  ]
})
export class ConfigWebsitePageModule {}
