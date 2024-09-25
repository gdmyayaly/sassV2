import { TestBed } from '@angular/core/testing';

import { SelectMediaService } from './select-media.service';

describe('SelectMediaService', () => {
  let service: SelectMediaService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(SelectMediaService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
