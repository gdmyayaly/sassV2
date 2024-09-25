import { TestBed } from '@angular/core/testing';

import { SectionWebsiteService } from './section-website.service';

describe('SectionWebsiteService', () => {
  let service: SectionWebsiteService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(SectionWebsiteService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
