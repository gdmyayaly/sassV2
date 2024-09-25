import { TestBed } from '@angular/core/testing';

import { PreviewMediaService } from './preview-media.service';

describe('PreviewMediaService', () => {
  let service: PreviewMediaService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(PreviewMediaService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
