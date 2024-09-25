import { ComponentFixture, TestBed } from '@angular/core/testing';

import { HomeUtilisateurComponent } from './home-utilisateur.component';

describe('HomeUtilisateurComponent', () => {
  let component: HomeUtilisateurComponent;
  let fixture: ComponentFixture<HomeUtilisateurComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [HomeUtilisateurComponent]
    });
    fixture = TestBed.createComponent(HomeUtilisateurComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
