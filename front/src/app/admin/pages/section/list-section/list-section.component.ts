import { Component, OnInit } from '@angular/core';
import { SectionWebsiteService } from '../service/section-website.service';
import { SectionModel } from '../models/section.model';
import { ActivatedRoute } from '@angular/router';

@Component({
  selector: 'app-list-section',
  templateUrl: './list-section.component.html',
  styleUrls: ['./list-section.component.css']
})
export class ListSectionComponent implements OnInit{
  public sectionList:SectionModel[]=[];
  public idSectionType:string="";
  constructor(private sectionWebsiteService:SectionWebsiteService,private activatedRoute: ActivatedRoute){}
  ngOnInit(): void {
    this.idSectionType = this.activatedRoute.snapshot.paramMap.get('section-type-id') ?? "";
    this.loadSection(this.idSectionType);
  }

  loadSection(id:string){
    this.sectionWebsiteService.getSection(id).subscribe(
      res=>{console.log(res);this.sectionList=res;
      },
      error=>{console.error(error);
      }
    )
  }
}
