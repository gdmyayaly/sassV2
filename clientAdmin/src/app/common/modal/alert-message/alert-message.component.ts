import { Component, OnDestroy, OnInit } from '@angular/core';
import { AlertMessageService } from './service/alert-message.service';

@Component({
  selector: 'app-alert-message',
  templateUrl: './alert-message.component.html',
  styleUrls: ['./alert-message.component.scss'],
})
export class AlertMessageComponent  implements OnInit,OnDestroy {

  public message:Array<any>=[];
  alertButtons = ['Fermer'];
  
  statusOpen:boolean=false;
  constructor(private modalService:AlertMessageService) { 
    this.modalService.getMessage().subscribe(val=>{this.message=val});
    this.modalService.statusAlert().subscribe(val=>{this.statusOpen=val});
  }

  ngOnInit() {
    // this.statusOpen=true;
  }
  ngOnDestroy(): void {
    // this.statusOpen=false;

  }
  closeAlert(){
    // this.statusOpen=false;
    // console.log(`Dismissed with role: ${ev.detail.role}`);

    this.modalService.hide();
  }
  setOpen() {
    this.statusOpen = false;
    this.modalService.hide();
  }

}
