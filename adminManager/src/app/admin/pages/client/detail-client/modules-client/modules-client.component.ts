import { Component, Input, OnInit } from '@angular/core';
import { SectionWebsiteService } from '../../../section/service/section-website.service';
import { SectionClientModel } from '../../../section/models/sectionClient.model';
import { ActivatedRoute } from '@angular/router';
import { BreadcrumbsModel } from 'src/app/admin/layout/breadcrumbs/breadcrumbs.model';

@Component({
  selector: 'app-modules-client',
  templateUrl: './modules-client.component.html',
  styleUrls: ['./modules-client.component.css']
})
export class ModulesClientComponent implements OnInit{
  public clientSection:SectionClientModel[]=[];
  public idClient:string="";
  public breadcrumbsList:Array<BreadcrumbsModel>=[
    {url:"/admin",name:"Dashboard"},
    {url:"/admin/client",name:"Client"}
  ];
  constructor(public sectionWebsiteService:SectionWebsiteService,private Activeroute:ActivatedRoute){}
  ngOnInit(): void {
    this.idClient = this.Activeroute.snapshot.paramMap.get('id') ?? "";
    this.breadcrumbsList.push({url:"/admin/client/detail/"+this.idClient,name:"Détail"})
   this.loadAllSectionClient();
  }
  loadAllSectionClient(){
    this.sectionWebsiteService.getClientSection(this.idClient).subscribe(
      res=>{console.log(res);this.clientSection=res;
      },
      error=>{console.error(error);
      }
    )
  }
}
