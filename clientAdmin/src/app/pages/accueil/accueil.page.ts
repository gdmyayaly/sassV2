import { Component, OnInit } from '@angular/core';
import { AccueilService } from './service/accueil.service';
import { UserInformationService } from 'src/app/common/service/user-information.service';
import { Chart } from 'chart.js';
// import Chart from 'chart.js';

@Component({
  selector: 'app-accueil',
  templateUrl: './accueil.page.html',
  styleUrls: ['./accueil.page.scss'],
})
export class AccueilPage implements OnInit {
  public chart: any;
  constructor(private accueilService:AccueilService,private userInformationService:UserInformationService) { }

  ngOnInit() {
    this.userInformationService.getInfos();
   // this.createChart();
  }
  handleRefresh(event:any) {
    this.userInformationService.getInfos()
    setTimeout(() => {
      // Any calls to load data go here
      event.target.complete();
    }, 2000);
  }
  createChart(){
    this.chart = new Chart("MyChart", {
      type: 'line', //this denotes tha type of chart

      data: {// values on X-Axis
        labels: ['2022-05-10', '2022-05-11', '2022-05-12','2022-05-13',
								 '2022-05-14', '2022-05-15', '2022-05-16','2022-05-17', ], 
	       datasets: [
          {
            label: "Sales",
            data: ['467','576', '572', '79', '92',
								 '574', '573', '576'],
            backgroundColor: 'blue'
          },
          {
            label: "Profit",
            data: ['542', '542', '536', '327', '17',
									 '0.00', '538', '541'],
            backgroundColor: 'limegreen'
          }  
        ]
      },
      options: {
        aspectRatio:2.5
      }
      
    });
  }

}
