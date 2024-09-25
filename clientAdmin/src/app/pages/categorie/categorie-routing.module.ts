import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { CategoriePage } from './categorie.page';
import { ListCategorieComponent } from './list-categorie/list-categorie.component';
import { AddCategorieComponent } from './add-categorie/add-categorie.component';
import { UpdateCategorieComponent } from './update-categorie/update-categorie.component';
import { ListSousCategorieComponent } from './sous-categorie/list-sous-categorie/list-sous-categorie.component';
import { AddSousCategorieComponent } from './sous-categorie/add-sous-categorie/add-sous-categorie.component';
import { UpdateSousCategorieComponent } from './sous-categorie/update-sous-categorie/update-sous-categorie.component';

const routes: Routes = [
  {
    path: '',
    component: ListCategorieComponent
  },
  {
    path: 'add',
    component: AddCategorieComponent
  },
  {
    path: 'update/:id',
    component: UpdateCategorieComponent
  },
  {
    path: 'sous-categorie/:sousCat',
    component: ListSousCategorieComponent
  },
  {
    path: 'sous-categorie/:sousCat/add',
    component: AddSousCategorieComponent
  },
  {
    path: 'sous-categorie/:sousCat/update/:id',
    component: UpdateSousCategorieComponent
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class CategoriePageRoutingModule {}
