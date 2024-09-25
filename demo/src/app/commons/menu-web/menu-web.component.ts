import { Component } from '@angular/core';

@Component({
  selector: 'app-menu-web',
  templateUrl: './menu-web.component.html',
  styleUrls: ['./menu-web.component.scss']
})
export class MenuWebComponent {
  public listCat:string[]=["Catégorie 1","Catégorie 2","Catégorie 3","Catégorie 4","Catégorie 5"]
}
