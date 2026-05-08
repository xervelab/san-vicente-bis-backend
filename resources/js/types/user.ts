// User roles and demo accounts configuration
export type UserRole = 'admin' | 'staff' | 'approver' | 'resident';

export type Permission = 
  | 'create_users' | 'read_users' | 'update_users' | 'delete_users'
  | 'approve_requests' | 'reject_requests' | 'view_pending_requests'
  | 'view_reports' | 'export_reports'
  | 'manage_roles' | 'manage_settings';

export interface Role {
  id: number;
  name: UserRole;
  display_name: string;
  description: string | null;
  permissions: Permission[];
}

export interface DemoAccount {
  name: string;
  role: UserRole;
  roleName: string;
}

export interface User {
  id: number;
  name: string;
  email: string;
  role: UserRole;
  role_name: string;
  created_at: string;
  updated_at: string;
}

export const DEMO_ACCOUNTS: Record<string, DemoAccount> = {
  'admin@bisv.ph': { name: 'Ricardo Dela Cruz', role: 'admin', roleName: 'Administrator' },
  'staff@bisv.ph': { name: 'Maria Santos', role: 'staff', roleName: 'Barangay Staff' },
  'captain@bisv.ph': { name: 'Eduardo Reyes', role: 'approver', roleName: 'Barangay Captain' },
  'resident@bisv.ph': { name: 'Ana Bautista', role: 'resident', roleName: 'Resident' },
};

export const USER_ROLES: Record<UserRole, { name: UserRole; displayName: string }> = {
  admin: { name: 'admin', displayName: 'Administrator' },
  staff: { name: 'staff', displayName: 'Barangay Staff' },
  approver: { name: 'approver', displayName: 'Barangay Captain' },
  resident: { name: 'resident', displayName: 'Resident' },
} as const;

export const PERMISSIONS: Record<string, { name: Permission; displayName: string }> = {
  CREATE_USERS: { name: 'create_users', displayName: 'Create Users' },
  READ_USERS: { name: 'read_users', displayName: 'Read Users' },
  UPDATE_USERS: { name: 'update_users', displayName: 'Update Users' },
  DELETE_USERS: { name: 'delete_users', displayName: 'Delete Users' },
  APPROVE_REQUESTS: { name: 'approve_requests', displayName: 'Approve Requests' },
  REJECT_REQUESTS: { name: 'reject_requests', displayName: 'Reject Requests' },
  VIEW_PENDING_REQUESTS: { name: 'view_pending_requests', displayName: 'View Pending Requests' },
  VIEW_REPORTS: { name: 'view_reports', displayName: 'View Reports' },
  EXPORT_REPORTS: { name: 'export_reports', displayName: 'Export Reports' },
  MANAGE_ROLES: { name: 'manage_roles', displayName: 'Manage Roles' },
  MANAGE_SETTINGS: { name: 'manage_settings', displayName: 'Manage Settings' },
} as const;

export const ROLE_DISPLAY_NAMES: Record<UserRole, string> = {
  admin: 'Administrator',
  staff: 'Barangay Staff',
  approver: 'Barangay Captain',
  resident: 'Resident',
};