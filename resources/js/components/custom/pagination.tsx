import {
  Pagination,
  PaginationContent,
  PaginationEllipsis,
  PaginationItem,
  PaginationLink,
  PaginationNext,
  PaginationPrevious,
} from '../ui/pagination';

export type Pagination = {
  current_page: number;
  next_page: number | null;
  prev_page: number | null;
  last_page: number;
  per_page: number;
  total_records: number;
  has_pages: boolean;
  has_next_page: boolean;
  has_prev_page: boolean;
  from: number;
  to: number;
  path: string;
};

export default function CustomPagination({ paginationInfo }: { paginationInfo: Pagination }) {
  if (!paginationInfo.has_pages) {
    return null;
  }

  const createPageUrl = (pageNumber: number | null) => {
    if (!pageNumber) return '';

    const params = new URLSearchParams(location.search);
    params.set('page', pageNumber.toString());

    return `${paginationInfo.path}?${params.toString()}`;
  };

  const isNextDisabled = !paginationInfo.has_next_page;
  const isPrevDisabled = !paginationInfo.has_prev_page;

  return (
    <Pagination>
      <PaginationContent>
        <PaginationItem>
          <PaginationPrevious
            as={isPrevDisabled ? 'button' : 'a'}
            preserveScroll
            preserveState
            href={createPageUrl(paginationInfo.prev_page)}
            disabled={!paginationInfo.has_prev_page}
            className="cursor-pointer disabled:pointer-events-none disabled:cursor-not-allowed disabled:opacity-50"
          />
        </PaginationItem>
        <PaginationItem>
          <PaginationLink href="#">1</PaginationLink>
        </PaginationItem>
        <PaginationItem>
          <PaginationEllipsis />
        </PaginationItem>
        <PaginationItem>
          <PaginationNext
            as={isNextDisabled ? 'button' : 'a'}
            preserveScroll
            preserveState
            href={createPageUrl(paginationInfo.next_page)}
            disabled={!paginationInfo.has_next_page}
            className="cursor-pointer disabled:pointer-events-none disabled:cursor-not-allowed disabled:opacity-50"
          />
        </PaginationItem>
      </PaginationContent>
    </Pagination>
  );
}
