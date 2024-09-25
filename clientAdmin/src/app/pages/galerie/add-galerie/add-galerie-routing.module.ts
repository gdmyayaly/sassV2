import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { AddGaleriePage } from './add-galerie.page';

const routes: Routes = [
  {
    path: '',
    component: AddGaleriePage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class AddGaleriePageRoutingModule {}
