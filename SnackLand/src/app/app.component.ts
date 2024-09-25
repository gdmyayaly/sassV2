import { Component } from '@angular/core';
import { LoadderService } from './commons/loadder/service/loadder.service';
import { InfosClientService } from './data/infos-client/service/infos-client.service';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent {
  title = 'SnackLand';
  public isLoadingStatus:boolean=false;
  constructor(public loaderService:LoadderService){
    this.loaderService.isLoading().subscribe((value) => {this.isLoadingStatus=value;});
  }
  ngOnInit(): void {
    // setTimeout(() => {
      // this.loaderService.isLoading().subscribe((value) => {
      //   this.isLoadingStatus=value;
      // });
    // }, 0);

  }
}
