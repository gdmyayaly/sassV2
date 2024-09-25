import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { ProductPageRoutingModule } from './product-routing.module';

import { ProductPage } from './product.page';
import { AddProductComponent } from './add-product/add-product.component';
import { ListProductComponent } from './list-product/list-product.component';
import { UpdateProductComponent } from './update-product/update-product.component';
import { NgxColorsModule } from 'ngx-colors';
import { DetailProductComponent } from './detail-product/detail-product.component';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    ReactiveFormsModule,
    NgxColorsModule,
    ProductPageRoutingModule
  ],
  declarations: [ProductPage,AddProductComponent,ListProductComponent,UpdateProductComponent,DetailProductComponent]
})
export class ProductPageModule {}
