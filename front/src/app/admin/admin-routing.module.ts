import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { HomeAdminComponent } from './pages/home-admin/home-admin.component';
import { AdminComponent } from './admin.component';
import { ListClientComponent } from './pages/client/list-client/list-client.component';
import { AddClientComponent } from './pages/client/add-client/add-client.component';
import { DetailClientComponent } from './pages/client/detail-client/detail-client.component';
import { ListSectionComponent } from './pages/section/list-section/list-section.component';
import { AddSectionComponent } from './pages/section/add-section/add-section.component';
import { ListSectionTypeComponent } from './pages/section-type/list-section-type/list-section-type.component';
import { AddSectionTypeComponent } from './pages/section-type/add-section-type/add-section-type.component';
import { PagesWebComponent } from './pages/client/detail-client/pages-web/pages-web.component';
import { ModulesClientComponent } from './pages/client/detail-client/modules-client/modules-client.component';
import { ModulesStoreComponent } from './pages/client/detail-client/modules-store/modules-store.component';

const routes: Routes = [
  {
    path: '',
    component: AdminComponent,children:[
      {path: 'dashboard', component: HomeAdminComponent},
      {path: 'client', component: ListClientComponent},
      {path: 'client/add', component: AddClientComponent},
      {path: 'client/detail/:id', component: DetailClientComponent},
      {path: 'client/detail/page-web/:id', component: PagesWebComponent},
      {path: 'client/detail/modules/:id', component: ModulesClientComponent},
      {path: 'client/detail/modules-store/:id', component: ModulesStoreComponent},

      {path: 'section-type', component: ListSectionTypeComponent},
      {path: 'section-type/add', component: AddSectionTypeComponent},
      {path: 'section/:section-type-id', component: ListSectionComponent},
      {path: 'section/:section-type-id/add', component: AddSectionComponent},
      {path: 'section/detail/:id', component: DetailClientComponent},
    ]
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class AdminRoutingModule { }
