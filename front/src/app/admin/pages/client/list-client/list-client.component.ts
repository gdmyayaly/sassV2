import { Component, OnInit } from '@angular/core';
import { ClientService } from '../service/client.service';
import { ClientModel } from '../models/client.model';
import { environment } from 'src/environments/environment';
@Component({
  selector: 'app-list-client',
  templateUrl: './list-client.component.html',
  styleUrls: ['./list-client.component.css']
})
export class ListClientComponent implements OnInit{
  public clientList:ClientModel[]=[];
  public websiteUrl=environment.urlApi;
  constructor(private clientService:ClientService){}
  ngOnInit(): void {
    this.loadClient();
  }

  loadClient(){
    this.clientService.getClient().subscribe(
      res=>{console.log(res);
        this.clientList=res;
      },
      error=>{console.error(error);
      }
    )
  }
}
