import { Component, OnDestroy, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { AuthService } from './service/auth.service';

@Component({
  selector: 'app-auth',
  templateUrl: './auth.component.html',
  styleUrls: ['./auth.component.css']
})
export class AuthComponent implements OnInit, OnDestroy{
  public authForm= new FormGroup({
    username: new FormControl('',Validators.required),
    password: new FormControl('',Validators.required)
  });
  public reponse:any;

  constructor(private authService:AuthService){}
  ngOnInit(): void {
    
  }
  ngOnDestroy(): void {
    
  }
  seLogger(){
    this.authService.loggin(this.authForm.value).subscribe(
      res=>{
        this.reponse=res.body;
        this.authService.enregistrementToken(this.reponse.token)
      },
      error=>{
        console.log(error);
      }
    )
  }
}
