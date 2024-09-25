import { Component, OnDestroy, OnInit } from '@angular/core';
import { GalerieService } from '../service/galerie.service';
import { UserInformationService } from 'src/app/common/service/user-information.service';
import { Utilisateur} from '../../../common/model/utilisateur';
import { AlertMessageService } from 'src/app/common/modal/alert-message/service/alert-message.service';
type UtilisateurNullable = Utilisateur | null;

@Component({
  selector: 'app-add-galerie',
  templateUrl: './add-galerie.page.html',
  styleUrls: ['./add-galerie.page.scss'],
})
export class AddGaleriePage implements OnInit,OnDestroy{
  public OtherImageUpload:Array<any>=[];
  public files:{name:string,type:string,url:string,size: string,sizeByte:number}[]=[];
  public totalSize:string="0 MB";
  public userInfos?:UtilisateurNullable;

  constructor(private galerieService:GalerieService,private modalMessageService:AlertMessageService,private userInformationService:UserInformationService) {
    this.userInformationService.getUserData().subscribe(val=>{this.userInfos=val});

   }

  ngOnInit() {
    this.userInformationService.getInfos();
  }
  ngOnDestroy(): void {
    this.files=[];
    this.totalSize="0 MB";
    this.OtherImageUpload=[];
  }
  handleFileInputMultiple(event: any){//Event
    const fileList:FileList = event.target.files;
    let totalSize=0;
    for (let index = 0; index < fileList.length; index++) {
      this.OtherImageUpload.push(fileList.item(index));
      const file = fileList[index];
      const fileType = file.type.split('/')[0];
      const fileUrl = URL.createObjectURL(file);
      const fileSize = this.formatBytes(file.size);
      totalSize= totalSize + file.size;
      this.files.push({name:file.name,type:fileType,url:fileUrl,size:fileSize,sizeByte:file.size});
    }
    this.totalSize=(totalSize / 1048576).toFixed(2) + " MB";
  }
  deleteMultiplePic(id:any){
    this.files.splice(id,1);
    this.OtherImageUpload.splice(id,1);   
  }
  formatBytes(bytes: number, decimals = 2) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const dm = decimals < 0 ? 0 : decimals;
    const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
  }
  getTotalSize() {
    let totalSize = 0;
    for (const file of this.files) {
      totalSize += file.sizeByte
    }
    return (totalSize / 1048576).toFixed(2) + " MB";
  }
  getImageCount() {
    return this.files.filter(file => file.type.startsWith('image')).length;
  }

  getVideoCount() {
    return this.files.filter(file => file.type.startsWith('video')).length;
  }
  submitForm(){
    const formData: FormData= new FormData();
    for (let index = 0; index < this.files.length; index++) {
      formData.append("image"+index, this.OtherImageUpload[index], this.OtherImageUpload[index].name);
    }

    this.galerieService.saveMedia(formData)
    .subscribe(response => {
      console.log('Upload successful!', response);
      console.log('Upload successful!1', response.message);

      this.modalMessageService.show(response);
      this.files=[];
      this.totalSize="0 MB";
      this.OtherImageUpload=[];
    }, error => {
      this.modalMessageService.show(error.error);
      console.error('Error uploading files:', error);
    });
  }
 
}
