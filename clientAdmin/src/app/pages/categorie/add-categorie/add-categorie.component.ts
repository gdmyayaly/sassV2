import { Component, OnDestroy, OnInit } from '@angular/core';
import { CategorieService } from '../service/categorie.service';
import { Router } from '@angular/router';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { SelectMediaService } from 'src/app/common/modal/select-media/service/select-media.service';
import { GalerieModel } from '../../galerie/model/galerie.model';
import { AlertMessageService } from 'src/app/common/modal/alert-message/service/alert-message.service';

@Component({
  selector: 'app-add-categorie',
  templateUrl: './add-categorie.component.html',
  styleUrls: ['./add-categorie.component.scss'],
})
export class AddCategorieComponent  implements OnInit,OnDestroy {
  public fileToUpload:Array<any>=[];
  public files?:{name:string,type:string,url:string,size: number};
  public mediaSelected:GalerieModel[]=[];
  constructor(private categorieService:CategorieService,private router: Router,private selectMediaSerice:SelectMediaService,private modalMessageService:AlertMessageService) { 
    this.selectMediaSerice.getMediaSelected().subscribe(val=>{this.mediaSelected=val})
    console.log(this.mediaSelected);
    
  }
  categorie= new FormGroup({
    nom: new FormControl('',Validators.required),
    detail: new FormControl('',Validators.required),
    isUpload :new FormControl(true)
  })
  ngOnInit() {
  }
  ngOnDestroy(): void {
    this.categorie.reset();
    this.mediaSelected=[];
    this.fileToUpload=[];
    this.files=undefined;
  }
  handleFileInput(event: any){
    const fileList:FileList = event.target.files;
    this.fileToUpload=[];
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
      formData.append('media',this.mediaSelected[0].documentUrl || "");
    }
    else{
      status="true";
      formData.append("image", this.fileToUpload[0], this.fileToUpload[0].name);
    }
    formData.append('isUpload',status);

     formData.append('nom',this.categorie.get('nom')?.value || "");
     formData.append('detail',this.categorie.get('detail')?.value || "");
    this.categorieService.saveCategorie(formData).subscribe(
      res=>{
        this.modalMessageService.show(res);
        this.categorie.reset();
        this.mediaSelected=[];
        this.fileToUpload=[];
        this.files=undefined;
      },
      error=>{this.modalMessageService.show(error.error);console.log(error);}

    )
   }
   selectMediGalerie(){
    this.selectMediaSerice.show(false);
   }
}
