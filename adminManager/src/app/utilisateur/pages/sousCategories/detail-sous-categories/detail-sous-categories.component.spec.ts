import { ComponentFixture, TestBed } from '@angular/core/testing';

import { DetailSousCategoriesComponent } from './detail-sous-categories.component';

describe('DetailSousCategoriesComponent', () => {
  let component: DetailSousCategoriesComponent;
  let fixture: ComponentFixture<DetailSousCategoriesComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [DetailSousCategoriesComponent]
    });
    fixture = TestBed.createComponent(DetailSousCategoriesComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
