import { Component, OnDestroy, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { ConfigReseauSocialService } from './service/config-reseau-social.service';
import { AlertMessageService } from 'src/app/common/modal/alert-message/service/alert-message.service';

@Component({
  selector: 'app-config-resau-social',
  templateUrl: './config-resau-social.page.html',
  styleUrls: ['./config-resau-social.page.scss'],
})
export class ConfigResauSocialPage implements OnInit,OnDestroy {
  public whatsapp=new FormGroup({
    facebook: new FormControl('',Validators.required),
    instagram: new FormControl('',Validators.required),
    snapchat: new FormControl('',Validators.required),
    numero: new FormControl<number>(0,Validators.required),
    homemessage: new FormControl('',Validators.required),
    shopmessage: new FormControl('',Validators.required),
    id: new FormControl(''),

  });
  constructor(private configReseauSocial:ConfigReseauSocialService,private modalMessageService:AlertMessageService) { }

  ngOnInit() {
    this.loadData();
  }
  ngOnDestroy(): void {
    
  }
  saveData(){
    this.configReseauSocial.updateData(this.whatsapp.value).subscribe(
      res=>{console.log(res.message);
      },
      error=>{this.modalMessageService.show(error.error);console.log(error);}
    )
  }
  loadData(){
    this.configReseauSocial.getConfig().subscribe(
      res=>{console.log(res);
        this.whatsapp.get('facebook')?.setValue(res.facebook);
        this.whatsapp.get('homemessage')?.setValue(res.homemessage)
        this.whatsapp.get('instagram')?.setValue(res.instagram)
        this.whatsapp.get('numero')?.setValue(parseInt(res.numero))
        this.whatsapp.get('shopmessage')?.setValue(res.shopmessage)
        this.whatsapp.get('snapchat')?.setValue(res.snapchat)
        this.whatsapp.get('id')?.setValue(res.id.toString())

      },
      error=>{this.modalMessageService.show(error.error);console.log(error);}

    )
  }
  handleRefresh(event:any) {
    this.loadData();
    setTimeout(() => {
      event.target.complete();
    }, 2000);
  }
}
