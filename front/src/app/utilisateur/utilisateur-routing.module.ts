import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { HomeUtilisateurComponent } from './pages/home-utilisateur/home-utilisateur.component';
import { UtilisateurComponent } from './utilisateur.component';
import { ListCategoriesComponent } from './pages/categories/list-categories/list-categories.component';
import { ListProduitComponent } from './pages/produits/list-produit/list-produit.component';
import { ListGalleriesComponent } from './pages/galleries/list-galleries/list-galleries.component';

const routes: Routes = [
  {
    path: '',
    component: UtilisateurComponent,children:[
      {path: 'dashboard', component: HomeUtilisateurComponent},
      {path: 'categorie', component: ListCategoriesComponent},
      {path: 'produit', component: ListProduitComponent},
      {path: 'galerie', component: ListGalleriesComponent},
    ]
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class UtilisateurRoutingModule { }
