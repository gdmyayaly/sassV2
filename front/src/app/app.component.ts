import { AfterContentInit, Component, OnInit } from '@angular/core';
import { LoadderService } from './modules/loadder/services/services.service';
import { initFlowbite } from 'flowbite';
import { BehaviorSubject } from 'rxjs';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent implements OnInit,AfterContentInit{
  public isLoadingStatus:boolean=false;

  constructor(private loaderService:LoadderService){}
  ngOnInit(): void {
    initFlowbite();
  }
  ngAfterContentInit(){
   this.loaderService.isLoading().subscribe(val=>{this.isLoadingStatus=val});
  }
}
