import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ModulesStoreComponent } from './modules-store.component';

describe('ModulesStoreComponent', () => {
  let component: ModulesStoreComponent;
  let fixture: ComponentFixture<ModulesStoreComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [ModulesStoreComponent]
    });
    fixture = TestBed.createComponent(ModulesStoreComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
