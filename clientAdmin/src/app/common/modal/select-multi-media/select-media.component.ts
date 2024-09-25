import { Component, OnInit } from '@angular/core';
import { SelecMultitMediaService } from './service/select-media.service';
import { GalerieModel } from 'src/app/pages/galerie/model/galerie.model';

@Component({
  selector: 'app-select-multi-media',
  templateUrl: './select-media.component.html',
  styleUrls: ['./select-media.component.scss'],
})
export class SelectMultiMediaComponent  implements OnInit {
  public imgSelected:GalerieModel[]=[];
  public mutipleSelection:boolean=false;
  constructor(public selectedMediaService:SelecMultitMediaService) {
    this.selectedMediaService.getMultipleSelection().subscribe(val=>{this.mutipleSelection=val});
   }

  ngOnInit() {}
  closeAlert(){
    this.selectedMediaService.hide();
  }
  selected(data:GalerieModel){
    if (this.mutipleSelection) {
      if (this.imgSelected.find(val=> val.id==data.id)) {
        let index = this.imgSelected.findIndex(val=> val.id==data.id)
        this.imgSelected.splice(index,1);
      }
      else{
        this.imgSelected.push(data);
      }
    } else {
      this.imgSelected=[];
      this.imgSelected.push(data);
    }
    
  }
  isSelected(data:GalerieModel):boolean{
    let index = this.imgSelected.findIndex(val=> val.id==data.id)
    if (index > -1) {
      return true;
    } else {
      return false;
    }
  }
  submitSelection(){
    this.selectedMediaService.submitMediaSelected(this.imgSelected);
    this.closeAlert();
  }
}
