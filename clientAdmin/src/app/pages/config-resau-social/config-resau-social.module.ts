import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { ConfigResauSocialPageRoutingModule } from './config-resau-social-routing.module';

import { ConfigResauSocialPage } from './config-resau-social.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    ReactiveFormsModule,
    ConfigResauSocialPageRoutingModule
  ],
  declarations: [ConfigResauSocialPage]
})
export class ConfigResauSocialPageModule {}
