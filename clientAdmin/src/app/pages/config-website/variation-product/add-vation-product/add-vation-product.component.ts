import { Component, OnDestroy, OnInit } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { VariationModel } from '../model/variation.model';
import { VariationProductService } from '../service/vation-product.service';
import { AlertMessageService } from 'src/app/common/modal/alert-message/service/alert-message.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-add-vation-product',
  templateUrl: './add-vation-product.component.html',
  styleUrls: ['./add-vation-product.component.scss'],
})
export class AddVariationProductComponent  implements OnInit,OnDestroy {
  public variationProduct:FormGroup=this.formBuilder.group({
    nom: new FormControl('',Validators.required),
    valeur0: new FormControl('',Validators.required)
  });
  public listValeur:Array<string>=[];
  constructor(private router:Router,private formBuilder:FormBuilder,private variationService:VariationProductService,private modalMessageService:AlertMessageService) { }

  ngOnInit() {}
  Valider(){
    let dataToSend:VariationModel;
    let tabValeur=[];
    for (let index = 0; index <= this.listValeur.length; index++) {
      const element =this.variationProduct.get('valeur'+index)?.value
      tabValeur.push(element);
    }
    dataToSend={
      nom:this.variationProduct.get('nom')?.value,
      valeur:tabValeur,
      id:0,createdAt:"",selected:undefined
    }
    this.variationService.saveVariation(dataToSend).subscribe(
      res=>{console.log(res);
        this.variationProduct.reset();
        this.modalMessageService.show(res);
        this.router.navigateByUrl("/config-website/variation-product")
      },
      error=>{console.log(error);
        this.modalMessageService.show(error.error);
      }
    )
  }
  addValeur(){
    let taille= this.listValeur.length +1;
    this.variationProduct.addControl('valeur'+taille,new FormControl('',Validators.required))
    this.listValeur.push("");
    console.log("Ajouter");
    
  }
  removeValeur(){
    let taille= this.listValeur.length;
    this.variationProduct.removeControl('valeur'+taille);
    this.listValeur.splice(this.listValeur.length-1,1);

  }
  ngOnDestroy(): void {
    this.variationProduct.reset();
    this.listValeur=[];
    this.variationProduct=this.formBuilder.group({
      nom: new FormControl('',Validators.required),
      valeur0: new FormControl('',Validators.required)
    });
  }
}
