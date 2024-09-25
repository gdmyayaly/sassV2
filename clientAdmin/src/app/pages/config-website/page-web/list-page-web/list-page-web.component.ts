import { Component, OnInit } from '@angular/core';
import { PageWebService } from '../service/page-web.service';
import { SectionTypeDefaultModel } from '../models/sectionTypeDefault.model';

@Component({
  selector: 'app-list-page-web',
  templateUrl: './list-page-web.component.html',
  styleUrls: ['./list-page-web.component.scss'],
})
export class ListPageWebComponent  implements OnInit {

  public listConfigClient:Array<{name:string,img:string}>=[
    {name:"Menu",img:"assets/img/menu.png"},
    {name:"CardProduct",img:"assets/img/cardProduct.png"},
    {name:"Accueil",img:"assets/img/cardProduct.png"},
    {name:"Boutique",img:"assets/img/boutique.png"},
    {name:"Contact",img:"assets/img/categorie.svg"},
    {name:"Footer",img:"assets/img/categorie.svg"},
    // {name:"Page Web",img:"assets/img/website.svg",url:"/config-website/website/custom",description:"Créer et personaliser les différents pages de votre site web"},
    // {name:"Mes Modules",img:"assets/img/module.svg",url:"/config-website/website/module",description:"Créer et personaliser les différents pages de votre site web"},
  ]
  public listTypeSectionDefault:SectionTypeDefaultModel[]=[];
  constructor(private pageWebService:PageWebService) { }

  ngOnInit() {
    this.loadData();
  }
  handleRefresh(event:any) {
    this.loadData();
    setTimeout(() => {
      event.target.complete();
    }, 2000);
  }
  loadData(){
    this.pageWebService.loadAllSectionTypeDefault().subscribe(
      res=>{
        console.log(res);
        this.listTypeSectionDefault=res;
      },
      error=>{
        console.error(error);
      }
    )
  }
  getImg(name:string):string{
    return this.listConfigClient.find(r=>r.name==name)?.img ?? ""
  }

}
