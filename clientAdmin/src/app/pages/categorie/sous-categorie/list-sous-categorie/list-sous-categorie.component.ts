import { Component, OnInit } from '@angular/core';
import { CategorieService } from '../../service/categorie.service';
import { AlertMessageService } from 'src/app/common/modal/alert-message/service/alert-message.service';
import { CategoryModel } from '../../model/category.model';
import { PreviewMediaService } from 'src/app/common/modal/preview-media/service/preview-media.service';
import { ActivatedRoute } from '@angular/router';

@Component({
  selector: 'app-list-sous-categorie',
  templateUrl: './list-sous-categorie.component.html',
  styleUrls: ['./list-sous-categorie.component.scss'],
})
export class ListSousCategorieComponent  implements OnInit {
  public listCategorie:CategoryModel[]=[];
  public mediaSelected?:CategoryModel;
  public alertButtons = [
    {
      text: 'Cancel',
      role: 'cancel',
      handler: () => {
        console.log('Alert canceled');
      },
    },
    {
      text: 'OK',
      role: 'confirm',
      handler: () => {
        console.log('Alert confirmed');
      },
    },
  ];
  public showOpenAlert:boolean=false;
  public idSelected:string="";
  constructor(private activatedRoute:ActivatedRoute,private categorieService:CategorieService,private modalMessageService:AlertMessageService,private showMediaService:PreviewMediaService) { }

  ngOnInit() {
    this.idSelected = this.activatedRoute.snapshot.paramMap.get('sousCat') ?? "";
   // this.loadData();
  }
  loadData(){
    // this.categorieService.detailSousCategorie(this.idSelected).subscribe(
    //   res=>{this.listCategorie=res;console.log(res);
    //   },
    //   error=>{this.modalMessageService.show(error.error);console.log(error);}

    // )
  }
  handleRefresh(event:any) {
    this.loadData();
    setTimeout(() => {
      event.target.complete();
    }, 2000);
  }
  
  removeCategorie(data:CategoryModel){
    this.showOpenAlert=true;
    this.mediaSelected=data;
  }
  setResult(ev:any) {
    this.showOpenAlert=false;
    console.log(`Dismissed with role: ${ev.detail.role}`);
    if (ev.detail.role=='confirm') {
      this.categorieService.removeCategorie(this.mediaSelected).subscribe(
        res=>{      this.modalMessageService.show(res);this.ngOnInit();
        },
        error=>{this.modalMessageService.show(error.error);console.log(error);
        }
      )
    }
  }
  previewImg(item:CategoryModel){
    this.showMediaService.show({type:"image",url:item.image??""});
  }
}
