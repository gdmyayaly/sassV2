import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { SectionTypeService } from '../services/section-type.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-add-section-type',
  templateUrl: './add-section-type.component.html',
  styleUrls: ['./add-section-type.component.css']
})
export class AddSectionTypeComponent implements OnInit{
  public form= new FormGroup({
    nom:new FormControl('',Validators.required),
    detail:new FormControl('',Validators.required),
  })
  
  constructor(private sectionTypeService:SectionTypeService,private router:Router){}
  ngOnInit(): void {
    
  }
  submitData(){
    console.log(this.form.value);
    this.sectionTypeService.saveSectionType(this.form.value).subscribe(
      res=>{
        this.router.navigateByUrl("/admin/section-type");
      },
      error=>{
        console.log(error);
        
      }
    )
    
  }
}
