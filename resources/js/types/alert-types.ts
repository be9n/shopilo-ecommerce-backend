export const toastTypes = ['success', 'error', 'info', 'warning'] as const;
export type ToastType = (typeof toastTypes)[number];

export interface Alert {
  type: ToastType;
  message: string;
}
