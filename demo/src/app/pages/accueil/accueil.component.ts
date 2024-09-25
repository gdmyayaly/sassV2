import { Component } from '@angular/core';

@Component({
  selector: 'app-accueil',
  templateUrl: './accueil.component.html',
  styleUrls: ['./accueil.component.scss']
})
export class AccueilComponent {
  public listCat:string[]=["Tous","Catégorie 1","Catégorie 2","Catégorie 3","Catégorie 4","Catégorie 5"];
  public selectCat:string="Tous";

  changeCatSelected(name:string){
    this.selectCat=name;
  }
}
