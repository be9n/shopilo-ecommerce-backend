import { SidebarGroup, SidebarGroupLabel, SidebarMenu } from '@/components/ui/sidebar';
import { routePathname } from '@/lib/utils';
import { type SidebarItem } from '@/types';
import { LayoutGrid, LockKeyhole } from 'lucide-react';
import CollapsibleSidebarItem from './custom/collapsible-sidebar-item';
import NormalSidebarItem from './custom/normal-sidebar-item';

const mainNavItems: SidebarItem[] = [
  {
    title: 'Dashboard',
    href: routePathname(route('admin.dashboard')),
    icon: LayoutGrid,
  },
  {
    title: 'Roles',
    icon: LockKeyhole,
    children: [
      {
        title: 'View All',
        href: routePathname(route('admin.roles.index')),
      },
      {
        title: 'Create Role',
        href: routePathname(route('admin.roles.create')),
      },
    ],
  },
];

export function NavMain() {
  return (
    <SidebarGroup className="px-2 py-0">
      <SidebarGroupLabel>Platform</SidebarGroupLabel>

      <SidebarMenu>
        {mainNavItems.map((item) => {
          if (item.children) return <CollapsibleSidebarItem key={item.title} item={item} />;

          return <NormalSidebarItem key={item.title} item={item} />;
        })}
      </SidebarMenu>
    </SidebarGroup>
  );
}
