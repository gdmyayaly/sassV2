import { TestBed } from '@angular/core/testing';
import { CanActivateFn } from '@angular/router';

import { clientAdminGuardGuard } from './client-admin-guard.guard';

describe('clientAdminGuardGuard', () => {
  const executeGuard: CanActivateFn = (...guardParameters) => 
      TestBed.runInInjectionContext(() => clientAdminGuardGuard(...guardParameters));

  beforeEach(() => {
    TestBed.configureTestingModule({});
  });

  it('should be created', () => {
    expect(executeGuard).toBeTruthy();
  });
});
