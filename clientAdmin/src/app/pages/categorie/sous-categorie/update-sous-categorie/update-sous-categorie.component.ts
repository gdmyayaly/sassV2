import { Component, OnDestroy, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { CategorieService } from '../../service/categorie.service';
import { AlertMessageService } from 'src/app/common/modal/alert-message/service/alert-message.service';
import { SelectMediaService } from 'src/app/common/modal/select-media/service/select-media.service';
import { GalerieModel } from '../../../galerie/model/galerie.model';
import { FormControl, FormGroup, Validators } from '@angular/forms';

@Component({
  selector: 'app-update-sous-categorie',
  templateUrl: './update-sous-categorie.component.html',
  styleUrls: ['./update-sous-categorie.component.scss'],
})
export class UpdateSousCategorieComponent  implements OnInit,OnDestroy {
  private idCat:string="";
  private idSousCat:string="";
  public fileToUpload:Array<any>=[];
  public imgPreview:string="";
  public files?:{name:string,type:string,url:string,size: number};
  public mediaSelected:GalerieModel[]=[];
  constructor(private router:Router,private selectMediaSerice:SelectMediaService,private modalMessageService:AlertMessageService,private Activeroute:ActivatedRoute,private categorieService:CategorieService) { 
    this.selectMediaSerice.getMediaSelected().subscribe(val=>{this.mediaSelected=val})
    console.log(this.mediaSelected);
    
  }
  categorie= new FormGroup({
    nom: new FormControl('',Validators.required),
    detail: new FormControl('',Validators.required),
    idCat: new FormControl('',Validators.required),
    idSousCat: new FormControl('',Validators.required),
    isUpload :new FormControl(true)
  })

  ngOnInit() {
    this.idCat = this.Activeroute.snapshot.paramMap.get('sousCat') ?? "";
    this.idSousCat = this.Activeroute.snapshot.paramMap.get('id') ?? "";
    this.imgPreview="";
    this.loadData();
    console.log("Update Créer");

  }
  loadData(){
    this.categorieService.detailSousCategorie({idCat:this.idCat,idSousCat:this.idSousCat}).subscribe(
      res=>{ console.log(res);
        this.categorie.get('nom')?.setValue(res.nom);
        this.categorie.get('idSousCat')?.setValue(this.idSousCat);
        this.categorie.get('idCat')?.setValue(this.idCat);
        this.categorie.get('detail')?.setValue(res.description??"");
        this.imgPreview=res.image ?? "";
      },
      error=>{this.modalMessageService.show(error.error);console.log(error);
      }
    )
  }
  ngOnDestroy(): void {
    this.categorie.reset();
    this.mediaSelected=[];
    this.fileToUpload=[];
    this.files=undefined;
    this.imgPreview='';
    console.log("Update détruit");
    
  }
  handleFileInput(event: any){
    const fileList:FileList = event.target.files;
    this.fileToUpload=[];
    this.imgPreview="";
    for (let index = 0; index < fileList.length; index++) {
      this.fileToUpload.push(fileList.item(index));
      const file = fileList[index];
      const fileType = file.type.split('/')[0];
      const fileUrl = URL.createObjectURL(file);
      this.files={name:file.name,type:fileType,url:fileUrl,size:file.size};
    }
    this.selectMediaSerice.submitMediaSelected([]);
   }
   Valider(){
    console.log(this.mediaSelected);
    const formData: FormData= new FormData();
    let status:string="false";
    if (this.mediaSelected.length>=1) {
      status="false";
      this.imgPreview="";
      formData.append('media',this.mediaSelected[0].documentUrl || "");
    }
    if (this.fileToUpload.length>=1) {
      status="true";
      formData.append("image", this.fileToUpload[0], this.fileToUpload[0].name);
    }
    if (this.imgPreview!="") {
      status="false";
      formData.append('media',this.imgPreview);
    }
    
    formData.append('isUpload',status);
    formData.append('idCat',this.categorie.get('idCat')?.value || "");
    formData.append('idSousCat',this.categorie.get('idSousCat')?.value || "");
     formData.append('nom',this.categorie.get('nom')?.value || "");
     formData.append('detail',this.categorie.get('detail')?.value || "");
    this.categorieService.updateSousCategorie(formData).subscribe(
      res=>{
        this.modalMessageService.show(res);
        this.categorie.reset();
        this.mediaSelected=[];
        this.fileToUpload=[];
        this.files=undefined;
        this.imgPreview="";
        this.router.navigateByUrl("/categorie")

      },
      error=>{this.modalMessageService.show(error.error);console.log(error);}

    )
   }
   selectMediGalerie(){
    this.selectMediaSerice.show(false);
   }
   handleRefresh(event:any) {
    this.loadData();
    setTimeout(() => {
      event.target.complete();
    }, 2000);
  }
}
