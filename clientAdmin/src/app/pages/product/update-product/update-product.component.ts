import { Component, OnInit } from '@angular/core';
import { ProductService } from '../service/product.service';
import { ActivatedRoute } from '@angular/router';

@Component({
  selector: 'app-update-product',
  templateUrl: './update-product.component.html',
  styleUrls: ['./update-product.component.scss'],
})
export class UpdateProductComponent  implements OnInit {
  private idProduct:string="";

  constructor(private productService:ProductService,private Activeroute:ActivatedRoute) { }

  ngOnInit() {
    this.idProduct = this.Activeroute.snapshot.paramMap.get('id') ?? "";

  }
  loadData(){
    this.productService.detailOneProduct(this.idProduct).subscribe(
      res=>{console.log(res);

      },
      error=>{console.log(error);
      }
    )
  }
  handleRefresh(event:any) {
    this.loadData();
    setTimeout(() => {
      event.target.complete();
    }, 2000);
  }
}
