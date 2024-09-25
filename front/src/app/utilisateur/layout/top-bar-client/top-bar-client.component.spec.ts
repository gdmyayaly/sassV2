import { ComponentFixture, TestBed } from '@angular/core/testing';

import { TopBarClientComponent } from './top-bar-client.component';

describe('TopBarClientComponent', () => {
  let component: TopBarClientComponent;
  let fixture: ComponentFixture<TopBarClientComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [TopBarClientComponent]
    });
    fixture = TestBed.createComponent(TopBarClientComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
