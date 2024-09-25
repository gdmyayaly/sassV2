import { NgModule } from '@angular/core';
import { PreloadAllModules, RouterModule, Routes } from '@angular/router';
import { AuthGuardService } from './login/guard/auth-guard.service';

const routes: Routes = [
  // {
  //   path: 'home',
  //   loadChildren: () => import('./home/home.module').then( m => m.HomePageModule)
  // },
  {
    path:'login',
    loadChildren: () => import('./login/login.module').then( m => m.LoginPageModule)
  },

  {
    path: 'accueil',
    loadChildren: () => import('./pages/accueil/accueil.module').then( m => m.AccueilPageModule),
    canActivate: [AuthGuardService]
  },
  {
    path: 'galerie',
    loadChildren: () => import('./pages/galerie/list-galerie/list-galerie.module').then( m => m.ListGaleriePageModule),
    canActivate: [AuthGuardService]
  },
  {
    path: 'galerie/add',
    loadChildren: () => import('./pages/galerie/add-galerie/add-galerie.module').then( m => m.AddGaleriePageModule),
    canActivate: [AuthGuardService]

  },
  {
    path: '',
    redirectTo: 'login',
    pathMatch: 'full'
  },
  {
    path: 'resau-social',
    loadChildren: () => import('./pages/config-resau-social/config-resau-social.module').then( m => m.ConfigResauSocialPageModule),
    canActivate: [AuthGuardService]
  },
  {
    path: 'categorie',
    loadChildren: () => import('./pages/categorie/categorie.module').then( m => m.CategoriePageModule),
    canActivate: [AuthGuardService]
  },
  {
    path: 'produit',
    loadChildren: () => import('./pages/product/product.module').then( m => m.ProductPageModule),
    canActivate: [AuthGuardService]
  },
  {
    path: 'config-website',
    loadChildren: () => import('./pages/config-website/config-website.module').then( m => m.ConfigWebsitePageModule),
    canActivate: [AuthGuardService]
  },
 
];

@NgModule({
  imports: [
    RouterModule.forRoot(routes, { preloadingStrategy: PreloadAllModules })
  ],
  exports: [RouterModule]
})
export class AppRoutingModule { }
