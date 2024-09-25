import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ListGalleriesComponent } from './list-galleries.component';

describe('ListGalleriesComponent', () => {
  let component: ListGalleriesComponent;
  let fixture: ComponentFixture<ListGalleriesComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [ListGalleriesComponent]
    });
    fixture = TestBed.createComponent(ListGalleriesComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
