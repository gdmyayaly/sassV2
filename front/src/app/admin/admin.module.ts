import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { AdminRoutingModule } from './admin-routing.module';
import { HomeAdminComponent } from './pages/home-admin/home-admin.component';
import { AdminComponent } from './admin.component';
import { MenuAdminComponent } from './layout/menu-admin/menu-admin.component';
import { TopBarAdminComponent } from './layout/top-bar-admin/top-bar-admin.component';
import { ListClientComponent } from './pages/client/list-client/list-client.component';
import { AddClientComponent } from './pages/client/add-client/add-client.component';
import { DetailClientComponent } from './pages/client/detail-client/detail-client.component';
import { ReactiveFormsModule } from '@angular/forms';
import { ListSectionComponent } from './pages/section/list-section/list-section.component';
import { AddSectionComponent } from './pages/section/add-section/add-section.component';
import { DetailSectionComponent } from './pages/section/detail-section/detail-section.component';
import { PagesWebComponent } from './pages/client/detail-client/pages-web/pages-web.component';
import { ModulesClientComponent } from './pages/client/detail-client/modules-client/modules-client.component';
import { ModulesStoreComponent } from './pages/client/detail-client/modules-store/modules-store.component';
import { SiteComponent } from './pages/client/detail-client/site/site.component';
import { ListSectionTypeComponent } from './pages/section-type/list-section-type/list-section-type.component';
import { AddSectionTypeComponent } from './pages/section-type/add-section-type/add-section-type.component';
import { BreadcrumbsComponent } from './layout/breadcrumbs/breadcrumbs.component';


@NgModule({
  declarations: [
    AdminComponent,
    HomeAdminComponent,
    MenuAdminComponent,
    TopBarAdminComponent,
    ListClientComponent,
    AddClientComponent,
    DetailClientComponent,
    ListSectionComponent,
    AddSectionComponent,
    DetailSectionComponent,
    PagesWebComponent,
    ModulesClientComponent,
    ModulesStoreComponent,
    SiteComponent,
    ListSectionTypeComponent,
    AddSectionTypeComponent,
    BreadcrumbsComponent
  ],
  imports: [
    CommonModule,
    ReactiveFormsModule,
    AdminRoutingModule
  ],
  // schemas: [CUSTOM_ELEMENTS_SCHEMA],
})
export class AdminModule { }
