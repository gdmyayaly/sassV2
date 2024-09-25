import { TestBed } from '@angular/core/testing';

import { PageWebService } from './page-web.service';

describe('PageWebService', () => {
  let service: PageWebService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(PageWebService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
