import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { ListGaleriePageRoutingModule } from './list-galerie-routing.module';

import { ListGaleriePage } from './list-galerie.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    ListGaleriePageRoutingModule
  ],
  declarations: [ListGaleriePage]
})
export class ListGaleriePageModule {}
