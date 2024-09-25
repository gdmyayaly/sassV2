import { ComponentFixture, TestBed } from '@angular/core/testing';
import { ConfigResauSocialPage } from './config-resau-social.page';

describe('ConfigResauSocialPage', () => {
  let component: ConfigResauSocialPage;
  let fixture: ComponentFixture<ConfigResauSocialPage>;

  beforeEach(async(() => {
    fixture = TestBed.createComponent(ConfigResauSocialPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  }));

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
