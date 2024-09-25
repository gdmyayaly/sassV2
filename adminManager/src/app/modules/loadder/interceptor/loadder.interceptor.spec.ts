import { TestBed } from '@angular/core/testing';

import { LoadderInterceptor } from './loadder.interceptor';

describe('LoadderInterceptor', () => {
  beforeEach(() => TestBed.configureTestingModule({
    providers: [
      LoadderInterceptor
      ]
  }));

  it('should be created', () => {
    const interceptor: LoadderInterceptor = TestBed.inject(LoadderInterceptor);
    expect(interceptor).toBeTruthy();
  });
});
