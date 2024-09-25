import { Component, OnInit } from '@angular/core';
import { PageWebService } from '../../service/page-web.service';

@Component({
  selector: 'app-list-custom-page-web',
  templateUrl: './list-custom-page-web.component.html',
  styleUrls: ['./list-custom-page-web.component.scss'],
})
export class ListCustomPageWebComponent  implements OnInit {

  constructor(private pageWebService:PageWebService) { }

  ngOnInit() {
    this.loadData();
  }
  handleRefresh(event:any) {
    this.loadData();
    setTimeout(() => {
      event.target.complete();
    }, 2000);
  }
  loadData(){
    // this.pageWebService.loadAllModulesClient().subscribe(
    //   res=>{
    //     console.log(res);
    //   },
    //   error=>{
    //     console.error(error);
    //   }
    // )
  }
}
