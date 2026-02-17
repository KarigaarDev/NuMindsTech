<?php
require_once __DIR__ . '/BaseController.php';

/**
 * PortfolioController
 * Handles portfolio item management
 */
class PortfolioController extends BaseController {

    /**
     * Get all portfolio items
     */
    public function index() {
        $this->requireAuth();
        $this->requireAdmin();

        $items = $this->getAllItems();

        $this->render('dashboard/items', [
            'title' => 'Portfolio Items',
            'items' => $items
        ]);
    }

    /**
     * Show portfolio management page
     */
    public function manage() {
        $this->requireAuth();
        $this->requireAdmin();

        $items = $this->getAllItems();

        $this->render('dashboard/portfolio', [
            'title' => 'Manage Portfolio',
            'items' => $items
        ]);
    }

    /**
     * Get paginated portfolio items for public API
     */
    public function getPublicPaginated($page = 1, $perPage = 4) {
        $offset = (int)(($page - 1) * $perPage);
        $perPage = (int)$perPage;

        $stmt = $this->pdo->query("
            SELECT * FROM portfolio_items
            WHERE status = 'published'
            ORDER BY display_order ASC, created_at DESC
            LIMIT $perPage OFFSET $offset
        ");
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Check if there are more items
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM portfolio_items WHERE status = 'published'");
        $total = $stmt->fetchColumn();
        $hasMore = ($offset + $perPage) < $total;

        return [
            'items' => $items,
            'has_more' => $hasMore,
            'total' => $total
        ];
    }

    /**
     * Get featured portfolio items
     */
    public function getFeatured($limit = 4) {
        // Cast limit to integer (LIMIT cannot be parameterized in prepared statements)
        $limit = (int)$limit;
        $stmt = $this->pdo->query("
            SELECT * FROM portfolio_items
            WHERE status = 'published' AND is_featured = 1
            ORDER BY display_order ASC, created_at DESC
            LIMIT $limit
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Create new portfolio item
     */
    public function create($data) {
        $this->requireAuth();
        $this->requireAdmin();

        $stmt = $this->pdo->prepare("
            INSERT INTO portfolio_items
            (title, description, client_name, featured_image, gallery_images, category, tags, project_url, completion_date, status, is_featured, display_order)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $result = $stmt->execute([
            $data['title'],
            $data['description'] ?? null,
            $data['client_name'] ?? null,
            $data['featured_image'] ?? null,
            $data['gallery_images'] ?? null,
            $data['category'] ?? 'Web Design',
            $data['tags'] ?? null,
            $data['project_url'] ?? null,
            $data['completion_date'] ?? null,
            $data['status'] ?? 'published',
            $data['is_featured'] ?? 0,
            $data['display_order'] ?? 0
        ]);

        // Log the creation
        if ($result) {
            Logger::adminAction($this->userId, 'CREATE_PORTFOLIO_ITEM', 'Created new portfolio item: ' . $data['title'], [
                'title' => $data['title'],
                'client_name' => $data['client_name'] ?? 'N/A',
                'status' => $data['status'] ?? 'published'
            ]);
        }

        return $result;
    }

    /**
     * Update portfolio item
     */
    public function update($itemId, $data) {
        $this->requireAuth();
        $this->requireAdmin();

        $stmt = $this->pdo->prepare("
            UPDATE portfolio_items
            SET title = ?, description = ?, client_name = ?, featured_image = ?,
                gallery_images = ?, category = ?, tags = ?, project_url = ?,
                completion_date = ?, status = ?, is_featured = ?, display_order = ?,
                updated_at = NOW()
            WHERE id = ?
        ");

        $result = $stmt->execute([
            $data['title'],
            $data['description'] ?? null,
            $data['client_name'] ?? null,
            $data['featured_image'] ?? null,
            $data['gallery_images'] ?? null,
            $data['category'] ?? 'Web Design',
            $data['tags'] ?? null,
            $data['project_url'] ?? null,
            $data['completion_date'] ?? null,
            $data['status'] ?? 'published',
            $data['is_featured'] ?? 0,
            $data['display_order'] ?? 0,
            $itemId
        ]);

        // Log the update
        if ($result) {
            Logger::adminAction($this->userId, 'UPDATE_PORTFOLIO_ITEM', 'Updated portfolio item: ' . $data['title'], [
                'item_id' => $itemId,
                'title' => $data['title'],
                'status' => $data['status'] ?? 'published'
            ]);
        }

        return $result;
    }

    /**
     * Delete portfolio item
     */
    public function delete($itemId) {
        $this->requireAuth();
        $this->requireAdmin();

        // Get item info before deleting for logging
        $item = $this->getItem($itemId);
        
        $stmt = $this->pdo->prepare("DELETE FROM portfolio_items WHERE id = ?");
        $result = $stmt->execute([$itemId]);

        // Log the deletion
        if ($result && $item) {
            Logger::adminAction($this->userId, 'DELETE_PORTFOLIO_ITEM', 'Deleted portfolio item: ' . $item['title'], [
                'item_id' => $itemId,
                'item_title' => $item['title'],
                'client_name' => $item['client_name']
            ]);
        }

        return $result;
    }

    /**
     * Get single portfolio item
     */
    private function getItem($itemId) {
        $stmt = $this->pdo->prepare("SELECT * FROM portfolio_items WHERE id = ?");
        $stmt->execute([$itemId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get all portfolio items
     */
    private function getAllItems() {
        $stmt = $this->pdo->query("
            SELECT * FROM portfolio_items
            ORDER BY display_order ASC, created_at DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
