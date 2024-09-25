import { AfterViewInit, Component, OnInit } from '@angular/core';
import * as Aos from 'aos';

@Component({
  selector: 'app-boutique',
  templateUrl: './boutique.component.html',
  styleUrls: ['./boutique.component.scss']
})
export class BoutiqueComponent implements OnInit,AfterViewInit{
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
}
