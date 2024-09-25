import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-detail-custom-page-web',
  templateUrl: './detail-custom-page-web.component.html',
  styleUrls: ['./detail-custom-page-web.component.scss'],
})
export class DetailCustomPageWebComponent  implements OnInit {

  constructor() { }

  ngOnInit() {}
  handleRefresh(event:any) {
    // this.loadData();
    setTimeout(() => {
      event.target.complete();
    }, 2000);
  }
}
