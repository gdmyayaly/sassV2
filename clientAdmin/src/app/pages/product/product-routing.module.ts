import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { ProductPage } from './product.page';
import { ListProductComponent } from './list-product/list-product.component';
import { AddProductComponent } from './add-product/add-product.component';
import { UpdateProductComponent } from './update-product/update-product.component';
import { DetailProductComponent } from './detail-product/detail-product.component';

const routes: Routes = [
  {
    path: '',
    component: ListProductComponent
  },
  {
    path: 'add',
    component: AddProductComponent
  },
  {
    path: 'detail/:id',
    component: DetailProductComponent
  },
  {
    path: 'update/:id',
    component: UpdateProductComponent
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class ProductPageRoutingModule {}
