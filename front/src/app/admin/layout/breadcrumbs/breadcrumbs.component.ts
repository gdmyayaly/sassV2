import { Component, Input } from '@angular/core';
import { BreadcrumbsModel } from './breadcrumbs.model';

@Component({
  selector: 'app-breadcrumbs',
  templateUrl: './breadcrumbs.component.html',
  styleUrls: ['./breadcrumbs.component.css']
})
export class BreadcrumbsComponent {
  @Input() dataList:Array<BreadcrumbsModel>=[
    {url:"/",name:"Home"}
  ];
  @Input() current:string="Actuel";
}
