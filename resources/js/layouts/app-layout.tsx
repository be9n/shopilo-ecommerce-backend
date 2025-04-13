import AppLayoutTemplate from '@/layouts/app/app-sidebar-layout';
import { type BreadcrumbItem, type SharedData } from '@/types';
import { ToastType, toastTypes } from '@/types/alert-types';
import { usePage } from '@inertiajs/react';
import { useEffect, type ReactNode } from 'react';
import { toast } from 'sonner';

interface AppLayoutProps {
  children: ReactNode;
  breadcrumbs?: BreadcrumbItem[];
}

export default ({ children, breadcrumbs, ...props }: AppLayoutProps) => {
  const { alert } = usePage<SharedData>().props.flash;

  useEffect(() => {
    if (alert) {
      if (toastTypes.includes(alert.type)) {
        toast[alert.type as ToastType](alert.message);
      } else {
        console.warn(`Unknown toast type: ${alert.type}`);
        toast.info(alert.message);
      }
    }
  }, [alert]);

  return (
    <AppLayoutTemplate breadcrumbs={breadcrumbs} {...props}>
      {children}
    </AppLayoutTemplate>
  );
};
