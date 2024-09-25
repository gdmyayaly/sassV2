import { Component, OnDestroy, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { CategorieService } from '../service/categorie.service';
import { AlertMessageService } from 'src/app/common/modal/alert-message/service/alert-message.service';
import { SelectMediaService } from 'src/app/common/modal/select-media/service/select-media.service';
import { GalerieModel } from '../../galerie/model/galerie.model';
import { FormControl, FormGroup, Validators } from '@angular/forms';

@Component({
  selector: 'app-update-categorie',
  templateUrl: './update-categorie.component.html',
  styleUrls: ['./update-categorie.component.scss'],
})
export class UpdateCategorieComponent  implements OnInit,OnDestroy {

  private idSelected:string="";
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
    id: new FormControl('',Validators.required),
    isUpload :new FormControl(true)
  })

  ngOnInit() {
    this.idSelected = this.Activeroute.snapshot.paramMap.get('id') ?? "";
    this.imgPreview="";
    this.loadData();
  }
  loadData(){
    this.categorieService.detailCategorie(this.idSelected).subscribe(
      res=>{ console.log(res);
        this.categorie.get('nom')?.setValue(res.nom);
        this.categorie.get('id')?.setValue(res.id.toString());
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
    formData.append('id',this.categorie.get('id')?.value || "");
     formData.append('nom',this.categorie.get('nom')?.value || "");
     formData.append('detail',this.categorie.get('detail')?.value || "");
    this.categorieService.updateCategorie(formData).subscribe(
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
