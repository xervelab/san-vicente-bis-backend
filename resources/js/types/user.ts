// User roles and demo accounts configuration
export type UserRole = 'admin' | 'staff' | 'approver' | 'resident';

export interface DemoAccount {
  name: string;
  role: UserRole;
  roleName: string;
}

export const DEMO_ACCOUNTS: Record<string, DemoAccount> = {
  'admin@bisv.ph': { name: 'Ricardo Dela Cruz', role: 'admin', roleName: 'Administrator' },
  'staff@bisv.ph': { name: 'Maria Santos', role: 'staff', roleName: 'Barangay Staff' },
  'captain@bisv.ph': { name: 'Eduardo Reyes', role: 'approver', roleName: 'Barangay Captain' },
  'resident@bisv.ph': { name: 'Ana Bautista', role: 'resident', roleName: 'Resident' },
};

export const USER_ROLES = {
  ADMIN: 'admin' as const,
  STAFF: 'staff' as const,
  APPROVER: 'approver' as const,
  RESIDENT: 'resident' as const,
} as const;