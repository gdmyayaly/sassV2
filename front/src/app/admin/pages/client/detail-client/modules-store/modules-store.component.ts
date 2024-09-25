import { Component, Input, OnInit } from '@angular/core';
import { SectionWebsiteService } from '../../../section/service/section-website.service';
import { SectionModel } from '../../../section/models/section.model';
import { SectionClientModel } from '../../../section/models/sectionClient.model';
import { ActivatedRoute } from '@angular/router';
import { BreadcrumbsModel } from 'src/app/admin/layout/breadcrumbs/breadcrumbs.model';

@Component({
  selector: 'app-modules-store',
  templateUrl: './modules-store.component.html',
  styleUrls: ['./modules-store.component.css']
})
export class ModulesStoreComponent implements OnInit{
  public allSection:SectionModel[]=[];
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
   this.loadAllSection();
   
  }
  loadAllSection(){
    this.sectionWebsiteService.getAllSection().subscribe(
      res=>{console.log(res);this.allSection=res;
        for (let index = 0; index < this.allSection.length; index++) {
          this.allSection[index].isClient=false;
        }
        this.loadAllSectionClient();
        
      },
      error=>{console.error(error);
      }
    )
  }
  loadAllSectionClient(){
    this.sectionWebsiteService.getClientSection(this.idClient).subscribe(
      res=>{console.log(res);this.clientSection=res;
        for (let index = 0; index < this.clientSection.length; index++) {
          let newIndex=this.allSection.findIndex(r=>r.name==this.clientSection[index].section.name);          
          if (newIndex>=0) {
            this.allSection[newIndex].isClient=true;
          }
        }
        
      },
      error=>{console.error(error);
      }
    )
  }
  assigneModule(id:number){
    console.log(id);
    this.sectionWebsiteService.attributeClientSection(this.idClient,id.toString()).subscribe(
      res=>{console.log(res);
        this.loadAllSectionClient();
      },
      error=>{console.error(error);
      }
    )
  }
  
}
