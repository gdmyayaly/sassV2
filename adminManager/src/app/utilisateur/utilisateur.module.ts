import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { UtilisateurRoutingModule } from './utilisateur-routing.module';
import { HomeUtilisateurComponent } from './pages/home-utilisateur/home-utilisateur.component';
import { UtilisateurComponent } from './utilisateur.component';
import { BreadcrumbsComponent } from './layout/breadcrumbs/breadcrumbs.component';
import { MenuClientComponent } from './layout/menu-client/menu-client.component';
import { TopBarClientComponent } from './layout/top-bar-client/top-bar-client.component';
import { ListCategoriesComponent } from './pages/categories/list-categories/list-categories.component';
import { AddCategoriesComponent } from './pages/categories/add-categories/add-categories.component';
import { DetailCategoriesComponent } from './pages/categories/detail-categories/detail-categories.component';
import { AddSousCategoriesComponent } from './pages/sousCategories/add-sous-categories/add-sous-categories.component';
import { DetailSousCategoriesComponent } from './pages/sousCategories/detail-sous-categories/detail-sous-categories.component';
import { ListSousCategoriesComponent } from './pages/sousCategories/list-sous-categories/list-sous-categories.component';
import { ListProduitComponent } from './pages/produits/list-produit/list-produit.component';
import { AddProduitComponent } from './pages/produits/add-produit/add-produit.component';
import { DetailProduitComponent } from './pages/produits/detail-produit/detail-produit.component';
import { ListGalleriesComponent } from './pages/galleries/list-galleries/list-galleries.component';
import { AddGalleriesComponent } from './pages/galleries/add-galleries/add-galleries.component';
import { DetailGalleriesComponent } from './pages/galleries/detail-galleries/detail-galleries.component';
import { ReseauxSociauxComponent } from './pages/reseaux-sociaux/reseaux-sociaux.component';


@NgModule({
  declarations: [
    HomeUtilisateurComponent,
    UtilisateurComponent,
    BreadcrumbsComponent,
    MenuClientComponent,
    TopBarClientComponent,
    ListCategoriesComponent,
    AddCategoriesComponent,
    DetailCategoriesComponent,
    AddSousCategoriesComponent,
    DetailSousCategoriesComponent,
    ListSousCategoriesComponent,
    ListProduitComponent,
    AddProduitComponent,
    DetailProduitComponent,
    ListGalleriesComponent,
    AddGalleriesComponent,
    DetailGalleriesComponent,
    ReseauxSociauxComponent
  ],
  imports: [
    CommonModule,
    UtilisateurRoutingModule
  ]
})
export class UtilisateurModule { }
