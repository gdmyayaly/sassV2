import { ComponentFixture, TestBed } from '@angular/core/testing';
import { ConfigWebsitePage } from './config-website.page';

describe('ConfigWebsitePage', () => {
  let component: ConfigWebsitePage;
  let fixture: ComponentFixture<ConfigWebsitePage>;

  beforeEach(async(() => {
    fixture = TestBed.createComponent(ConfigWebsitePage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  }));

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
