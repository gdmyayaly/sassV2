import { ComponentFixture, TestBed } from '@angular/core/testing';

import { PagesWebComponent } from './pages-web.component';

describe('PagesWebComponent', () => {
  let component: PagesWebComponent;
  let fixture: ComponentFixture<PagesWebComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [PagesWebComponent]
    });
    fixture = TestBed.createComponent(PagesWebComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
