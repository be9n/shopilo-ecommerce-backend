import { SidebarItem } from '@/types';
import { Link, usePage } from '@inertiajs/react';
import { SidebarMenuButton, SidebarMenuItem } from '../ui/sidebar';

export default function NormalSidebarItem({ item }: { item: SidebarItem }) {
  const page = usePage();
  return (
    <SidebarMenuItem>
      <SidebarMenuButton asChild isActive={item.href === page.url} tooltip={{ children: item.title }}>
        <Link href={item.href ?? '#'} className="cursor-pointer">
          {item.icon && <item.icon />}
          <span>{item.title}</span>
        </Link>
      </SidebarMenuButton>
    </SidebarMenuItem>
  );
}
