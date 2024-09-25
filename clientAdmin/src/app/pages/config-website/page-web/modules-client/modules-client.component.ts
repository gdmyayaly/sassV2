import { Component, OnInit } from '@angular/core';
import { PageWebService } from '../service/page-web.service';
import { ModuleClientModel } from '../models/moduleClient.model';

@Component({
  selector: 'app-modules-client',
  templateUrl: './modules-client.component.html',
  styleUrls: ['./modules-client.component.scss'],
})
export class ModulesClientComponent  implements OnInit {

  public clientModules:ModuleClientModel[]=[];
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
    this.pageWebService.loadAllModulesClient().subscribe(
      res=>{
        console.log(res);
        this.clientModules=res;
      },
      error=>{
        console.error(error);
      }
    )
  }
}
