import { Component } from '@angular/core';
import { MenuModel } from './model/menu';
import { LoadderService } from './modules/loadder/services/services.service';
import { AuthService } from './login/services/auth.service';
import { UserInformationService } from './common/service/user-information.service';
import { Utilisateur } from './common/model/utilisateur';
import { AlertMessageService } from './common/modal/alert-message/service/alert-message.service';
import { PreviewMediaService } from './common/modal/preview-media/service/preview-media.service';
import { SelectMediaService } from './common/modal/select-media/service/select-media.service';
import { SelecMultitMediaService } from './common/modal/select-multi-media/service/select-media.service';
type UtilisateurNullable = Utilisateur | null;

@Component({
  selector: 'app-root',
  templateUrl: 'app.component.html',
  styleUrls: ['app.component.scss'],
})
export class AppComponent {
  public link:MenuModel[]=[
    {title:'Accueil',icon:'pie-chart-outline',url:'accueil'},
    {title:'Categories',icon:'grid-outline',url:'categorie'},
    {title:'Produits',icon:'cart-outline',url:'produit'},
    {title:'Gallerie',icon:'images-outline',url:'galerie'},
    {title:'Page Web',icon:'globe-outline',url:'config-website'},
    // {title:'Modules',icon:'apps-outline',url:'formulaire'},
    {title:'Resaux Sociaux',icon:'logo-whatsapp',url:'resau-social'},
    // {title:'Utilisateur',icon:'person-add-outline',url:'utilisateur'},
  ];
  public isLoadingStatus:boolean=false;
  public isAuth:boolean=false;
  public userInfos?:UtilisateurNullable;
  public showModalMessage:boolean=false;
  public showModalPreviewMedia:boolean=false;
  public showModalMediaSelection:boolean=false;
  public showModalMediaMultiSelection:boolean=false;

  constructor(private admin:UserInformationService,public loaderService:LoadderService,private authService:AuthService,private modalMessageService:AlertMessageService,private previewMedia:PreviewMediaService,private SelectMediaService:SelectMediaService,private SelectMultiMediaService:SelecMultitMediaService) {
    this.loaderService.isLoading().subscribe(val=>{this.isLoadingStatus=val});
    this.authService.isAuthenticated().subscribe(val=>{this.isAuth=val});
    this.admin.getUserData().subscribe(val=>{this.userInfos=val});
    this.modalMessageService.statusAlert().subscribe(val=>{this.showModalMessage=val});
    this.previewMedia.statusAlert().subscribe(val=>{this.showModalPreviewMedia=val});
    this.SelectMediaService.statusAlert().subscribe(val=>{this.showModalMediaSelection=val});
    this.SelectMultiMediaService.statusAlert().subscribe(val=>{this.showModalMediaMultiSelection=val});
    console.log("He "+this.isAuth);
    
  }
}
