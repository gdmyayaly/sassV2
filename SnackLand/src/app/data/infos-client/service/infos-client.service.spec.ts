import { TestBed } from '@angular/core/testing';

import { InfosClientService } from './infos-client.service';

describe('InfosClientService', () => {
  let service: InfosClientService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(InfosClientService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
