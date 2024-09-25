import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { AuthComponent } from './auth/auth.component';
import { AuthGuardService } from './auth/guard/auth-guard.service';
import { HomeComponent } from './home/home.component';

const routes: Routes = [
  {path:'login',component:AuthComponent},
  // {path:'home',component:HomeComponent,canActivate: [AuthGuardService]},
  {
    path:'admin',
    loadChildren: () => import('./admin/admin.module').then( m => m.AdminModule)
  },
  {
    path:'client',
    loadChildren: () => import('./utilisateur/utilisateur.module').then( m => m.UtilisateurModule)
  },
  { path: '',   redirectTo: '/login', pathMatch: 'full' }, // redirect to `login`
  // {
  //   path: '**',
  //   component: AuthComponent
  // }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
