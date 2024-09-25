import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ListSousCategoriesComponent } from './list-sous-categories.component';

describe('ListSousCategoriesComponent', () => {
  let component: ListSousCategoriesComponent;
  let fixture: ComponentFixture<ListSousCategoriesComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [ListSousCategoriesComponent]
    });
    fixture = TestBed.createComponent(ListSousCategoriesComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
