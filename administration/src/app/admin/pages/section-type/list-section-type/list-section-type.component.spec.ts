import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ListSectionTypeComponent } from './list-section-type.component';

describe('ListSectionTypeComponent', () => {
  let component: ListSectionTypeComponent;
  let fixture: ComponentFixture<ListSectionTypeComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [ListSectionTypeComponent]
    });
    fixture = TestBed.createComponent(ListSectionTypeComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
