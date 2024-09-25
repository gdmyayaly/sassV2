import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ModulesClientComponent } from './modules-client.component';

describe('ModulesClientComponent', () => {
  let component: ModulesClientComponent;
  let fixture: ComponentFixture<ModulesClientComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [ModulesClientComponent]
    });
    fixture = TestBed.createComponent(ModulesClientComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
