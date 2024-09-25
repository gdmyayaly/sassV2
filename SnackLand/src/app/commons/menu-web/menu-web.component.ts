import { Component } from '@angular/core';
import { SocialMediaModel } from 'src/app/data/infos-client/model/social-media.model';
import { InfosClientService } from 'src/app/data/infos-client/service/infos-client.service';

@Component({
  selector: 'app-menu-web',
  templateUrl: './menu-web.component.html',
  styleUrls: ['./menu-web.component.scss']
})
export class MenuWebComponent {
  // public listCat:string[]=["Catégorie 1","Catégorie 2","Catégorie 3","Catégorie 4","Catégorie 5"];
  public socialData?:SocialMediaModel;
  constructor(private infosClientService:InfosClientService){
    this.infosClientService.getData().subscribe(val=>{this.socialData=val});
    if (this.socialData?.id==undefined) {
      this.infosClientService.getInfosReseau();
    }
  }
}
