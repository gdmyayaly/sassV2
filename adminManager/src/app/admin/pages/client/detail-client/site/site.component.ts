import { Component, Input, OnInit } from '@angular/core';
import { ClientService } from '../../service/client.service';
import { ClientModel } from '../../models/client.model';

@Component({
  selector: 'app-site',
  templateUrl: './site.component.html',
  styleUrls: ['./site.component.css']
})
export class SiteComponent implements OnInit{
  public clientInfos!:ClientModel;
  @Input() idClient: string="";

  constructor(private clientService:ClientService){}
  ngOnInit(): void {
    this.loadClientInfos();
  }
  loadClientInfos(){
    console.log(this.idClient);
    
    this.clientService.getOneClient(this.idClient).subscribe(
      res=>{console.log(res);this.clientInfos=res;
      },
      error=>{console.error(error);
      }
    )
  }
}
