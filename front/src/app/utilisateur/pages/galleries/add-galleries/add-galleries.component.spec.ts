import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AddGalleriesComponent } from './add-galleries.component';

describe('AddGalleriesComponent', () => {
  let component: AddGalleriesComponent;
  let fixture: ComponentFixture<AddGalleriesComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [AddGalleriesComponent]
    });
    fixture = TestBed.createComponent(AddGalleriesComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
