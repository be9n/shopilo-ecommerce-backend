import { SidebarItem } from '@/types';
import { Link, usePage } from '@inertiajs/react';
import { ChevronRight } from 'lucide-react';
import { Collapsible, CollapsibleContent, CollapsibleTrigger } from '../ui/collapsible';
import { SidebarMenuButton, SidebarMenuItem, SidebarMenuSub, SidebarMenuSubButton, SidebarMenuSubItem } from '../ui/sidebar';

export default function CollapsibleSidebarItem({ item }: { item: SidebarItem }) {
  const page = usePage();
  const isOpen = item.children?.some((child) => page.url.startsWith(child.href));
  

  return (
    <Collapsible defaultOpen={isOpen} className="group/collapsible">
      <SidebarMenuItem>
        <CollapsibleTrigger asChild>
          <SidebarMenuButton asChild tooltip={{ children: item.title }}>
            <div className="cursor-pointer">
              {item.icon && <item.icon />}
              <span>{item.title}</span>
              <ChevronRight className={'ms-auto transition-transform group-data-[state=open]/collapsible:rotate-90'} />
            </div>
          </SidebarMenuButton>
        </CollapsibleTrigger>

        <CollapsibleContent>
          <SidebarMenuSub>
            {(item.children ?? []).length > 0 &&
              item.children?.map((child) => (
                <SidebarMenuSubItem key={child.title}>
                  <SidebarMenuSubButton asChild isActive={page.url.startsWith(child.href)}>
                    <Link href={child.href} prefetch>
                      <span>{child.title}</span>
                    </Link>
                  </SidebarMenuSubButton>
                </SidebarMenuSubItem>
              ))}
          </SidebarMenuSub>
        </CollapsibleContent>
      </SidebarMenuItem>
    </Collapsible>
  );
}
