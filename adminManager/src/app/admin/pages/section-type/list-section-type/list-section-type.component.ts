import { Component, OnInit } from '@angular/core';
import { SectionTypeService } from '../services/section-type.service';
import { SectionTypeModel } from '../models/section-type.model';

@Component({
  selector: 'app-list-section-type',
  templateUrl: './list-section-type.component.html',
  styleUrls: ['./list-section-type.component.css']
})
export class ListSectionTypeComponent implements OnInit{

  constructor(private sectionTypeService:SectionTypeService){}
  public listSectionType:SectionTypeModel[]=[];
  ngOnInit(): void {
    this.loadSectionType();
  }
  loadSectionType(){
    this.sectionTypeService.getAllSectionType().subscribe(
      res=>{
        console.log(res);
        this.listSectionType=res;
      },
      error=>{
        console.log(error);
        
      }
    )
  }
}
