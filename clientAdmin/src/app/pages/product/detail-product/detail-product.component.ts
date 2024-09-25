import { Component, ElementRef, OnDestroy, OnInit } from '@angular/core';
import { ProductService } from '../service/product.service';
import { ActivatedRoute } from '@angular/router';
import { ProductModel } from '../model/product.model';
import { AlertMessageService } from 'src/app/common/modal/alert-message/service/alert-message.service';
import { PreviewMediaService } from 'src/app/common/modal/preview-media/service/preview-media.service';
import { GalerieModel } from '../../galerie/model/galerie.model';
import { SelecMultitMediaService } from 'src/app/common/modal/select-multi-media/service/select-media.service';
import { SelectMediaService } from 'src/app/common/modal/select-media/service/select-media.service';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { CategorieService } from '../../categorie/service/categorie.service';
import { CategoryModel } from '../../categorie/model/category.model';
import { VariationModel } from '../../config-website/variation-product/model/variation.model';
import { VariationProductService } from '../../config-website/variation-product/service/vation-product.service';

@Component({
  selector: 'app-detail-product',
  templateUrl: './detail-product.component.html',
  styleUrls: ['./detail-product.component.scss'],
})
export class DetailProductComponent  implements OnInit,OnDestroy {
  private idProduct:string="";
  public productSelected?:ProductModel;
  public showImgAndNameProduct:boolean=false;
  public ImageOneUpload:any;
  public Onefile?:{name:string,type:string,url:string};
  public OnemediaSelected:GalerieModel[]=[];
  public productNameForm= new FormGroup({
    nom: new FormControl('',Validators.required),
  })
  public showCategoryProduct:boolean=false;
  public listCategorie:CategoryModel[]=[];
  public productCategoryForm= new FormGroup({
    categorie: new FormControl<Array<string>>([],Validators.required),
    // categorie: new FormControl("",Validators.required),
  })
  public showDetailProduct:boolean=false;
  public detailProduct?: FormGroup
  public countColor:string[]=[];
  public allVariations:VariationModel[]=[];

  constructor(private categoryService:CategorieService,private fb: FormBuilder,private productService:ProductService,
              private Activeroute:ActivatedRoute,private modalMessageService:AlertMessageService,
              private showMediaService:PreviewMediaService,private selectMediaSerice:SelectMediaService,
              private selectMultiMediaSerice:SelecMultitMediaService,private variationProductService:VariationProductService
            ) {
    this.selectMediaSerice.getMediaSelected().subscribe(val=>{this.OnemediaSelected=val})
   }

  ngOnInit() {
    this.idProduct = this.Activeroute.snapshot.paramMap.get('id') ?? "";
    this.loadData();
  }
  ngOnDestroy(): void {
    this.idProduct="";
    this.productSelected=undefined;
    this.showImgAndNameProduct=false;
    this.selectMediaSerice.submitMediaSelected([]);
    this.selectMultiMediaSerice.submitMediaSelected([]);
    this.ImageOneUpload=undefined;
    this.OnemediaSelected=[];
    this.productNameForm.reset();
    // this.ImageMultiUpload=[];
    this.Onefile=undefined;
    // this.Multifiles=[];
    this.showCategoryProduct=false;
    this.listCategorie=[];
    this.productCategoryForm.reset();
    this.countColor=[];
  }
  loadData(){
    this.productService.detailOneProduct(this.idProduct).subscribe(
      res=>{console.log(res);this.productSelected=res;

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
  previewOtherImg(item:string){
    this.showMediaService.show({type:"image",url:item});
  }
  editImgAndNameProduct(){
    this.showImgAndNameProduct=true;
    this.OnemediaSelected=[];
    this.Onefile=undefined;
    this.ImageOneUpload=[];
    this.productNameForm.get('nom')?.setValue(this.productSelected?.nom ?? "");
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
  selectOneMediGalerie(){
    this.selectMediaSerice.show(false);
  }
  removeMediaOne(type:string){
    if (type=="mobile") {
      this.Onefile=undefined;
      this.ImageOneUpload=[];
    } 
    this.selectMediaSerice.submitMediaSelected([]);
  }
  submitEditNameOrImageProduct(){
    console.log(this.productNameForm.value);
    console.log(this.ImageOneUpload);
    console.log(this.OnemediaSelected);
    var formData= new FormData();
    formData.append("nameOrImage","");
    formData.append("nom",this.productNameForm.get('nom')?.value ?? this.productSelected?.nom ?? "")
    if (this.OnemediaSelected.length>=1) {
      formData.append("imagePrincipal",this.OnemediaSelected[0].documentUrl);
    }
    else if(this.ImageOneUpload.length>=1){
      formData.append("imagePrincipalUpload",this.ImageOneUpload[0], this.ImageOneUpload[0].name);
    }
    this.productService.updateProduct(formData,this.idProduct).subscribe(
      res=>{console.log(res);
        this.cancelEditNameOrImageProduct();
        this.productSelected=res;
        // this.ngOnInit();
      },
      error=>{console.error(error)}
    )
  }
  cancelEditNameOrImageProduct(){
    this.showImgAndNameProduct=false;
    this.productNameForm.reset();
  }
  editCategoryProduct(){
    this.loadAllCategorie();
    this.showCategoryProduct=true;
    console.log(this.productSelected?.productCategoryValues);
  }
  loadAllCategorie(){
    this.categoryService.listCategorie().subscribe(
      res=>{console.log(res);
        this.listCategorie=res;
        if (this.productSelected?.productCategoryValues) {
          let tabVal:Array<string>=[];
          for (let index = 0; index < this.productSelected.productCategoryValues.length; index++) {
            if (this.productSelected.productCategoryValues[index].category) {
              tabVal.push(this.productSelected.productCategoryValues[index].category.id.toString())
            } else {
              tabVal.push(this.productSelected.productCategoryValues[index].sousCategory.id.toString())
            }
          }          
          this.productCategoryForm.get('categorie')?.setValue(tabVal);
        }
      },
      error=>{this.modalMessageService.show(error.error);console.log(error);}
      )
  }
  submitEditCategoryProduct(){
    console.log("Forme");
    console.log(this.productCategoryForm.value);
    var formData= new FormData();
    formData.append("categorieUpdate","");
    formData.append("categorie",this.productCategoryForm.get('categorie')?.value?.toString() ?? "");
    this.productService.updateProduct(formData,this.idProduct).subscribe(
      res=>{console.log(res);
        this.cancelEditCategoryProduct();
        this.productSelected=res;
         this.ngOnInit();
      },
      error=>{console.error(error)}
    )
  }
  cancelEditCategoryProduct(){
    this.showCategoryProduct=false;
    this.productCategoryForm.reset();
  }
  editDetailProduct(){
    this.loadAllVariation();
    this.detailProduct= this.fb.group({
      brefDescription:new FormControl(this.productSelected?.brefDescription ?? "",Validators.required),
      detailDescription:new FormControl(this.productSelected?.detailDescription ?? ""),
      prix:new FormControl(this.productSelected?.prix ?? ""),
      prixPromo:new FormControl(this.productSelected?.prixPromo ?? ""),
      promoStart: new FormControl(this.formatDate(this.productSelected?.promoStart) ?? ""),
      promoEnd: new FormControl(this.formatDate(this.productSelected?.promoEnd) ?? ""),
      color0: new FormControl(''),
      qt: new FormControl(this.productSelected?.quantity ?? ""),
    })
    if (this.productSelected) {
      // this.detailProduct?.setValue('color0',new FormControl(''))
      this.detailProduct.get('color0')?.setValue(this.productSelected?.colors[0])
      for (let index = 1; index < this.productSelected?.colors.length; index++) {
        this.detailProduct?.addControl('color'+index,new FormControl(this.productSelected?.colors[index]));
        this.countColor.push('color'+index);
      } 
    }
    this.showDetailProduct=true;

  }
  removeColorControl(index:number){
    let name=this.countColor[index];
    this.countColor.splice(index,1);
    this.detailProduct?.removeControl(name);
    console.log(this.detailProduct?.value);
  }
  moreColor(){
    let taille=this.countColor.length +1 ;
    console.log(taille);
    this.detailProduct?.addControl('color'+taille,new FormControl(''))
    this.countColor.push('color'+taille);
  }
  loadAllVariation(){
    this.variationProductService.listVariation().subscribe(
      res=>{console.log(res);
        this.allVariations=res;
        for (let index = 0; index < this.allVariations.length; index++) {
          this.allVariations[index].selected=[];
          this.allVariations[index].removed=[];
        }
        // Vérification si cette variation est inclu ou non dans le produit ou pas voir même la valeur du produit y est supprimmer ou pas
        if (this.productSelected) {
          for (let index = 0; index < this.productSelected?.productVariationValues.length; index++) {
            // On parcour les valeurs
            for (let indexValVariation = 0; indexValVariation < this.productSelected?.productVariationValues[index].value.length; indexValVariation++) {
              let indexVariation=this.allVariations.findIndex(r=>r.id==this.productSelected?.productVariationValues[index].variationProduct.id);
              console.log("Valeur de l'index "+indexVariation);
              console.log("Val 2 "+this.productSelected?.productVariationValues[index].variationProduct.id);
              
              if (this.allVariations[indexVariation].valeur.includes(this.productSelected?.productVariationValues[index].value[indexValVariation])) {
                this.allVariations[indexVariation].selected?.push(this.productSelected?.productVariationValues[index].value[indexValVariation]);
              } else {
                this.allVariations[indexVariation].removed?.push(this.productSelected?.productVariationValues[index].value[indexValVariation]);
              }
            }
            this.productSelected?.productVariationValues[index].value
          } 
        }
      },
      error=>{this.modalMessageService.show(error.error);console.log(error);}
      )
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
   submitEditDetailProduct(){
    console.log(this.detailProduct?.value);
    console.log(this.countColor);
    
    var formData= new FormData();
    let isVariation:boolean=false;

    formData.append("detailUpdate","");
    formData.append("brefDescription",this.detailProduct?.get("brefDescription")?.value)
    formData.append("detailDescription",this.detailProduct?.get("detailDescription")?.value)
    formData.append("prix",this.detailProduct?.get("prix")?.value)
    formData.append("prixPromo",this.detailProduct?.get("prixPromo")?.value)
    formData.append("promoStart",this.detailProduct?.get("promoStart")?.value)
    formData.append("promoEnd",this.detailProduct?.get("promoEnd")?.value)
    formData.append("colorCount",this.countColor.length.toString());
    formData.append("color0",this.detailProduct?.get("color0")?.value);
    formData.append("qt",this.detailProduct?.get("qt")?.value);
    if (this.countColor.length>=1) {
      for (let index = 0; index < this.countColor.length; index++) {
        isVariation=true;
        let name="color"+(index+1);
        console.log(name);
        console.log(this.detailProduct?.get(name)?.value);
        
        if (this.detailProduct?.get(name)?.value!="") {
          formData.append(name,this.detailProduct?.get(name)?.value);
        }
        
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
    console.log(formData);
    console.log(formData.get('color0'));
    
    this.productService.updateProduct(formData,this.idProduct).subscribe(
      res=>{
        console.log(res);
        this.cancelEditDetailProduct();
        this.productSelected=res;
        // this.ngOnInit();
      },
      error=>{console.error(error)}
    )
    // console.log(this.detailProduct);
    
    // this.detailProduct= this.fb.group({
    //   brefDescription:new FormControl(this.productSelected?.brefDescription ?? "",Validators.required),
    //   detailDescription:new FormControl(this.productSelected?.detailDescription ?? ""),
    //   prix:new FormControl(this.productSelected?.prix ?? ""),
    //   prixPromo:new FormControl(this.productSelected?.prixPromo ?? ""),
    //   promoStart: new FormControl(this.formatDate(this.productSelected?.promoStart) ?? ""),
    //   promoEnd: new FormControl(this.formatDate(this.productSelected?.promoEnd) ?? ""),
    //   color0: new FormControl(''),
    //   qt: new FormControl(this.productSelected?.quantity ?? ""),
    // })
    // if (this.productSelected) {
    //   // this.detailProduct?.setValue('color0',new FormControl(''))
    //   this.detailProduct.get('color0')?.setValue(this.productSelected?.colors[0])
    //   for (let index = 1; index < this.productSelected?.colors.length; index++) {
    //     this.detailProduct?.addControl('color'+index,new FormControl(this.productSelected?.colors[index]));
    //     this.countColor.push('color'+index);
    //   } 
    // }
   }
   cancelEditDetailProduct(){
    this.showDetailProduct=false;
    this.detailProduct?.reset();
    this.allVariations=[];
   }
   formatDate(dateString?: string): string | null{
    if (dateString) {
      const date = new Date(dateString);
      const year = date.getFullYear();
      let month: string | number = date.getMonth() + 1;
      let day: string | number = date.getDate();

      // Ajout d'un zéro devant le mois ou le jour si nécessaire pour obtenir le format "yyyy-MM-dd"
      if (month < 10) {
        month = '0' + month;
      }
      if (day < 10) {
        day = '0' + day;
      }

      return `${year}-${month}-${day}`;
    } else {
      return null;
    }
    
  }
}
