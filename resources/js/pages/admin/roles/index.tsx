import DeleteButtonWithDialog from '@/components/custom/DeleteActionButton';
import DeleteDialog from '@/components/custom/DeleteDialog';
import CustomPagination, { Pagination } from '@/components/custom/pagination';
import { Button } from '@/components/ui/button';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/app-layout';
import { BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/react';

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Roles',
    href: route('admin.roles.index'),
  },
];

type Role = {
  id: number;
  title: string;
  permissions_count: number;
};

export default function Index({
  roles,
}: {
  roles: {
    data: Role[];
    pagination: Pagination;
  };
}) {
  return (
    <AppLayout breadcrumbs={breadcrumbs}>
      <Head title="Roles" />
      <div className="p-4">
        <Table>
          <TableHeader>
            <TableRow>
              <TableHead className="w-[100px]">ID</TableHead>
              <TableHead>Title</TableHead>
              <TableHead>Permissions Count</TableHead>
              <TableHead>Actions</TableHead>
            </TableRow>
          </TableHeader>
          <TableBody>
            {roles.data.length > 0 &&
              roles.data.map((role) => (
                <TableRow key={role.id}>
                  <TableCell className="font-medium">{role.id}</TableCell>
                  <TableCell>{role.title}</TableCell>
                  <TableCell>{role.permissions_count}</TableCell>
                  <TableCell>
                    <div className="flex gap-2">
                      <Button asChild size={'sm'}>
                        <Link href={route('admin.roles.edit', role.id)}>Edit</Link>
                      </Button>
                      <DeleteButtonWithDialog route={route('admin.roles.destroy', role.id)} />
                    </div>
                  </TableCell>
                </TableRow>
              ))}
          </TableBody>
        </Table>

        <div className="mx-auto mt-2 w-full">
          <CustomPagination paginationInfo={roles.pagination} />
        </div>
      </div>

      <DeleteDialog />
    </AppLayout>
  );
}
