import { Component, OnInit } from '@angular/core';
import { VariationProductService } from '../service/vation-product.service';
import { VariationModel } from '../model/variation.model';
import { AlertMessageService } from 'src/app/common/modal/alert-message/service/alert-message.service';

@Component({
  selector: 'app-list-vation-product',
  templateUrl: './list-vation-product.component.html',
  styleUrls: ['./list-vation-product.component.scss'],
})
export class ListVariationProductComponent  implements OnInit {
  public listVariation:VariationModel[]=[];
  private mediaSelected?:VariationModel;
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
  constructor(private variationService:VariationProductService,private modalMessageService:AlertMessageService) { }

  ngOnInit() {
    this.loadData();
  }
  loadData(){
    this.variationService.listVariation().subscribe(
      res=>{console.log(res);
        this.listVariation=res;
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
  removeVariation(data:VariationModel){
    this.showOpenAlert=true;
    this.mediaSelected=data;
  }
  setResult(ev:any) {
    this.showOpenAlert=false;
    console.log(`Dismissed with role: ${ev.detail.role}`);
    if (ev.detail.role=='confirm') {
      this.variationService.removeVariation(this.mediaSelected).subscribe(
        res=>{      this.modalMessageService.show(res);this.ngOnInit();
        },
        error=>{this.modalMessageService.show(error.error);console.log(error);
        }
      )
    }
  }
}
