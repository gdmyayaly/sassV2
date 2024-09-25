import { AfterContentInit, AfterViewInit, Component, OnInit } from '@angular/core';
import * as Aos from 'aos';


@Component({
  selector: 'app-accueil',
  templateUrl: './accueil.component.html',
  styleUrls: ['./accueil.component.scss']
})
export class AccueilComponent implements OnInit,AfterViewInit{
  public listCat:string[]=["Tous","Catégorie 1","Catégorie 2","Catégorie 3","Catégorie 4","Catégorie 5"];
  public selectCat:string="Tous";
  ngOnInit(): void {
    Aos.init({
      duration: 1500,
      delay: 50,
    })
  }
  ngAfterViewInit(): void {
    setTimeout(() => {
      Aos.refresh()
    }, 500)
  }
  changeCatSelected(name:string){
    this.selectCat=name;
  }
}
