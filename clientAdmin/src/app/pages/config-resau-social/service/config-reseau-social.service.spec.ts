import { TestBed } from '@angular/core/testing';

import { ConfigReseauSocialService } from './config-reseau-social.service';

describe('ConfigReseauSocialService', () => {
  let service: ConfigReseauSocialService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(ConfigReseauSocialService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
