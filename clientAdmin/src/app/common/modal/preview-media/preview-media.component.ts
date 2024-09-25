import { Component, OnInit } from '@angular/core';
import { PreviewMediaService } from './service/preview-media.service';

@Component({
  selector: 'app-preview-media',
  templateUrl: './preview-media.component.html',
  styleUrls: ['./preview-media.component.scss'],
})
export class PreviewMediaComponent  implements OnInit {

  public image:{type:string,url:string}={type:"",url:""};
  alertButtons = ['Fermer'];
  statusOpen:boolean=false;
  constructor(private modalService:PreviewMediaService) { 
    this.modalService.getImage().subscribe(val=>{this.image=val});
    this.modalService.statusAlert().subscribe(val=>{this.statusOpen=val});
  }

  ngOnInit() {}
  closeAlert(){
    this.modalService.hide();
  }
}
