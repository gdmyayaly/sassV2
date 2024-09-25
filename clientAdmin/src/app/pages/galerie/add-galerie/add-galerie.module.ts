import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { AddGaleriePageRoutingModule } from './add-galerie-routing.module';

import { AddGaleriePage } from './add-galerie.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    AddGaleriePageRoutingModule
  ],
  declarations: [AddGaleriePage]
})
export class AddGaleriePageModule {}
