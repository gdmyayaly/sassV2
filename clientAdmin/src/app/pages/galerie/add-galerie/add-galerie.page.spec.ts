import { ComponentFixture, TestBed } from '@angular/core/testing';
import { AddGaleriePage } from './add-galerie.page';

describe('AddGaleriePage', () => {
  let component: AddGaleriePage;
  let fixture: ComponentFixture<AddGaleriePage>;

  beforeEach(async(() => {
    fixture = TestBed.createComponent(AddGaleriePage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  }));

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
