import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AddSousCategoriesComponent } from './add-sous-categories.component';

describe('AddSousCategoriesComponent', () => {
  let component: AddSousCategoriesComponent;
  let fixture: ComponentFixture<AddSousCategoriesComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [AddSousCategoriesComponent]
    });
    fixture = TestBed.createComponent(AddSousCategoriesComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
