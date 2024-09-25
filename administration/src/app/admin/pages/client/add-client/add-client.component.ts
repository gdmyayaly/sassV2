import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { ClientService } from '../service/client.service';

@Component({
  selector: 'app-add-client',
  templateUrl: './add-client.component.html',
  styleUrls: ['./add-client.component.css']
})
export class AddClientComponent implements OnInit{
  public clientAdd = new FormGroup({
    nomEntreprise:new FormControl('',Validators.required),
    description:new FormControl('',Validators.required),
    telephoneRepresentant:new FormControl('',Validators.required),
    emailEntreprise:new FormControl(''),
    adresse:new FormControl('',Validators.required),
    websiteType:new FormControl('Ecommerce',Validators.required),
    galerieSizeLimit:new FormControl('2000000000',Validators.required),
    dateDebutAbonnement:new FormControl('',Validators.required),
    dateFinAbonnement:new FormControl('',Validators.required),
    linkWebsite:new FormControl('',Validators.required),
    prenom:new FormControl('',Validators.required),
    nom:new FormControl('',Validators.required),
    telephone:new FormControl('',Validators.required),
    email:new FormControl('',Validators.required),
    username:new FormControl('',Validators.required),
  })
  public fileToUpload:Array<any>=[];
  public files?:{name:string,type:string,url:string,size: number};
  constructor(private router:Router,private clientService:ClientService){}
  ngOnInit(): void {

  }
  saveData(){
    const formData:FormData= new FormData();
    formData.append('nomEntreprise',this.clientAdd.get('nomEntreprise')?.value ?? "");
    formData.append('description',this.clientAdd.get('description')?.value ?? "");
    formData.append('telephoneRepresentant',this.clientAdd.get('telephoneRepresentant')?.value ?? "");
    formData.append('emailEntreprise',this.clientAdd.get('emailEntreprise')?.value ?? "");
    formData.append('adresse',this.clientAdd.get('adresse')?.value ?? "");
    formData.append('websiteType',this.clientAdd.get('websiteType')?.value ?? "");
    formData.append('galerieSizeLimit',this.clientAdd.get('galerieSizeLimit')?.value ?? "");
    formData.append('dateDebutAbonnement',this.clientAdd.get('dateDebutAbonnement')?.value ?? "");
    formData.append('dateFinAbonnement',this.clientAdd.get('dateFinAbonnement')?.value ?? "");
    formData.append('linkWebsite',this.clientAdd.get('linkWebsite')?.value ?? "");
    formData.append('prenom',this.clientAdd.get('prenom')?.value ?? "");
    formData.append('nom',this.clientAdd.get('nom')?.value ?? "");
    formData.append('telephone',this.clientAdd.get('telephone')?.value ?? "");
    formData.append('email',this.clientAdd.get('email')?.value ?? "");
    formData.append('username',this.clientAdd.get('username')?.value ?? "");
    formData.append("logo", this.fileToUpload[0], this.fileToUpload[0].name);
    this.clientService.saveClient(formData).subscribe(
      res=>{console.log(res);this.router.navigateByUrl("/admin/client")},
      error=>{console.log(error);}
    )
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
   }
}
