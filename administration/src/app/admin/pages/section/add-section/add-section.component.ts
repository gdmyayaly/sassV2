import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import { SectionWebsiteService } from '../service/section-website.service';

@Component({
  selector: 'app-add-section',
  templateUrl: './add-section.component.html',
  styleUrls: ['./add-section.component.css']
})
export class AddSectionComponent implements OnInit{
  public idSectionType:string="";
  public form= new FormGroup({
    idSectionType:new FormControl('',Validators.required),
    sectionName: new FormControl('',Validators.required),
    // defaultValue: new FormControl('{}',Validators.required),
    html: new FormControl('',Validators.required),
    css: new FormControl('',Validators.required),
    js: new FormControl(''),
    type: new FormControl('Section',Validators.required),
    // css : new FormControl('assets/css/menu/menu2.css',Validators.required),
    // path: new FormControl('components/menu/menu2.html.twig',Validators.required),
    // js: new FormControl('assets/js/menu/menu2.js'),
  })
  public fileToUpload:Array<any>=[];
  public selectedCssFiles: File[] = [];
  public selectedJsFiles: File[] = [];
  public files?:{name:string,type:string,url:string,size: number};
  constructor(private router:Router,private sectionWebsiteService:SectionWebsiteService,private activatedRoute: ActivatedRoute){}
  ngOnInit(): void {
    this.idSectionType = this.activatedRoute.snapshot.paramMap.get('section-type-id') ?? "";
    this.form.get('idSectionType')?.setValue(this.idSectionType);
  }
  submitData(){
    const formData:FormData= new FormData();
    let defaultValue = this.minifyText(this.form.get('defaultValue')?.value ?? "" );
    formData.append("idSectionType",this.form.get('idSectionType')?.value ?? "");
    formData.append("sectionName",this.form.get('sectionName')?.value ?? "");
    formData.append("type",this.form.get('type')?.value ?? "")
    formData.append("defaultValue",defaultValue)
    formData.append("html",this.form.get('html')?.value ?? "")
    formData.append("css",this.form.get('css')?.value ?? "")
    formData.append("js",this.form.get('js')?.value ?? "")

    formData.append("logo", this.fileToUpload[0], this.fileToUpload[0].name);
    // formData.append("css",this.form.get('css')?.value ?? "")
    // formData.append("path",this.form.get('path')?.value ?? "")
    // formData.append("js",this.form.get('js')?.value ?? "")
    this.selectedCssFiles.forEach(file => {
      formData.append('cssFiles[]', file, file.name);
    });

    this.selectedJsFiles.forEach(file => {
      formData.append('jsFiles[]', file, file.name);
    });
    this.sectionWebsiteService.saveSection(formData).subscribe(
      res=>{console.log(res);this.router.navigate(["admin","section",this.idSectionType])
      },
      error=>{console.log(error);
      }
    )
  }
  minifyText(text:string) {
    return text.replace(/\s+/g, '');
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
// Méthode pour la sélection des fichiers
  onFileSelected(event: any, fileType: string): void {
    const files = event.target.files;

    for (let i = 0; i < files.length; i++) {
      if (fileType === 'css' && files[i].type === 'text/css') {
        this.selectedCssFiles.push(files[i]);
      } else if (fileType === 'js' && files[i].type === 'application/javascript') {
        this.selectedJsFiles.push(files[i]);
      }
    }
  }

  // Méthode pour retirer un fichier sélectionné
  removeFile(index: number, fileType: string): void {
    if (fileType === 'css') {
      this.selectedCssFiles.splice(index, 1);
    } else if (fileType === 'js') {
      this.selectedJsFiles.splice(index, 1);
    }
  }
}
