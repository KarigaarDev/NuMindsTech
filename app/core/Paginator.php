<?php
/**
 * Paginator Class
 * Handles pagination logic for lists and searches
 */
class Paginator {
    private $currentPage;
    private $perPage;
    private $totalItems;
    private $totalPages;
    private $offset;

    /**
     * Constructor
     * 
     * @param int $totalItems Total number of items
     * @param int $perPage Items per page (default: 20)
     * @param int $currentPage Current page number (default: 1)
     */
    public function __construct($totalItems, $perPage = 20, $currentPage = 1) {
        $this->totalItems = $totalItems;
        $this->perPage = max(1, $perPage);
        $this->currentPage = max(1, (int)$currentPage);
        $this->totalPages = ceil($totalItems / $this->perPage);
        
        // Ensure current page doesn't exceed total pages
        if ($this->currentPage > $this->totalPages && $this->totalPages > 0) {
            $this->currentPage = $this->totalPages;
        }

        $this->offset = ($this->currentPage - 1) * $this->perPage;
    }

    /**
     * Get the offset for database LIMIT clause
     */
    public function offset() {
        return $this->offset;
    }

    /**
     * Get the limit for database LIMIT clause
     */
    public function limit() {
        return $this->perPage;
    }

    /**
     * Get current page number
     */
    public function currentPage() {
        return $this->currentPage;
    }

    /**
     * Get items per page
     */
    public function perPage() {
        return $this->perPage;
    }

    /**
     * Get total number of items
     */
    public function totalItems() {
        return $this->totalItems;
    }

    /**
     * Get total number of pages
     */
    public function totalPages() {
        return $this->totalPages;
    }

    /**
     * Check if there are more pages
     */
    public function hasPages() {
        return $this->totalPages > 1;
    }

    /**
     * Check if on first page
     */
    public function isFirstPage() {
        return $this->currentPage === 1;
    }

    /**
     * Check if on last page
     */
    public function isLastPage() {
        return $this->currentPage >= $this->totalPages;
    }

    /**
     * Get next page number
     */
    public function nextPage() {
        return min($this->currentPage + 1, $this->totalPages);
    }

    /**
     * Get previous page number
     */
    public function previousPage() {
        return max($this->currentPage - 1, 1);
    }

    /**
     * Get page range for display (e.g., items 1-20 of 100)
     */
    public function range() {
        $start = $this->offset + 1;
        $end = min($this->offset + $this->perPage, $this->totalItems);
        return [
            'start' => $start,
            'end' => $end,
            'total' => $this->totalItems
        ];
    }

    /**
     * Get range text (e.g., "Showing 1-20 of 100")
     */
    public function rangeText() {
        $range = $this->range();
        return "Showing {$range['start']}-{$range['end']} of {$range['total']}";
    }

    /**
     * Get array of page numbers for pagination display
     * Shows current page ±2 pages
     */
    public function pageNumbers($window = 2) {
        $pages = [];
        $start = max(1, $this->currentPage - $window);
        $end = min($this->totalPages, $this->currentPage + $window);

        // Add first page and ellipsis if needed
        if ($start > 1) {
            $pages[] = 1;
            if ($start > 2) {
                $pages[] = '...';
            }
        }

        // Add page range
        for ($i = $start; $i <= $end; $i++) {
            $pages[] = $i;
        }

        // Add ellipsis and last page if needed
        if ($end < $this->totalPages) {
            if ($end < $this->totalPages - 1) {
                $pages[] = '...';
            }
            $pages[] = $this->totalPages;
        }

        return $pages;
    }

    /**
     * Get query string for pagination links
     * Preserves existing query parameters
     */
    public static function queryString($page, $perPage = null) {
        $params = $_GET;
        $params['page'] = $page;
        if ($perPage !== null) {
            $params['per_page'] = $perPage;
        }
        return http_build_query($params);
    }

    /**
     * Get first item number on current page
     */
    public function firstItemNumber() {
        return $this->totalItems > 0 ? $this->offset + 1 : 0;
    }

    /**
     * Get last item number on current page
     */
    public function lastItemNumber() {
        return min($this->offset + $this->perPage, $this->totalItems);
    }

    /**
     * Check if pagination is needed
     */
    public function needsPagination() {
        return $this->totalItems > $this->perPage;
    }
}
