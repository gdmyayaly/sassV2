import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { SectionWebsiteService } from '../../../section/service/section-website.service';
import { BreadcrumbsModel } from 'src/app/admin/layout/breadcrumbs/breadcrumbs.model';

@Component({
  selector: 'app-pages-web',
  templateUrl: './pages-web.component.html',
  styleUrls: ['./pages-web.component.css']
})
export class PagesWebComponent implements OnInit{
  public idClient:string="";
  public breadcrumbsList:Array<BreadcrumbsModel>=[
    {url:"/admin",name:"Dashboard"},
    {url:"/admin/client",name:"Client"}
  ];
  constructor(private Activeroute:ActivatedRoute,public sectionWebsiteService:SectionWebsiteService){}
  ngOnInit(): void {
    this.idClient = this.Activeroute.snapshot.paramMap.get('id') ?? "";
    this.breadcrumbsList.push({url:"/admin/client/detail/"+this.idClient,name:"Détail"})
  }

}
