import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { ListGaleriePage } from './list-galerie.page';

const routes: Routes = [
  {
    path: '',
    component: ListGaleriePage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class ListGaleriePageRoutingModule {}
