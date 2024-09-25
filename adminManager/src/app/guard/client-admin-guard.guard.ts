import { CanActivateFn } from '@angular/router';

export const clientAdminGuardGuard: CanActivateFn = (route, state) => {
  return true;
};
