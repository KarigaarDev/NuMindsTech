<?php
/**
 * Architecture Improvements Documentation
 * 
 * This file documents the code quality improvements made to the NuMinds Tech codebase.
 * 
 * ============================================================================
 * 1. ENHANCED ROUTER CLASS
 * ============================================================================
 * 
 * The Router class now includes:
 * - Proper URL routing with pattern matching
 * - Support for route parameters (e.g., /users/{id})
 * - HTTP method routing (GET, POST, etc.)
 * - Middleware support for cross-cutting concerns
 * - Route parameter extraction and passing
 * 
 * Usage:
 * 
 *   Router::init('/numindsTech');  // Initialize with base URL
 *   Router::get('/users/{id}', 'UserController@show');
 *   Router::post('/users', 'UserController@store');
 *   Router::middleware('/admin', 'requireAdmin');
 *   Router::dispatch();  // Match current request and dispatch
 * 
 * The Router::view() function still works for simple view rendering:
 * 
 *   Router::view('dashboard/home', ['title' => 'Dashboard']);
 * 
 * ============================================================================
 * 2. CENTRALIZED TAILWIND CONFIGURATION
 * ============================================================================
 * 
 * Previously, Tailwind configuration was duplicated across multiple files:
 * - public/index.php
 * - public/login.php
 * - app/views/header.php
 * - app/views/dashboard/layout.php
 * 
 * Now, all Tailwind configuration is centralized in:
 * - app/config/tailwind.php
 * 
 * This file is included in all layout files, ensuring:
 * - Consistency across the entire application
 * - Easy maintenance and updates
 * - Reduced code duplication
 * - Single source of truth for styling
 * 
 * To include the Tailwind config in any HTML file:
 * 
 *   <?php require __DIR__ . '/../config/tailwind.php'; ?>
 * 
 * ============================================================================
 * 3. SEPARATED BUSINESS LOGIC FROM VIEWS
 * ============================================================================
 * 
 * Controllers have been introduced to separate business logic from views.
 * 
 * Controller Directory:
 * - app/controllers/BaseController.php
 * - app/controllers/DashboardController.php
 * - app/controllers/ClientPortalController.php
 * - app/controllers/LeadsController.php
 * - app/controllers/PortfolioController.php
 * 
 * BEFORE (Mix of logic and presentation in public/dashboard.php):
 * 
 *   $title = 'Dashboard';
 *   require '../app/views/dashboard/layout.php';
 * 
 * AFTER (Separation of concerns):
 * 
 *   $controller = new DashboardController($pdo);
 *   $controller->overview();  // Handles all logic and rendering
 * 
 * ============================================================================
 * 3.1 BASE CONTROLLER
 * ============================================================================
 * 
 * All controllers extend BaseController, providing common functionality:
 * - PDO instance management
 * - Authentication checking (requireAuth(), requireAdmin())
 * - User data retrieval
 * - View rendering
 * 
 * Example:
 * 
 *   class MyController extends BaseController {
 *       public function index() {
 *           $this->requireAuth();      // Ensure user is logged in
 *           $this->requireAdmin();     // Ensure user is admin
 *           
 *           $data = $this->getPublicData();
 *           
 *           $this->render('dashboard/page', ['data' => $data]);
 *       }
 *   }
 * 
 * ============================================================================
 * 3.2 DASHBOARD CONTROLLER
 * ============================================================================
 * 
 * Handles admin dashboard operations:
 * - overview()        → Display admin dashboard with statistics
 * 
 * Methods for data retrieval:
 * - getTotalUsers()   → Get user count
 * - getTotalPortfolioItems() → Get published portfolio count
 * - getTotalLeads()   → Get leads count
 * - getTotalServices() → Get active services count
 * - getRecentLeads($limit) → Get recent leads
 * 
 * Usage in public/dashboard.php:
 * 
 *   $controller = new DashboardController($pdo);
 *   $controller->overview();
 * 
 * ============================================================================
 * 3.3 CLIENT PORTAL CONTROLLER
 * ============================================================================
 * 
 * Handles client portal operations:
 * - index()           → Display client dashboard
 * 
 * Methods for data retrieval:
 * - getClientWebsites($userId)  → Get user's websites
 * - getClientServices($userId)  → Get user's services
 * - getClientInvoices($userId)  → Get user's invoices
 * 
 * Usage in public/client-dashboard.php:
 * 
 *   $controller = new ClientPortalController($pdo);
 *   $controller->index();
 * 
 * ============================================================================
 * 3.4 LEADS CONTROLLER
 * ============================================================================
 * 
 * Handles lead management:
 * - index()            → Display all leads (admin only)
 * - show($leadId)      → Display lead details (admin only)
 * - store($data)       → Create new lead from form submission
 * - addRemark($leadId, $remark) → Add remark to lead
 * - search($keyword)   → Search leads by keyword
 * 
 * Usage in admin/leads.php:
 * 
 *   $controller = new LeadsController($pdo);
 *   $controller->index();
 * 
 * Usage in public/submit-lead.php:
 * 
 *   Csrf::verify();
 *   $controller = new LeadsController($pdo);
 *   $controller->store($_POST);
 *   redirect('?sent=1');
 * 
 * ============================================================================
 * 3.5 PORTFOLIO CONTROLLER
 * ============================================================================
 * 
 * Handles portfolio management:
 * - index()                      → Display all items (admin only)
 * - manage()                     → Display portfolio management page
 * - getPublicPaginated($page, $perPage) → Get paginated items for API
 * - getFeatured($limit)          → Get featured items
 * - create($data)                → Create new item (admin only)
 * - update($itemId, $data)       → Update item (admin only)
 * - delete($itemId)              → Delete item (admin only)
 * 
 * Usage in public/api/items.php:
 * 
 *   $controller = new PortfolioController($pdo);
 *   $result = $controller->getPublicPaginated($page, $perPage);
 *   echo json_encode(['success' => true, 'items' => $result['items']]);
 * 
 * ============================================================================
 * 4. BENEFITS OF THESE CHANGES
 * ============================================================================
 * 
 * ✓ Code Reusability
 *   - Controller methods can be used from multiple pages
 *   - No code duplication between views
 * 
 * ✓ Maintainability
 *   - Business logic separated from presentation
 *   - Easy to locate and update data handling
 *   - Clear separation of concerns
 * 
 * ✓ Testability
 *   - Controllers can be unit tested independently
 *   - Mock database and dependencies
 * 
 * ✓ Consistency
 *   - Single Tailwind config ensures consistent styling
 *   - Common authentication/authorization patterns
 * 
 * ✓ Scalability
 *   - Easy to add new controllers for new features
 *   - Router provides foundation for building more complex routing
 * 
 * ============================================================================
 * 5. FURTHER IMPROVEMENTS TO CONSIDER
 * ============================================================================
 * 
 * - Implement a proper routing file (routes.php) to define all routes
 * - Add request/response classes for better data handling
 * - Implement a service layer for complex business operations
 * - Add repository pattern for data access
 * - Implement dependency injection container
 * - Add comprehensive logging and error handling
 * - Create unit tests for all controllers
 * 
 * ============================================================================
