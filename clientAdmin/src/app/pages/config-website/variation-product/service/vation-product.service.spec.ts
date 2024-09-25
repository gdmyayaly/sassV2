import { TestBed } from '@angular/core/testing';

import { VationProductService } from './vation-product.service';

describe('VationProductService', () => {
  let service: VationProductService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(VationProductService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
