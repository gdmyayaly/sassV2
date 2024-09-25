import { Component, OnInit } from '@angular/core';
import { PageWebService } from '../../service/page-web.service';
import { ActivatedRoute } from '@angular/router';
import { SectionTypeDefaultModel } from '../../models/sectionTypeDefault.model';
import { ModuleClientModel } from '../../models/moduleClient.model';

@Component({
  selector: 'app-list-default-section',
  templateUrl: './list-default-section.component.html',
  styleUrls: ['./list-default-section.component.scss'],
})
export class ListDefaultSectionComponent  implements OnInit {
  public idSectionType:string="";
  public detailSectionType:ModuleClientModel[]=[];
constructor(private pageWebService:PageWebService,private activatedRoute:ActivatedRoute) { }

  ngOnInit() {
    this.idSectionType = this.activatedRoute.snapshot.paramMap.get('id') ?? "";
    this.loadData();
  }
  handleRefresh(event:any) {
    this.loadData();
    setTimeout(() => {
      event.target.complete();
    }, 2000);
  }
  loadData(){
    this.pageWebService.loadAllSectionTypeDefaultDetail(this.idSectionType).subscribe(
      res=>{
        console.log(res);
        this.detailSectionType=res;
      },
      error=>{
        console.error(error)
      }
    )
  }
}
