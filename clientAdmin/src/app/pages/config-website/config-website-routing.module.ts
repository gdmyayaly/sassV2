import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { ConfigWebsitePage } from './config-website.page';
import { ListVariationProductComponent } from './variation-product/list-vation-product/list-vation-product.component';
import { AddVariationProductComponent } from './variation-product/add-vation-product/add-vation-product.component';
import { UpdateVationProductComponent } from './variation-product/update-vation-product/update-vation-product.component';
import { ModulesClientComponent } from './page-web/modules-client/modules-client.component';
import { ListCustomPageWebComponent } from './page-web/custom/list-custom-page-web/list-custom-page-web.component';
import { ListPageWebComponent } from './page-web/list-page-web/list-page-web.component';
import { ListDefaultSectionComponent } from './page-web/default-section/list-default-section/list-default-section.component';

const routes: Routes = [
  {
    path: '',
    component: ConfigWebsitePage
  },
  {
    path: 'variation-product',
    component: ListVariationProductComponent
  },
  {
    path: 'variation-product/add',
    component: AddVariationProductComponent
  },
  {
    path: 'variation-product/update/:id',
    component: UpdateVationProductComponent
  },
  {
    path: 'website',
    component: ListPageWebComponent
  },
  
  {
    path: 'website/custom',
    component: ListCustomPageWebComponent
  },
  {
    path: 'website/module',
    component: ModulesClientComponent
  },
  {
    path: 'website/detail/:id',
    component: ListDefaultSectionComponent
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class ConfigWebsitePageRoutingModule {}
