import { ComponentFixture, TestBed } from '@angular/core/testing';

import { DetailGalleriesComponent } from './detail-galleries.component';

describe('DetailGalleriesComponent', () => {
  let component: DetailGalleriesComponent;
  let fixture: ComponentFixture<DetailGalleriesComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [DetailGalleriesComponent]
    });
    fixture = TestBed.createComponent(DetailGalleriesComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
