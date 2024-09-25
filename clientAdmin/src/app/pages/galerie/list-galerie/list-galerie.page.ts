import { Component, OnDestroy, OnInit } from '@angular/core';
import { GalerieService } from '../service/galerie.service';
import { GalerieModel } from '../model/galerie.model';
import { AlertMessageService } from 'src/app/common/modal/alert-message/service/alert-message.service';
import { PreviewMediaService } from 'src/app/common/modal/preview-media/service/preview-media.service';
import Swal from 'sweetalert2';
@Component({
  selector: 'app-list-galerie',
  templateUrl: './list-galerie.page.html',
  styleUrls: ['./list-galerie.page.scss'],
})
export class ListGaleriePage implements OnInit,OnDestroy {
  public selectedTabName:string="Tout";
  public listMenuMobile:{name:string,icon:string}[]=[
    {name:'Tout',icon:'images-outline'},
    {name:'Photos',icon:'camera-outline'},
    {name:'Videos',icon:'film-outline'},
    // {name:'Documents',icon:'document-outline'},
  ] 
  public listMedia:GalerieModel[]=[];
  public listMediaNotAltered:GalerieModel[]=[];

  public mediaSelected?:GalerieModel;

  public alertButtons = [
    {
      text: 'Annuler',
      role: 'cancel',
      handler: () => {
        console.log('Alert canceled');
      },
    },
    {
      text: 'Valider',
      role: 'confirm',
      handler: () => {
        console.log('Alert confirmed');
      },
    },
  ];
  public showOpenAlert:boolean=false;
  constructor(private galerieService:GalerieService,private modalMessageService:AlertMessageService,private showMediaService:PreviewMediaService) { }

  ngOnInit() {
    this.loadData();
  }
  ngOnDestroy(): void {
    this.listMediaNotAltered=[];
    this.listMedia=[];
    this.selectedTabName="Tout";
  }
  selectedTab(name:string){
    this.selectedTabName=name;
    if (name=="Tout") {
      this.listMedia=this.listMediaNotAltered;
    }
    else if(name=="Photos") {
      let temp=this.listMediaNotAltered.filter(item=>item.documentType.startsWith('image'));
      this.listMedia = temp;
      console.log("Photo");
      console.log(temp);
      
      console.log(this.listMediaNotAltered.filter(r=>r.documentType.startsWith("image")));
      
    }
    else if(name=="Videos") {      
      let temp=this.listMediaNotAltered.filter(item=>item.documentType.startsWith('video'))
      this.listMedia = temp;
      console.log("video");
      console.log(temp);
    }
  }
  loadData(){
    this.galerieService.listMedia().subscribe(
      res=>{
        console.log(res);
        this.listMedia=res;
        this.listMediaNotAltered=res;
      },
      error=>{
        console.log(error);
        this.modalMessageService.show(error.error);
      }
    )
  }
  handleRefresh(event:any) {
    this.loadData();
    setTimeout(() => {
      event.target.complete();
    }, 2000);
  }
  previewImg(data:GalerieModel){
    this.showMediaService.show({type:data.documentType,url:data.documentUrl});
  }
  editImg(data:GalerieModel){}
  dowloadImg(data:GalerieModel){
    const link = document.createElement('a');
    link.href = data.documentUrl;
    link.target="_blank"
    link.download = data.documentOriginalName; // Nom du fichier à télécharger
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
  }
  removeImg(data:GalerieModel){
    this.showOpenAlert=true;
    console.log(data);
    this.mediaSelected=data;
  }
  setResult(ev:any) {
    this.showOpenAlert=false;
    console.log(`Dismissed with role: ${ev.detail.role}`);
    if (ev.detail.role=='confirm') {
      this.galerieService.removeMedia(this.mediaSelected).subscribe(
        res=>{      this.modalMessageService.show(res);this.ngOnInit();
        },
        error=>{this.modalMessageService.show(error.error);console.log(error);
        }
      )
    }
  }
}
