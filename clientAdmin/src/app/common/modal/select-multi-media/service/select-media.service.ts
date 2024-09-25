import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { BehaviorSubject, Observable } from 'rxjs';
import { GalerieModel } from 'src/app/pages/galerie/model/galerie.model';
import { environment } from 'src/environments/environment';
import { AlertMessageService } from '../../alert-message/service/alert-message.service';
@Injectable({
  providedIn: 'root'
})
export class SelecMultitMediaService {

  private showAlert = new BehaviorSubject<boolean>(false);
  private multipleSelection = new BehaviorSubject<boolean>(false);

  private mediaSelected = new BehaviorSubject<GalerieModel[]>([])
  public listMedia:GalerieModel[]=[];
  constructor(private http:HttpClient,private modalMessageService:AlertMessageService) { }

  show(multi:boolean) {
    this.mediaSelected.next([])
    this.http.get<GalerieModel[]>(environment.urlApi+"api/client/galerie").subscribe(
      res=>{this.listMedia=res;this.showAlert.next(true);this.multipleSelection.next(multi)},
      error=>{this.modalMessageService.show(error.error);console.log(error);}
    )
  }

  hide() {
    this.multipleSelection.next(false);
    this.showAlert.next(false);
  }

  statusAlert(): Observable<boolean> {
    return this.showAlert;
  }
  getMultipleSelection(): Observable<boolean> {
    return this.multipleSelection;
  }
  getMediaSelected(): Observable<GalerieModel[]> {
    return this.mediaSelected;
  }
  submitMediaSelected(data:GalerieModel[]) {
    console.log("Media selected");
    console.log(data);
     this.mediaSelected.next(data);
  }
}
