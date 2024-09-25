import { ComponentFixture, TestBed } from '@angular/core/testing';

import { MenuWebComponent } from './menu-web.component';

describe('MenuWebComponent', () => {
  let component: MenuWebComponent;
  let fixture: ComponentFixture<MenuWebComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ MenuWebComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(MenuWebComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
