import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { CategoriePageRoutingModule } from './categorie-routing.module';

import { CategoriePage } from './categorie.page';
import { ListCategorieComponent } from './list-categorie/list-categorie.component';
import { AddCategorieComponent } from './add-categorie/add-categorie.component';
import { UpdateCategorieComponent } from './update-categorie/update-categorie.component';
import { ListSousCategorieComponent } from './sous-categorie/list-sous-categorie/list-sous-categorie.component';
import { AddSousCategorieComponent } from './sous-categorie/add-sous-categorie/add-sous-categorie.component';
import { UpdateSousCategorieComponent } from './sous-categorie/update-sous-categorie/update-sous-categorie.component';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    ReactiveFormsModule,
    CategoriePageRoutingModule
  ],
  declarations: [CategoriePage,ListCategorieComponent,AddCategorieComponent,UpdateCategorieComponent,ListSousCategorieComponent,AddSousCategorieComponent,UpdateSousCategorieComponent]
})
export class CategoriePageModule {}
