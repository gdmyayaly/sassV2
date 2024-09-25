import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { BreadcrumbsModel } from 'src/app/admin/layout/breadcrumbs/breadcrumbs.model';

@Component({
  selector: 'app-detail-client',
  templateUrl: './detail-client.component.html',
  styleUrls: ['./detail-client.component.css']
})
export class DetailClientComponent implements OnInit{

  public idClient:string="";
  public listDetailClient:Array<{icon:string,name:string,baseUrl:string}>=[
    {icon:"assets/icon/pageWeb.svg",name:"Page Web",baseUrl:"/admin/client/detail/page-web"},
    {icon:"assets/icon/modules.svg",name:"Mes Modules",baseUrl:"/admin/client/detail/modules"},
    {icon:"assets/icon/modulesSotre.svg",name:"Modules Store",baseUrl:"/admin/client/detail/modules-store"},
    // {icon:"assets/icon/domain.svg",name:"Sites",baseUrl:"/admin/client/detail/website"},
  ]
  public breadcrumbsList:Array<BreadcrumbsModel>=[
    {url:"/admin",name:"Dashboard"},
    {url:"/admin/client",name:"Client"}
  ];

  constructor(private Activeroute:ActivatedRoute){}
  ngOnInit(): void {
    this.idClient = this.Activeroute.snapshot.paramMap.get('id') ?? "";
  }
  
}
