import { ComponentFixture, TestBed } from '@angular/core/testing';
import { ListGaleriePage } from './list-galerie.page';

describe('ListGaleriePage', () => {
  let component: ListGaleriePage;
  let fixture: ComponentFixture<ListGaleriePage>;

  beforeEach(async(() => {
    fixture = TestBed.createComponent(ListGaleriePage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  }));

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
