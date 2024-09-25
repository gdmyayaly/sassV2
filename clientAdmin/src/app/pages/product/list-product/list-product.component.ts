import { Component, OnDestroy, OnInit } from '@angular/core';
import { ProductService } from '../service/product.service';
import { ProductModel } from '../model/product.model';
import { AlertMessageService } from 'src/app/common/modal/alert-message/service/alert-message.service';
import { PreviewMediaService } from 'src/app/common/modal/preview-media/service/preview-media.service';

@Component({
  selector: 'app-list-product',
  templateUrl: './list-product.component.html',
  styleUrls: ['./list-product.component.scss'],
})
export class ListProductComponent  implements OnInit,OnDestroy {
  public listProduct:ProductModel[]=[];
  public selectedProduct?:ProductModel;
  public alertButtons = [
    {
      text: 'Annuler',
      role: 'cancel',
      handler: () => {
        console.log('Alert canceled');
      },
    },
    {
      text: 'Valider',
      role: 'confirm',
      handler: () => {
        console.log('Alert confirmed');
      },
    },
  ];
  public showOpenAlert:boolean=false;

  constructor(private productService:ProductService,private modalMessageService:AlertMessageService,private showMediaService:PreviewMediaService) { }

  ngOnInit() {
    this.loadData();
  }
  ngOnDestroy(): void {
    this.listProduct=[]
    this.showOpenAlert=false;
    this.selectedProduct=undefined;
  }

  loadData(){
    this.productService.listMedia().subscribe(
      res=>{console.log(res);
        this.listProduct=res;
      },
      error=>{console.log(error);
      }
    )
  }
  handleRefresh(event:any) {
    this.loadData();
    setTimeout(() => {
      event.target.complete();
    }, 2000);
  }
  removeProduct(item:ProductModel){
    this.selectedProduct=item;
    this.showOpenAlert=true;
  }
  setResult(ev:any) {
    this.showOpenAlert=false;
    console.log(`Dismissed with role: ${ev.detail.role}`);
    if (ev.detail.role=='confirm') {
      this.productService.removeMedia(this.selectedProduct).subscribe(
        res=>{this.modalMessageService.show(res);
          this.ngOnInit();
        },
        error=>{this.modalMessageService.show(error.error);console.log(error);}
      )
      // this.categorieService.removeCategorie(this.mediaSelected).subscribe(
      //   res=>{      this.modalMessageService.show(res);this.ngOnInit();
      //   },
      //   error=>{this.modalMessageService.show(error.error);console.log(error);
      //   }
      // )
    }
  }
  previewImg(item:ProductModel){
    this.showMediaService.show({type:"image",url:item.image});
  }
  previewOtherImg(item:string){
    this.showMediaService.show({type:"image",url:item});
  }
  getTypeMediaFromURL(url:any) {
    const extension = url.split('.').pop().toLowerCase();
  
    switch (extension) {
      case 'jpg':
      case 'jpeg':
      case 'png':
      case 'gif':
        return 'image';
      case 'mp4':
      case 'webm':
      case 'avi':
      case 'mov':
        return 'video';
      default:
        return 'unknown';
    }
  }
}
