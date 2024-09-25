import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { VariationProductService } from '../service/vation-product.service';
import { VariationModel } from '../model/variation.model';
import { AlertMessageService } from 'src/app/common/modal/alert-message/service/alert-message.service';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';

@Component({
  selector: 'app-update-vation-product',
  templateUrl: './update-vation-product.component.html',
  styleUrls: ['./update-vation-product.component.scss'],
})
export class UpdateVationProductComponent  implements OnInit {
  public idSelected:string="";
  public selectedVariation?:VariationModel;
  public variationProduct:FormGroup=this.formBuilder.group({
    nom: new FormControl('',Validators.required),
  });
  public listValeur:Array<string>=[];
  constructor(private router:Router,private formBuilder:FormBuilder,private activedRoute:ActivatedRoute,private variationService:VariationProductService,private modalMessageService:AlertMessageService) { }

  ngOnInit() {
    this.idSelected = this.activedRoute.snapshot.paramMap.get('id') ?? "";
    this.loadData();
  }
  loadData(){
    this.variationService.detailOneVariation({id:this.idSelected}).subscribe(
      res=>{console.log(res);
        this.selectedVariation=res;
        this.variationProduct.get('nom')?.setValue(this.selectedVariation.nom);
        if (this.selectedVariation.valeur.length>=1) {
          for (let index = 0; index < this.selectedVariation.valeur.length; index++) {
            const element = this.selectedVariation.valeur[index];
            this.variationProduct.addControl('valeur'+index,new FormControl(element,Validators.required));
            this.listValeur.push("");
          }
        }
        // this.modalMessageService.show(res.message);
      },
      error=>{console.log(error);
        this.modalMessageService.show(error.error);
      }
    )
  }
  Valider(){
    let dataToSend:VariationModel;
    let tabValeur=[];
    for (let index = 0; index < this.listValeur.length; index++) {
      const element =this.variationProduct.get('valeur'+index)?.value
      tabValeur.push(element);
    }
    dataToSend={
      nom:this.variationProduct.get('nom')?.value,
      valeur:tabValeur,
      id:parseInt(this.idSelected),createdAt:"",selected:undefined
    }
    console.log(dataToSend);
    this.variationService.updateVariation(dataToSend).subscribe(
      res=>{console.log(res);
        // this.variationProduct.reset();
        this.modalMessageService.show(res);
        this.router.navigateByUrl("/config-website/variation-product")

      },
      error=>{console.log(error);
        this.modalMessageService.show(error.error);
      }
    )
  }
  addValeur(){
    let taille= this.listValeur.length;
    this.variationProduct.addControl('valeur'+taille,new FormControl('',Validators.required))
    this.listValeur.push("");
    console.log("Ajouter");
    console.log(this.listValeur);
    console.log(this.variationProduct.value);
    
  }
  removeValeur(){
    let taille= this.listValeur.length -1;
    console.log(taille);
    this.variationProduct.removeControl('valeur'+taille);
    this.listValeur.splice(this.listValeur.length-2,1);
    console.log(this.variationProduct.value);
  }
}
