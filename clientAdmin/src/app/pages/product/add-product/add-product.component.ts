import { Component, OnDestroy, OnInit } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { VariationProductService } from '../../config-website/variation-product/service/vation-product.service';
import { VariationModel } from '../../config-website/variation-product/model/variation.model';
import { CategoryModel } from '../../categorie/model/category.model';
import { CategorieService } from '../../categorie/service/categorie.service';
import { SelectMediaService } from 'src/app/common/modal/select-media/service/select-media.service';
import { GalerieModel } from '../../galerie/model/galerie.model';
import { SelecMultitMediaService } from 'src/app/common/modal/select-multi-media/service/select-media.service';
import { ProductService } from '../service/product.service';
import { AlertMessageService } from 'src/app/common/modal/alert-message/service/alert-message.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-add-product',
  templateUrl: './add-product.component.html',
  styleUrls: ['./add-product.component.scss'],
})
export class AddProductComponent  implements OnInit,OnDestroy {
  
  public product?: FormGroup
  public allVariations:VariationModel[]=[];
  public countColor:string[]=[];
  public listCategorie:CategoryModel[]=[];
  public ImageOneUpload:any;
  public ImageMultiUpload:Array<any>=[];
  public Onefile?:{name:string,type:string,url:string};
  public Multifiles:{name:string,type:string,url:string}[]=[];
  public OnemediaSelected:GalerieModel[]=[];
  public MultimediaSelected:GalerieModel[]=[];
  
  constructor(private router:Router,private fb: FormBuilder,private variationProductService:VariationProductService,private categoryService:CategorieService,private selectMediaSerice:SelectMediaService,private selectMultiMediaSerice:SelecMultitMediaService,private productService:ProductService,private modalMessageService:AlertMessageService) { 
    this.product= this.fb.group({
        nom: new FormControl('',Validators.required),
        categorie: new FormControl('',Validators.required),
        brefDescription:new FormControl('',Validators.required),
        detailDescription:new FormControl(''),
        prix:new FormControl(''),
        prixPromo:new FormControl(''),
        promoStart: new FormControl(''),
        promoEnd: new FormControl(''),
        color0: new FormControl(''),
        qt: new FormControl(''),
    })
    this.selectMediaSerice.getMediaSelected().subscribe(val=>{this.OnemediaSelected=val})
    this.selectMultiMediaSerice.getMediaSelected().subscribe(val=>{this.MultimediaSelected=val})

  }

  ngOnInit() {
    this.loadAllVariation();
    this.loadAllCategorie();
  }
  ngOnDestroy(): void {
   this.allVariations=[];
   this.product?.reset(); 
   this.listCategorie=[];
   this.countColor=[];
   this.product= this.fb.group({
    nom: new FormControl('',Validators.required),
    brefDescription:new FormControl('',Validators.required),
    detailDescription:new FormControl(''),
    prix:new FormControl(''),
    prixPromo:new FormControl(''),
    promoStart: new FormControl(''),
    promoEnd: new FormControl(''),
    color0: new FormControl(''),
  })
  this.selectMediaSerice.submitMediaSelected([]);
  this.selectMultiMediaSerice.submitMediaSelected([]);
  this.ImageOneUpload=undefined;
  this.ImageMultiUpload=[];
  this.Onefile=undefined;
  this.Multifiles=[];
  }
  loadAllVariation(){
    this.variationProductService.listVariation().subscribe(
      res=>{console.log(res);
        this.allVariations=res;
        for (let index = 0; index < this.allVariations.length; index++) {
          this.allVariations[index].selected=[];
        }
      },
      error=>{this.modalMessageService.show(error.error);console.log(error);}
      )
  }
  loadAllCategorie(){
    this.categoryService.listCategorie().subscribe(
      res=>{console.log(res);
        this.listCategorie=res;
      },
      error=>{this.modalMessageService.show(error.error);console.log(error);}
      )
  }
  selectOneMediGalerie(){
    this.selectMediaSerice.show(false);
  }
  handleOneFileInput(event:any){
    const fileList:FileList = event.target.files;
    this.ImageOneUpload=[];
    for (let index = 0; index < fileList.length; index++) {
      this.ImageOneUpload.push(fileList.item(index));
      const file = fileList[index];
      const fileType = file.type.split('/')[0];
      const fileUrl = URL.createObjectURL(file);
      this.Onefile={name:file.name,type:fileType,url:fileUrl};
    }
    this.selectMediaSerice.submitMediaSelected([]);
  }
  selecMultitMediGalerie(){
    this.selectMultiMediaSerice.show(true);
  }
  handleMultiFileInput(event:any){
    const fileList:FileList = event.target.files;
    let totalSize=0;
    for (let index = 0; index < fileList.length; index++) {
      this.ImageMultiUpload.push(fileList.item(index));
      const file = fileList[index];
      const fileType = file.type.split('/')[0];
      const fileUrl = URL.createObjectURL(file);
      totalSize= totalSize + file.size;
      this.Multifiles.push({name:file.name,type:fileType,url:fileUrl});
    }
  }
  removeMediaOne(type:string){
    if (type=="mobile") {
      this.Onefile=undefined;
    } 
    this.selectMediaSerice.submitMediaSelected([]);
  }
  removeMediaOneMedia(index:number){
    this.Multifiles.splice(index,1);
    this.ImageMultiUpload.splice(index,1);
  }
  removeMediaMultiMedia(index:number){
    this.MultimediaSelected.splice(index,1);
  }

  Valider(){
    let isVariation:boolean=false;
    console.log(this.product?.value);
    const formData:FormData = new FormData();
    formData.append("nom",this.product?.get("nom")?.value)
    formData.append("categorie",this.product?.get("categorie")?.value)
    formData.append("brefDescription",this.product?.get("brefDescription")?.value)
    formData.append("detailDescription",this.product?.get("detailDescription")?.value)
    formData.append("prix",this.product?.get("prix")?.value)
    formData.append("prixPromo",this.product?.get("prixPromo")?.value)
    formData.append("promoStart",this.product?.get("promoStart")?.value)
    formData.append("promoEnd",this.product?.get("promoEnd")?.value)
    formData.append("colorCount",this.countColor.length.toString());
    formData.append("color0",this.product?.get("color0")?.value);
    formData.append("qt",this.product?.get("qt")?.value)

    // Vérification des variation couleur et autres
    for (let index = 0; index < this.countColor.length; index++) {
      isVariation=true;
      let name="color"+(index+1);
      console.log(name);
      console.log(this.product?.get(name)?.value);
      
      if (this.product?.get(name)?.value!="") {
        formData.append(name,this.product?.get(name)?.value);
      }
      
    }
    // Assignation de variation
    for (let index = 0; index < this.allVariations.length; index++) {
      let selected =this.allVariations[index].selected ?? [];
      if (selected.length>=1) {
        isVariation=true;
        let val="vide";
        for (let indexJ = 0; indexJ < selected.length; indexJ++) {
          const element = selected[indexJ];
          val=val+"&"+element;
        }
        formData.append(this.allVariations[index].nom,val)

      }
    }
    // Attribution des images
    // Pour l'image principal
    if (this.OnemediaSelected.length>=1) {
      formData.append("imagePrincipal",this.OnemediaSelected[0].documentUrl);
    }
    else{
      formData.append("imagePrincipalUpload",this.ImageOneUpload[0], this.ImageOneUpload[0].name);
    }
    // Pour les autres images
    formData.append("countGalerie",this.MultimediaSelected.length.toString());
    formData.append("countUpload",this.Multifiles.length.toString());

    for (let index = 0; index < this.ImageMultiUpload.length; index++) {
      formData.append("imageUpload"+index, this.ImageMultiUpload[index], this.ImageMultiUpload[index].name);
    }
    for (let index = 0; index < this.MultimediaSelected.length; index++) {
      formData.append("imageGalerie"+index, this.MultimediaSelected[index].documentUrl);
    }
    console.log(formData);
    this.productService.saveMedia(formData).subscribe(
      res=>{console.log(res);
        this.modalMessageService.show(res);
        this.router.navigateByUrl("/produit");
      },
      error=>{this.modalMessageService.show(error.error);console.log(error);}
    )
  }
  moreColor(){
    let taille=this.countColor.length +1 ;
    console.log(taille);
    this.product?.addControl('color'+taille,new FormControl(''))
    this.countColor.push('color'+taille);
  }
  removeColorControl(index:number){
    let name=this.countColor[index];
    this.countColor.splice(index,1);
    this.product?.removeControl(name);
    console.log(this.product?.value);

  }
  SelectedOneOptionalInput(item:VariationModel,val:string,indexInTab:number){
   let variationSelect= this.allVariations[indexInTab];   
   let index= variationSelect?.selected?.findIndex(r=>r==val) ?? -1   
   if (index > -1) {
    this.allVariations[indexInTab].selected?.splice(index,1);
   } else {
    this.allVariations[indexInTab].selected?.push(val);
   }   
  }
}
