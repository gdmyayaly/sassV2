import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AddSectionTypeComponent } from './add-section-type.component';

describe('AddSectionTypeComponent', () => {
  let component: AddSectionTypeComponent;
  let fixture: ComponentFixture<AddSectionTypeComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [AddSectionTypeComponent]
    });
    fixture = TestBed.createComponent(AddSectionTypeComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
