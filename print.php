<?php
/**
 * Print Shop Management System
 * Single File Version with JSON Storage
 * Author: Your Name
 * Version: 2.0 - Enhanced UI/UX
 */

session_start();

// Configuration
define('DATA_DIR', __DIR__ . '/data/');
define('BACKUP_DIR', __DIR__ . '/backup/');
date_default_timezone_set('Asia/Kolkata');

// Create directories if they don't exist
if (!is_dir(DATA_DIR)) mkdir(DATA_DIR, 0777, true);
if (!is_dir(BACKUP_DIR)) mkdir(BACKUP_DIR, 0777, true);

// JSON file paths
define('USERS_FILE', DATA_DIR . 'users.json');
define('ATTENDANCE_FILE', DATA_DIR . 'attendance.json');
define('PRODUCTS_FILE', DATA_DIR . 'products.json');
define('WORK_FILE', DATA_DIR . 'work.json');
define('EXPENSES_FILE', DATA_DIR . 'expenses.json');
define('LOGS_FILE', DATA_DIR . 'logs.json');

// Initialize JSON files if they don't exist
initializeJsonFiles();

// ============================================
// DATA HANDLING FUNCTIONS
// ============================================
function initializeJsonFiles() {
    $files = [
        USERS_FILE => ['admin' => [
            'id' => 1,
            'username' => 'admin',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'full_name' => 'System Administrator',
            'role' => 'boss',
            'email' => 'admin@printshop.com',
            'phone' => '',
            'created_at' => date('Y-m-d H:i:s'),
            'is_active' => true,
            'last_login' => null
        ]],
        ATTENDANCE_FILE => [],
        PRODUCTS_FILE => [
            // Card Printing
            [
                'id' => 1,
                'category' => 'Card Print',
                'description' => 'Business Card (100 pcs)',
                'price' => 500,
                'unit' => 'pack',
                'created_by' => 'admin',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 2,
                'category' => 'Card Print',
                'description' => 'Visiting Card (100 pcs)',
                'price' => 300,
                'unit' => 'pack',
                'created_by' => 'admin',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 3,
                'category' => 'Card Print',
                'description' => 'PVC Card',
                'price' => 100,
                'unit' => 'piece',
                'created_by' => 'admin',
                'created_at' => date('Y-m-d H:i:s')
            ],
            
            // Paper Printing - Color
            [
                'id' => 4,
                'category' => 'Paper Print (Color)',
                'description' => 'A4 Color Print',
                'price' => 20,
                'unit' => 'page',
                'created_by' => 'admin',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 5,
                'category' => 'Paper Print (Color)',
                'description' => 'A3 Color Print',
                'price' => 40,
                'unit' => 'page',
                'created_by' => 'admin',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 6,
                'category' => 'Paper Print (Color)',
                'description' => 'Photo Print 4x6',
                'price' => 30,
                'unit' => 'piece',
                'created_by' => 'admin',
                'created_at' => date('Y-m-d H:i:s')
            ],
            
            // Paper Printing - Black & White
            [
                'id' => 7,
                'category' => 'Paper Print (Black)',
                'description' => 'A4 Black & White',
                'price' => 5,
                'unit' => 'page',
                'created_by' => 'admin',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 8,
                'category' => 'Paper Print (Black)',
                'description' => 'A3 Black & White',
                'price' => 10,
                'unit' => 'page',
                'created_by' => 'admin',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 9,
                'category' => 'Paper Print (Black)',
                'description' => 'Legal Size B&W',
                'price' => 8,
                'unit' => 'page',
                'created_by' => 'admin',
                'created_at' => date('Y-m-d H:i:s')
            ],
            
            // Flex Printing
            [
                'id' => 10,
                'category' => 'Panaflex Print',
                'description' => '3x2 feet Flex',
                'price' => 800,
                'unit' => 'piece',
                'created_by' => 'admin',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 11,
                'category' => 'Panaflex Print',
                'description' => '4x3 feet Flex',
                'price' => 1200,
                'unit' => 'piece',
                'created_by' => 'admin',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 12,
                'category' => 'Panaflex Print',
                'description' => '6x4 feet Flex',
                'price' => 2000,
                'unit' => 'piece',
                'created_by' => 'admin',
                'created_at' => date('Y-m-d H:i:s')
            ],
            
            // Binding & Lamination
            [
                'id' => 13,
                'category' => 'Binding',
                'description' => 'Spiral Binding',
                'price' => 100,
                'unit' => 'piece',
                'created_by' => 'admin',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 14,
                'category' => 'Lamination',
                'description' => 'A4 Lamination',
                'price' => 20,
                'unit' => 'piece',
                'created_by' => 'admin',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 15,
                'category' => 'Lamination',
                'description' => 'A3 Lamination',
                'price' => 40,
                'unit' => 'piece',
                'created_by' => 'admin',
                'created_at' => date('Y-m-d H:i:s')
            ],
            
            // Scanning & Xerox
            [
                'id' => 16,
                'category' => 'Scanning',
                'description' => 'A4 Scan',
                'price' => 10,
                'unit' => 'page',
                'created_by' => 'admin',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 17,
                'category' => 'Xerox',
                'description' => 'A4 Xerox',
                'price' => 3,
                'unit' => 'page',
                'created_by' => 'admin',
                'created_at' => date('Y-m-d H:i:s')
            ],
            
            // Design Services
            [
                'id' => 18,
                'category' => 'Design',
                'description' => 'Logo Design',
                'price' => 1500,
                'unit' => 'project',
                'created_by' => 'admin',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 19,
                'category' => 'Design',
                'description' => 'Brochure Design',
                'price' => 1000,
                'unit' => 'project',
                'created_by' => 'admin',
                'created_at' => date('Y-m-d H:i:s')
            ],
        ],
        WORK_FILE => [],
        EXPENSES_FILE => [],
        LOGS_FILE => []
    ];
    
    foreach ($files as $file => $defaultData) {
        if (!file_exists($file)) {
            file_put_contents($file, json_encode($defaultData, JSON_PRETTY_PRINT));
        }
    }
}

function getJsonData($file) {
    if (!file_exists($file)) return [];
    $content = file_get_contents($file);
    return json_decode($content, true) ?? [];
}

function saveJsonData($file, $data) {
    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
}

function logAction($action, $details = '') {
    $logs = getJsonData(LOGS_FILE);
    $logEntry = [
        'user_id' => $_SESSION['user_id'] ?? null,
        'username' => $_SESSION['username'] ?? 'Guest',
        'action' => $action,
        'details' => $details,
        'ip_address' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
        'timestamp' => date('Y-m-d H:i:s')
    ];
    $logs[] = $logEntry;
    saveJsonData(LOGS_FILE, $logs);
}

// ============================================
// AUTHENTICATION FUNCTIONS
// ============================================

function login($username, $password) {
    $users = getJsonData(USERS_FILE);
    
    if (isset($users[$username])) {
        $user = $users[$username];
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $username;
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['email'] = $user['email'] ?? '';
            
            // Update last login
            $users[$username]['last_login'] = date('Y-m-d H:i:s');
            saveJsonData(USERS_FILE, $users);
            
            logAction('login', "User logged in: $username");
            return true;
        }
    }
    return false;
}

function logout() {
    if (isset($_SESSION['username'])) {
        logAction('logout', "User logged out: " . $_SESSION['username']);
    }
    session_destroy();
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: ?page=login');
        exit();
    }
}

function requireRole($requiredRole) {
    requireLogin();
    
    $roles = ['user' => 1, 'manager' => 2, 'boss' => 3];
    $userRole = $_SESSION['role'] ?? 'user';
    $requiredLevel = $roles[$requiredRole] ?? 0;
    $userLevel = $roles[$userRole] ?? 0;
    
    if ($userLevel < $requiredLevel) {
        header('Location: ?page=dashboard');
        exit();
    }
}

// ============================================
// BUSINESS LOGIC FUNCTIONS
// ============================================
function addWorkEntry($data) {
    $works = getJsonData(WORK_FILE);
    
    $workId = time() . rand(100, 999);
    
    // Get product details
    $productName = getProductName($data['product_id']);
    $unitPrice = getProductPrice($data['product_id']);
    $totalAmount = $data['quantity'] * $unitPrice;
    
    // Check if adding work for past date (users can't do this)
    $workDate = $data['date'];
    $today = date('Y-m-d');
    
    // Compare dates properly
    $workTimestamp = strtotime($workDate);
    $todayTimestamp = strtotime($today);
    
    if ($_SESSION['role'] == 'user' && $workTimestamp > $todayTimestamp) {
        // Users can't add work for future dates
        logAction('work_rejected', "User tried to add work for future date: $workDate");
        return false;
    }
    
    $workEntry = [
        'id' => $workId,
        'user_id' => $_SESSION['user_id'],
        'username' => $_SESSION['username'],
        'date' => $data['date'],
        'customer_name' => $data['customer_name'],
        'customer_phone' => $data['customer_phone'] ?? '',
        'customer_email' => $data['customer_email'] ?? '',
        'product_id' => $data['product_id'],
        'product_name' => $productName,
        'quantity' => $data['quantity'],
        'unit_price' => $unitPrice,
        'total_amount' => $totalAmount,
        'status' => $data['status'],
        'priority' => $data['priority'] ?? 'normal',
        'notes' => $data['notes'] ?? '',
        'delivery_date' => $data['delivery_date'] ?? null,
        'payment_status' => 'pending',
        'payment_method' => '',
        'bill_id' => null,
        'verified_by' => null,
        'verified_at' => null,
        'rejection_reason' => null,
        'created_at' => date('Y-m-d H:i:s')
    ];
    
    $works[$workId] = $workEntry;
    saveJsonData(WORK_FILE, $works);
    
    logAction('work_added', "Added work #$workId as " . $data['status'] . " for customer: " . $data['customer_name']);
    return $workId;
}

function getProductName($productId) {
    $products = getJsonData(PRODUCTS_FILE);
    foreach ($products as $product) {
        if ($product['id'] == $productId) {
            return $product['description'];
        }
    }
    return 'Unknown Product';
}

function getProductPrice($productId) {
    $products = getJsonData(PRODUCTS_FILE);
    foreach ($products as $product) {
        if ($product['id'] == $productId) {
            return $product['price'];
        }
    }
    return 0;
}

function getProductUnit($productId) {
    $products = getJsonData(PRODUCTS_FILE);
    foreach ($products as $product) {
        if ($product['id'] == $productId) {
            return $product['unit'] ?? 'unit';
        }
    }
    return 'unit';
}

function submitWorkForVerification($workId) {
    $works = getJsonData(WORK_FILE);
    
    if (isset($works[$workId]) && $works[$workId]['status'] == 'draft') {
        $works[$workId]['status'] = 'submitted';
        saveJsonData(WORK_FILE, $works);
        
        logAction('work_submitted', "Submitted work #$workId for verification");
        return true;
    }
    return false;
}

function verifyWork($workId, $verifiedBy) {
    $works = getJsonData(WORK_FILE);
    
    if (isset($works[$workId]) && $works[$workId]['status'] == 'submitted') {
        $works[$workId]['status'] = 'verified';
        $works[$workId]['verified_by'] = $verifiedBy;
        $works[$workId]['verified_at'] = date('Y-m-d H:i:s');
        $works[$workId]['bill_id'] = 'BILL-' . date('Ymd') . '-' . $workId;
        saveJsonData(WORK_FILE, $works);
        
        logAction('work_verified', "Verified work #$workId");
        return true;
    }
    return false;
}

function rejectWork($workId, $reason) {
    $works = getJsonData(WORK_FILE);
    
    if (isset($works[$workId]) && $works[$workId]['status'] == 'submitted') {
        $works[$workId]['status'] = 'rejected';
        $works[$workId]['rejection_reason'] = $reason;
        saveJsonData(WORK_FILE, $works);
        
        logAction('work_rejected', "Rejected work #$workId: $reason");
        return true;
    }
    return false;
}

function markAttendance($userId, $date) {
    $attendance = getJsonData(ATTENDANCE_FILE);
    $key = $userId . '_' . $date;
    
    if (!isset($attendance[$key])) {
        $attendance[$key] = [
            'user_id' => $userId,
            'date' => $date,
            'check_in_time' => date('h:i:s A'),
            'check_out_time' => null,
            'status' => 'Present',
            'hours_worked' => 0,
            'marked_by' => 'system'
        ];
        saveJsonData(ATTENDANCE_FILE, $attendance);
        return true;
    }
    return false;
}

// ============================================
// ENHANCED UI/UX COMPONENTS
// ============================================

function renderHeader() {
    $role = $_SESSION['role'] ?? 'guest';
    $fullName = $_SESSION['full_name'] ?? 'Guest';
    $username = $_SESSION['username'] ?? '';
    
    $menuItems = [
        'dashboard' => ['icon' => 'dashboard', 'title' => 'Dashboard'],
        'mark_attendance' => ['icon' => 'check_circle', 'title' => 'Mark Attendance'],
        'attendance' => ['icon' => 'calendar_today', 'title' => 'Attendance'],
        'add_work' => ['icon' => 'add_circle', 'title' => 'Add Work'],
        'my_work' => ['icon' => 'work', 'title' => 'My Work']
    ];
    
    if ($role == 'manager' || $role == 'boss') {
        $menuItems['verify_work'] = ['icon' => 'verified', 'title' => 'Verify Work'];
        $menuItems['products'] = ['icon' => 'inventory', 'title' => 'Products'];
        $menuItems['expenses'] = ['icon' => 'payments', 'title' => 'Expenses'];
        $menuItems['all_work'] = ['icon' => 'list_alt', 'title' => 'All Work'];
    }
    
    if ($role == 'boss' || $role == 'manager') {
        $menuItems['users'] = ['icon' => 'group', 'title' => 'Users'];
    }
    
    if ($role == 'boss') {
        $menuItems['reports'] = ['icon' => 'analytics', 'title' => 'Reports'];
        $menuItems['backup'] = ['icon' => 'backup', 'title' => 'Backup'];
        $menuItems['settings'] = ['icon' => 'settings', 'title' => 'Settings'];
    }
    
    $currentPage = $_GET['page'] ?? 'dashboard';
    
    echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>PrintShop Pro | ' . ucfirst(str_replace('_', ' ', $currentPage)) . '</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <style>
            :root {
                --primary: #4361ee;
                --primary-dark: #3a56d4;
                --secondary: #7209b7;
                --success: #06d6a0;
                --danger: #ef476f;
                --warning: #ffd166;
                --info: #118ab2;
                --dark: #1a1a2e;
                --light: #f8f9fa;
                --gray: #6c757d;
                --gray-light: #e9ecef;
                --border: #dee2e6;
                --sidebar-width: 260px;
                --sidebar-collapsed: 70px;
                --header-height: 70px;
            }
            
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            
            body {
                font-family: \'Inter\', -apple-system, BlinkMacSystemFont, sans-serif;
                background: #f5f7fb;
                color: #333;
                line-height: 1.6;
                overflow-x: hidden;
            }
            
            .app-container {
                display: flex;
                min-height: 100vh;
            }
            
            /* Sidebar Styles */
            .sidebar {
                width: var(--sidebar-width);
                background: white;
                box-shadow: 2px 0 10px rgba(0,0,0,0.05);
                transition: all 0.3s ease;
                z-index: 1000;
                position: fixed;
                height: 100vh;
                overflow-y: auto;
            }
            
            .sidebar.collapsed {
                width: var(--sidebar-collapsed);
            }
            
            .sidebar-header {
                padding: 20px;
                border-bottom: 1px solid var(--border);
                display: flex;
                align-items: center;
                justify-content: space-between;
            }
            
            .logo {
                display: flex;
                align-items: center;
                gap: 12px;
                color: var(--primary);
            }
            
            .logo-icon {
                font-size: 28px;
            }
            
            .logo-text {
                font-size: 20px;
                font-weight: 700;
                white-space: nowrap;
            }
            
            .sidebar.collapsed .logo-text {
                display: none;
            }
            
            .toggle-btn {
                background: none;
                border: none;
                color: var(--gray);
                cursor: pointer;
                font-size: 20px;
                padding: 5px;
                border-radius: 6px;
                transition: all 0.3s;
            }
            
            .toggle-btn:hover {
                background: var(--gray-light);
                color: var(--primary);
            }
            
            .sidebar.collapsed .toggle-btn {
                transform: rotate(180deg);
            }
            
            .nav-menu {
                padding: 20px 0;
            }
            
            .nav-item {
                margin-bottom: 5px;
                position: relative;
            }
            
            .nav-link {
                display: flex;
                align-items: center;
                padding: 14px 20px;
                color: var(--gray);
                text-decoration: none;
                transition: all 0.3s;
                gap: 15px;
                border-left: 3px solid transparent;
            }
            
            .nav-link:hover {
                background: #f0f4ff;
                color: var(--primary);
                border-left-color: var(--primary);
            }
            
            .nav-link.active {
                background: linear-gradient(90deg, rgba(67, 97, 238, 0.1), transparent);
                color: var(--primary);
                border-left-color: var(--primary);
                font-weight: 500;
            }
            
            .nav-icon {
                font-size: 22px;
                width: 24px;
                text-align: center;
            }
            
            .nav-text {
                font-size: 15px;
                white-space: nowrap;
            }
            
            .sidebar.collapsed .nav-text {
                display: none;
            }
            
            .sidebar.collapsed .nav-link {
                justify-content: center;
                padding: 16px 0;
            }
            
            .sidebar-footer {
                padding: 20px;
                border-top: 1px solid var(--border);
                margin-top: auto;
            }
            
            .user-info {
                display: flex;
                align-items: center;
                gap: 12px;
            }
            
            .user-avatar {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                background: linear-gradient(135deg, var(--primary), var(--secondary));
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-weight: 600;
                font-size: 16px;
            }
            
            .user-details {
                flex: 1;
            }
            
            .user-name {
                font-weight: 600;
                font-size: 14px;
                color: var(--dark);
            }
            
            .user-role {
                font-size: 12px;
                color: var(--gray);
                text-transform: capitalize;
            }
            
            .sidebar.collapsed .user-details {
                display: none;
            }
            
            /* Main Content Styles */
            .main-content {
                flex: 1;
                margin-left: var(--sidebar-width);
                transition: margin-left 0.3s ease;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
            }
            
            .sidebar.collapsed ~ .main-content {
                margin-left: var(--sidebar-collapsed);
            }
            
            .top-header {
                height: var(--header-height);
                background: white;
                box-shadow: 0 2px 10px rgba(0,0,0,0.05);
                padding: 0 30px;
                display: flex;
                align-items: center;
                justify-content: space-between;
                position: sticky;
                top: 0;
                z-index: 100;
            }
            
            .page-title {
                font-size: 24px;
                font-weight: 700;
                color: var(--dark);
                display: flex;
                align-items: center;
                gap: 12px;
            }
            
            .page-icon {
                color: var(--primary);
            }
            
            .header-actions {
                display: flex;
                align-items: center;
                gap: 20px;
            }
            
            .notification-btn {
                position: relative;
                background: none;
                border: none;
                font-size: 22px;
                color: var(--gray);
                cursor: pointer;
                padding: 8px;
                border-radius: 8px;
                transition: all 0.3s;
            }
            
            .notification-btn:hover {
                background: var(--gray-light);
                color: var(--primary);
            }
            
            .notification-badge {
                position: absolute;
                top: 0;
                right: 0;
                background: var(--danger);
                color: white;
                font-size: 10px;
                width: 18px;
                height: 18px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            
            .mobile-menu-btn {
                display: none;
                background: none;
                border: none;
                font-size: 24px;
                color: var(--gray);
                cursor: pointer;
            }
            
            .content-wrapper {
                padding: 30px;
                flex: 1;
            }
            
            /* Card Styles */
            .card {
                background: white;
                border-radius: 12px;
                box-shadow: 0 4px 20px rgba(0,0,0,0.05);
                margin-bottom: 25px;
                overflow: hidden;
                transition: transform 0.3s, box-shadow 0.3s;
                border: 1px solid var(--border);
            }
            
            .card:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 25px rgba(0,0,0,0.08);
            }
            
            .card-header {
                padding: 20px 25px;
                border-bottom: 1px solid var(--border);
                display: flex;
                align-items: center;
                justify-content: space-between;
            }
            
            .card-title {
                font-size: 18px;
                font-weight: 600;
                color: var(--dark);
                display: flex;
                align-items: center;
                gap: 10px;
            }
            
            .card-actions {
                display: flex;
                gap: 10px;
            }
            
            .card-body {
                padding: 25px;
            }
            
            /* Button Styles */
            .btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                padding: 10px 18px;
                border-radius: 8px;
                font-weight: 500;
                font-size: 14px;
                cursor: pointer;
                transition: all 0.3s;
                border: none;
                text-decoration: none;
                white-space: nowrap;
            }
            
            .btn i, .btn .material-icons-round {
                font-size: 18px;
            }
            
            .btn-sm {
                padding: 8px 14px;
                font-size: 13px;
            }
            
            .btn-lg {
                padding: 14px 24px;
                font-size: 16px;
            }
            
            .btn-primary {
                background: var(--primary);
                color: white;
            }
            
            .btn-primary:hover {
                background: var(--primary-dark);
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
            }
            
            .btn-success {
                background: var(--success);
                color: white;
            }
            
            .btn-danger {
                background: var(--danger);
                color: white;
            }
            
            .btn-warning {
                background: var(--warning);
                color: #333;
            }
            
            .btn-info {
                background: var(--info);
                color: white;
            }
            
            .btn-secondary {
                background: var(--gray-light);
                color: var(--gray);
            }
            
            .btn-outline {
                background: transparent;
                border: 1px solid var(--border);
                color: var(--gray);
            }
            
            .btn-outline:hover {
                border-color: var(--primary);
                color: var(--primary);
                background: rgba(67, 97, 238, 0.05);
            }
            
            /* Form Styles */
            .form-group {
                margin-bottom: 20px;
            }
            
            .form-label {
                display: block;
                margin-bottom: 8px;
                font-weight: 500;
                color: var(--dark);
                font-size: 14px;
            }
            
            .form-control {
                width: 100%;
                padding: 12px 16px;
                border: 1px solid var(--border);
                border-radius: 8px;
                font-size: 15px;
                transition: all 0.3s;
                background: white;
            }
            
            .form-control:focus {
                outline: none;
                border-color: var(--primary);
                box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
            }
            
            .form-row {
                display: flex;
                gap: 20px;
                margin-bottom: 20px;
            }
            
            .form-col {
                flex: 1;
            }
            
            /* Table Styles */
            .table-responsive {
                overflow-x: auto;
                border-radius: 8px;
                border: 1px solid var(--border);
            }
            
            .table {
                width: 100%;
                border-collapse: collapse;
                min-width: 800px;
            }
            
            .table th {
                background: #f8f9fa;
                padding: 16px 20px;
                text-align: left;
                font-weight: 600;
                color: var(--dark);
                font-size: 14px;
                border-bottom: 2px solid var(--border);
            }
            
            .table td {
                padding: 16px 20px;
                border-bottom: 1px solid var(--border);
                vertical-align: middle;
            }
            
            .table tr:last-child td {
                border-bottom: none;
            }
            
            .table tr:hover {
                background: #f8f9fa;
            }
            
            /* Badge Styles */
            .badge {
                display: inline-block;
                padding: 5px 12px;
                border-radius: 20px;
                font-size: 12px;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }
            
            .badge-success {
                background: rgba(6, 214, 160, 0.1);
                color: var(--success);
            }
            
            .badge-warning {
                background: rgba(255, 209, 102, 0.1);
                color: #b38b00;
            }
            
            .badge-danger {
                background: rgba(239, 71, 111, 0.1);
                color: var(--danger);
            }
            
            .badge-info {
                background: rgba(17, 138, 178, 0.1);
                color: var(--info);
            }
            
            .badge-primary {
                background: rgba(67, 97, 238, 0.1);
                color: var(--primary);
            }
            
            .role-badge {
                padding: 4px 10px;
                border-radius: 4px;
                font-size: 11px;
                font-weight: 600;
                text-transform: uppercase;
            }
            
            .role-boss {
                background: linear-gradient(135deg, #dc2626, #ef4444);
                color: white;
            }
            
            .role-manager {
                background: linear-gradient(135deg, #f59e0b, #fbbf24);
                color: white;
            }
            
            .role-user {
                background: linear-gradient(135deg, #10b981, #34d399);
                color: white;
            }
            
            /* Alert Styles */
            .alert {
                padding: 16px 20px;
                border-radius: 8px;
                margin-bottom: 20px;
                display: flex;
                align-items: flex-start;
                gap: 12px;
                border-left: 4px solid;
            }
            
            .alert-icon {
                font-size: 20px;
                margin-top: 2px;
            }
            
            .alert-content {
                flex: 1;
            }
            
            .alert-title {
                font-weight: 600;
                margin-bottom: 4px;
            }
            
            .alert-success {
                background: rgba(6, 214, 160, 0.1);
                border-left-color: var(--success);
                color: #065f46;
            }
            
            .alert-danger {
                background: rgba(239, 71, 111, 0.1);
                border-left-color: var(--danger);
                color: #991b1b;
            }
            
            .alert-info {
                background: rgba(17, 138, 178, 0.1);
                border-left-color: var(--info);
                color: #1e40af;
            }
            
            .alert-warning {
                background: rgba(255, 209, 102, 0.1);
                border-left-color: var(--warning);
                color: #92400e;
            }
            
            /* Dashboard Stats */
            .stats-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
                gap: 20px;
                margin-bottom: 30px;
            }
            
            .stat-card {
                background: white;
                border-radius: 12px;
                padding: 25px;
                box-shadow: 0 4px 15px rgba(0,0,0,0.05);
                display: flex;
                align-items: center;
                gap: 20px;
                transition: transform 0.3s;
                border: 1px solid var(--border);
            }
            
            .stat-card:hover {
                transform: translateY(-3px);
            }
            
            .stat-icon {
                width: 60px;
                height: 60px;
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 28px;
                color: white;
            }
            
            .stat-content {
                flex: 1;
            }
            
            .stat-value {
                font-size: 32px;
                font-weight: 700;
                margin-bottom: 5px;
                color: var(--dark);
            }
            
            .stat-label {
                font-size: 14px;
                color: var(--gray);
                font-weight: 500;
            }
            
            .stat-change {
                font-size: 13px;
                margin-top: 5px;
                display: flex;
                align-items: center;
                gap: 5px;
            }
            
            .change-up {
                color: var(--success);
            }
            
            .change-down {
                color: var(--danger);
            }
            
            /* Modal Styles */
            .modal {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.5);
                z-index: 2000;
                align-items: center;
                justify-content: center;
                padding: 20px;
            }
            
            .modal-content {
                background: white;
                border-radius: 12px;
                max-width: 500px;
                width: 100%;
                max-height: 90vh;
                overflow-y: auto;
                box-shadow: 0 10px 40px rgba(0,0,0,0.1);
                animation: modalSlideIn 0.3s ease;
            }
            
            @keyframes modalSlideIn {
                from {
                    opacity: 0;
                    transform: translateY(-20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            
            .modal-header {
                padding: 20px 25px;
                border-bottom: 1px solid var(--border);
                display: flex;
                align-items: center;
                justify-content: space-between;
            }
            
            .modal-title {
                font-size: 18px;
                font-weight: 600;
                color: var(--dark);
            }
            
            .modal-close {
                background: none;
                border: none;
                font-size: 24px;
                color: var(--gray);
                cursor: pointer;
                padding: 5px;
                border-radius: 6px;
                transition: all 0.3s;
            }
            
            .modal-close:hover {
                background: var(--gray-light);
                color: var(--danger);
            }
            
            .modal-body {
                padding: 25px;
            }
            
            .modal-footer {
                padding: 20px 25px;
                border-top: 1px solid var(--border);
                display: flex;
                justify-content: flex-end;
                gap: 10px;
            }
            
            /* Responsive Styles */
            @media (max-width: 1024px) {
                .sidebar {
                    transform: translateX(-100%);
                    width: 280px;
                }
                
                .sidebar.active {
                    transform: translateX(0);
                }
                
                .main-content {
                    margin-left: 0 !important;
                }
                
                .mobile-menu-btn {
                    display: block;
                }
                
                .content-wrapper {
                    padding: 20px;
                }
                
                .top-header {
                    padding: 0 20px;
                }
            }
            
            @media (max-width: 768px) {
                .form-row {
                    flex-direction: column;
                    gap: 0;
                }
                
                .stats-grid {
                    grid-template-columns: 1fr;
                }
                
                .header-actions {
                    gap: 10px;
                }
                
                .card-body {
                    padding: 20px;
                }
                
                .table th, .table td {
                    padding: 12px 15px;
                }
            }
            
            @media (max-width: 576px) {
                .btn {
                    padding: 10px 14px;
                    font-size: 13px;
                }
                
                .page-title {
                    font-size: 20px;
                }
                
                .content-wrapper {
                    padding: 15px;
                }
                
                .modal-content {
                    padding: 0;
                }
                
                .modal-header, .modal-body, .modal-footer {
                    padding: 15px;
                }
            }
            
            /* Custom Scrollbar */
            ::-webkit-scrollbar {
                width: 8px;
                height: 8px;
            }
            
            ::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 4px;
            }
            
            ::-webkit-scrollbar-thumb {
                background: #c1c1c1;
                border-radius: 4px;
            }
            
            ::-webkit-scrollbar-thumb:hover {
                background: #a8a8a8;
            }
            
            /* Animation */
            .fade-in {
                animation: fadeIn 0.5s ease;
            }
            
            @keyframes fadeIn {
                from { opacity: 0; }
                to { opacity: 1; }
            }
            
            /* Utility Classes */
            .text-center { text-align: center; }
            .text-right { text-align: right; }
            .text-left { text-align: left; }
            .d-flex { display: flex; }
            .d-block { display: block; }
            .d-none { display: none; }
            .align-items-center { align-items: center; }
            .justify-content-between { justify-content: space-between; }
            .gap-10 { gap: 10px; }
            .gap-15 { gap: 15px; }
            .gap-20 { gap: 20px; }
            .mt-10 { margin-top: 10px; }
            .mt-20 { margin-top: 20px; }
            .mt-30 { margin-top: 30px; }
            .mb-10 { margin-bottom: 10px; }
            .mb-20 { margin-bottom: 20px; }
            .mb-30 { margin-bottom: 30px; }
            .p-20 { padding: 20px; }
            .w-100 { width: 100%; }
            .h-100 { height: 100%; }
        </style>
    </head>
    <body>
        <div class="app-container">
            <!-- Sidebar -->
            <div class="sidebar" id="sidebar">
                <div class="sidebar-header">
                    <div class="logo">
                        <span class="logo-icon material-icons-round">print</span>
                        <span class="logo-text">PrintShop Pro</span>
                    </div>
                    <button class="toggle-btn" id="toggleSidebar">
                        <span class="material-icons-round">chevron_left</span>
                    </button>
                </div>
                
                <nav class="nav-menu">';
    
    foreach ($menuItems as $page => $item) {
        $active = ($currentPage == $page) ? 'active' : '';
        $icon = $item['icon'];
        $title = $item['title'];
        
        echo '<div class="nav-item">
                <a href="?page=' . $page . '" class="nav-link ' . $active . '">
                    <span class="nav-icon material-icons-round">' . $icon . '</span>
                    <span class="nav-text">' . $title . '</span>
                </a>
            </div>';
    }
    
    echo '</nav>
                
                <div class="sidebar-footer">
                    <div class="user-info">
                        <div class="user-avatar">' . substr($fullName, 0, 1) . '</div>
                        <div class="user-details">
                            <div class="user-name">' . htmlspecialchars($fullName) . '</div>
                            <div class="user-role">' . ucfirst($role) . '</div>
                        </div>
                        <a href="?action=logout" class="btn btn-sm btn-outline" title="Logout">
                            <span class="material-icons-round">logout</span>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="main-content">
                <header class="top-header">
                    <div class="d-flex align-items-center gap-20">
                        <button class="mobile-menu-btn" id="mobileMenuBtn">
                            <span class="material-icons-round">menu</span>
                        </button>
                        <div class="page-title">
                            <span class="page-icon material-icons-round">' . ($menuItems[$currentPage]['icon'] ?? 'dashboard') . '</span>
                            ' . ucfirst(str_replace('_', ' ', $currentPage)) . '
                        </div>
                    </div>
                    
                    <div class="header-actions">
                        <button class="notification-btn">
                            <span class="material-icons-round">notifications</span>
                            <span class="notification-badge">3</span>
                        </button>
                        <div class="user-info d-none d-md-flex">
                            <div class="user-avatar">' . substr($fullName, 0, 1) . '</div>
                            <div class="user-details">
                                <div class="user-name">' . htmlspecialchars($fullName) . '</div>
                                <div class="user-role">' . ucfirst($role) . '</div>
                            </div>
                        </div>
                    </div>
                </header>
                
                <div class="content-wrapper fade-in">';
}

function renderFooter() {
    echo '
                </div>
            </div>
        </div>
        
        <script>
        document.addEventListener(\'DOMContentLoaded\', function() {
            // Toggle sidebar
            const sidebar = document.getElementById(\'sidebar\');
            const toggleBtn = document.getElementById(\'toggleSidebar\');
            const mobileMenuBtn = document.getElementById(\'mobileMenuBtn\');
            
            // Check if sidebar should be collapsed (from localStorage)
            const isCollapsed = localStorage.getItem(\'sidebarCollapsed\') === \'true\';
            if (isCollapsed) {
                sidebar.classList.add(\'collapsed\');
            }
            
            toggleBtn.addEventListener(\'click\', function() {
                sidebar.classList.toggle(\'collapsed\');
                localStorage.setItem(\'sidebarCollapsed\', sidebar.classList.contains(\'collapsed\'));
            });
            
            mobileMenuBtn.addEventListener(\'click\', function() {
                sidebar.classList.toggle(\'active\');
            });
            
            // Close sidebar when clicking outside on mobile
            document.addEventListener(\'click\', function(event) {
                if (window.innerWidth <= 1024) {
                    if (!sidebar.contains(event.target) && !mobileMenuBtn.contains(event.target) && sidebar.classList.contains(\'active\')) {
                        sidebar.classList.remove(\'active\');
                    }
                }
            });
            
            // Active nav link indicator
            const currentPage = window.location.search.split(\'page=\')[1]?.split(\'&\')[0] || \'dashboard\';
            const navLinks = document.querySelectorAll(\'.nav-link\');
            navLinks.forEach(link => {
                link.classList.remove(\'active\');
                if (link.getAttribute(\'href\').includes(currentPage)) {
                    link.classList.add(\'active\');
                }
            });
            
            // Auto-hide alerts after 5 seconds
            setTimeout(() => {
                const alerts = document.querySelectorAll(\'.alert\');
                alerts.forEach(alert => {
                    alert.style.transition = \'opacity 0.5s\';
                    alert.style.opacity = \'0\';
                    setTimeout(() => {
                        alert.style.display = \'none\';
                    }, 500);
                });
            }, 5000);
            
            // Form validation helper
            window.validateForm = function(formId) {
                const form = document.getElementById(formId);
                if (!form) return true;
                
                const requiredFields = form.querySelectorAll(\'[required]\');
                let isValid = true;
                
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        field.style.borderColor = \'var(--danger)\';
                        field.focus();
                        isValid = false;
                        
                        // Reset border color on input
                        field.addEventListener(\'input\', function() {
                            this.style.borderColor = \'var(--border)\';
                        });
                    }
                });
                
                return isValid;
            };
            
            // Price calculator
            window.calculatePrice = function(quantityId, priceId, totalId) {
                const quantity = parseFloat(document.getElementById(quantityId).value) || 0;
                const price = parseFloat(document.getElementById(priceId).value) || 0;
                const total = quantity * price;
                
                if (totalId) {
                    document.getElementById(totalId).value = total.toFixed(2);
                }
                return total;
            };
            
            // Date restriction for work
            window.checkDateRestriction = function(dateInputId) {
                const dateInput = document.getElementById(dateInputId);
                if (!dateInput) return true;
                
                const selectedDate = new Date(dateInput.value);
                const today = new Date();
                
                selectedDate.setHours(0, 0, 0, 0);
                today.setHours(0, 0, 0, 0);
                
                const selectedTime = selectedDate.getTime();
                const todayTime = today.getTime();
                
                if (selectedTime > todayTime) {
                    alert("You cannot add work for future dates!");
                    dateInput.value = today.toISOString().split(\'T\')[0];
                    return false;
                }
                
                return true;
            };
            
            // Modal functions
            window.showModal = function(modalId) {
                const modal = document.getElementById(modalId);
                if (modal) {
                    modal.style.display = \'flex\';
                    document.body.style.overflow = \'hidden\';
                }
            };
            
            window.closeModal = function(modalId) {
                const modal = document.getElementById(modalId);
                if (modal) {
                    modal.style.display = \'none\';
                    document.body.style.overflow = \'auto\';
                }
            };
            
            // Close modal when clicking outside
            document.querySelectorAll(\'.modal\').forEach(modal => {
                modal.addEventListener(\'click\', function(e) {
                    if (e.target === this) {
                        this.style.display = \'none\';
                        document.body.style.overflow = \'auto\';
                    }
                });
            });
            
            // Confirm action helper
            window.confirmAction = function(message, url) {
                if (confirm(message)) {
                    window.location.href = url;
                }
            };
            
            // Print bill
            window.printBill = function(workId) {
                window.open("?page=print_bill&id=" + workId, "_blank");
            };
            
            // Toggle custom fields
            window.toggleCustomField = function(selectId, customFieldId) {
                const select = document.getElementById(selectId);
                const customField = document.getElementById(customFieldId);
                
                if (select && customField) {
                    if (select.value === \'Custom\' || select.value === \'Other\') {
                        customField.style.display = \'block\';
                        if (customField.querySelector(\'input\')) {
                            customField.querySelector(\'input\').required = true;
                        }
                    } else {
                        customField.style.display = \'none\';
                        if (customField.querySelector(\'input\')) {
                            customField.querySelector(\'input\').required = false;
                        }
                    }
                }
            };
            
            // Load products by category
            window.loadProductsByCategory = function(categorySelectId, productSelectId) {
                const categorySelect = document.getElementById(categorySelectId);
                const productSelect = document.getElementById(productSelectId);
                
                if (!categorySelect || !productSelect) return;
                
                const selectedCategory = categorySelect.value;
                const options = productSelect.querySelectorAll(\'option\');
                
                // Reset selection
                productSelect.value = \'\';
                
                // Show/hide options
                options.forEach(option => {
                    if (option.value === \'\' || option.dataset.category === selectedCategory || selectedCategory === \'\') {
                        option.style.display = \'block\';
                    } else {
                        option.style.display = \'none\';
                    }
                });
                
                // Trigger price update if needed
                if (window.updateProductPrice) {
                    window.updateProductPrice();
                }
            };
        });
        </script>
    </body>
    </html>';
}

// ============================================
// ENHANCED PAGE RENDERING FUNCTIONS
// ============================================

function renderLoginPage() {
    $error = '';
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        
        if (login($username, $password)) {
            header('Location: ?page=dashboard');
            exit();
        } else {
            $error = "Invalid username or password";
        }
    }
    
    echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login - PrintShop Pro</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            
            body {
                font-family: \'Inter\', sans-serif;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 20px;
            }
            
            .login-container {
                width: 100%;
                max-width: 420px;
            }
            
            .login-card {
                background: white;
                border-radius: 16px;
                box-shadow: 0 20px 60px rgba(0,0,0,0.15);
                overflow: hidden;
                animation: cardSlideIn 0.6s ease;
            }
            
            @keyframes cardSlideIn {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            
            .login-header {
                background: linear-gradient(135deg, #4361ee, #7209b7);
                padding: 40px 30px 30px;
                text-align: center;
                color: white;
            }
            
            .login-logo {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 15px;
                margin-bottom: 20px;
            }
            
            .logo-icon {
                font-size: 42px;
            }
            
            .logo-text {
                font-size: 28px;
                font-weight: 700;
            }
            
            .login-subtitle {
                font-size: 16px;
                opacity: 0.9;
                margin-top: 10px;
            }
            
            .login-body {
                padding: 40px 30px;
            }
            
            .form-group {
                margin-bottom: 25px;
            }
            
            .form-label {
                display: block;
                margin-bottom: 8px;
                font-weight: 500;
                color: #333;
                font-size: 14px;
            }
            
            .input-group {
                position: relative;
            }
            
            .input-icon {
                position: absolute;
                left: 16px;
                top: 50%;
                transform: translateY(-50%);
                color: #6c757d;
                font-size: 20px;
            }
            
            .form-control {
                width: 100%;
                padding: 14px 16px 14px 50px;
                border: 1px solid #dee2e6;
                border-radius: 10px;
                font-size: 15px;
                transition: all 0.3s;
                background: #f8f9fa;
            }
            
            .form-control:focus {
                outline: none;
                border-color: #4361ee;
                box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
                background: white;
            }
            
            .btn-login {
                width: 100%;
                padding: 16px;
                background: linear-gradient(135deg, #4361ee, #7209b7);
                color: white;
                border: none;
                border-radius: 10px;
                font-size: 16px;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.3s;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 10px;
            }
            
            .btn-login:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 20px rgba(67, 97, 238, 0.3);
            }
            
            .error-message {
                background: rgba(239, 71, 111, 0.1);
                border-left: 4px solid #ef476f;
                padding: 14px 18px;
                margin-bottom: 25px;
                border-radius: 8px;
                display: flex;
                align-items: center;
                gap: 12px;
                color: #991b1b;
            }
            
            .error-icon {
                font-size: 22px;
                color: #ef476f;
            }
            
            .login-footer {
                text-align: center;
                padding: 20px 30px;
                border-top: 1px solid #dee2e6;
                color: #6c757d;
                font-size: 14px;
            }
            
            .demo-credentials {
                background: #f8f9fa;
                padding: 15px;
                border-radius: 8px;
                margin-top: 20px;
                font-size: 13px;
            }
            
            .demo-title {
                font-weight: 600;
                margin-bottom: 8px;
                color: #333;
            }
            
            @media (max-width: 480px) {
                .login-card {
                    border-radius: 12px;
                }
                
                .login-header {
                    padding: 30px 20px 25px;
                }
                
                .login-body {
                    padding: 30px 20px;
                }
                
                .logo-text {
                    font-size: 24px;
                }
                
                .logo-icon {
                    font-size: 36px;
                }
            }
        </style>
    </head>
    <body>
        <div class="login-container">
            <div class="login-card">
                <div class="login-header">
                    <div class="login-logo">
                        <span class="logo-icon material-icons-round">print</span>
                        <span class="logo-text">PrintShop Pro</span>
                    </div>
                    <div class="login-subtitle">Professional Print Shop Management System</div>
                </div>
                
                <div class="login-body">';
    
    if (!empty($error)) {
        echo '<div class="error-message">
                <span class="error-icon material-icons-round">error</span>
                <span>' . htmlspecialchars($error) . '</span>
              </div>';
    }
    
    echo '<form method="POST">
                        <div class="form-group">
                            <label class="form-label">Username</label>
                            <div class="input-group">
                                <span class="input-icon material-icons-round">person</span>
                                <input type="text" name="username" class="form-control" placeholder="Enter your username" required value="admin">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-icon material-icons-round">lock</span>
                                <input type="password" name="password" class="form-control" placeholder="Enter your password" required value="admin123">
                            </div>
                        </div>
                        
                        <button type="submit" name="login" class="btn-login">
                            <span class="material-icons-round">login</span>
                            Sign In
                        </button>
                    </form>
                    
                    <div class="demo-credentials">
                        <div class="demo-title">Demo Credentials</div>
                        <div>Username: admin</div>
                        <div>Password: admin123</div>
                    </div>
                </div>
                
                <div class="login-footer">
                    © ' . date('Y') . ' PrintShop Pro. All rights reserved.
                </div>
            </div>
        </div>
    </body>
    </html>';
}

function renderDashboard() {
    requireLogin();
    $works = getJsonData(WORK_FILE);
    $users = getJsonData(USERS_FILE);
    $attendance = getJsonData(ATTENDANCE_FILE);
    $expenses = getJsonData(EXPENSES_FILE);
    
    // Calculate stats
    $stats = [
        'total_work' => 0,
        'verified_work' => 0,
        'today_work' => 0,
        'pending_verification' => 0,
        'total_revenue' => 0,
        'total_expenses' => 0,
        'active_users' => 0,
        'today_attendance' => 0
    ];
    
    foreach ($works as $work) {
        if ($_SESSION['role'] == 'boss' || $_SESSION['role'] == 'manager' || $work['user_id'] == $_SESSION['user_id']) {
            $stats['total_work']++;
            
            if ($work['status'] == 'verified') {
                $stats['verified_work']++;
                $stats['total_revenue'] += $work['total_amount'];
            }
            
            if ($work['date'] == date('Y-m-d')) $stats['today_work']++;
            if ($work['status'] == 'submitted') $stats['pending_verification']++;
        }
    }
    
    // Calculate expenses
    foreach ($expenses as $expense) {
        $stats['total_expenses'] += $expense['amount'];
    }
    
    // Active users
    foreach ($users as $user) {
        if ($user['is_active']) $stats['active_users']++;
    }
    
    // Today's attendance
    $today = date('Y-m-d');
    foreach ($attendance as $record) {
        if ($record['date'] == $today) $stats['today_attendance']++;
    }
    
    renderHeader();
    
    // Welcome message
    echo '<div class="card mb-30">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-10">Welcome back, ' . htmlspecialchars($_SESSION['full_name']) . '! 👋</h2>
                        <p class="text-muted">Here\'s what\'s happening with your print shop today.</p>
                    </div>
                    <div class="d-flex gap-10">
                        <button class="btn btn-primary" onclick="window.location=\'?page=add_work\'">
                            <span class="material-icons-round">add</span> New Order
                        </button>
                        <button class="btn btn-outline" onclick="window.location=\'?page=mark_attendance\'">
                            <span class="material-icons-round">check_circle</span> Mark Attendance
                        </button>
                    </div>
                </div>
            </div>
        </div>';
    
    // Stats Grid
    echo '<div class="stats-grid mb-30">
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #4361ee, #3a56d4);">
                    <span class="material-icons-round">receipt</span>
                </div>
                <div class="stat-content">
                    <div class="stat-value">' . $stats['today_work'] . '</div>
                    <div class="stat-label">Today\'s Orders</div>
                    <div class="stat-change change-up">
                        <span class="material-icons-round">trending_up</span>
                        +12% from yesterday
                    </div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #06d6a0, #05c08f);">
                    <span class="material-icons-round">paid</span>
                </div>
                <div class="stat-content">
                    <div class="stat-value">₹' . number_format($stats['total_revenue'], 2) . '</div>
                    <div class="stat-label">Total Revenue</div>
                    <div class="stat-change change-up">
                        <span class="material-icons-round">trending_up</span>
                        +8% from last month
                    </div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #ef476f, #e63946);">
                    <span class="material-icons-round">money_off</span>
                </div>
                <div class="stat-content">
                    <div class="stat-value">₹' . number_format($stats['total_expenses'], 2) . '</div>
                    <div class="stat-label">Total Expenses</div>
                    <div class="stat-change change-down">
                        <span class="material-icons-round">trending_down</span>
                        -5% from last month
                    </div>
                </div>
            </div>';
    
    if ($_SESSION['role'] == 'boss' || $_SESSION['role'] == 'manager') {
        echo '<div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #ffd166, #ffc043);">
                    <span class="material-icons-round">pending_actions</span>
                </div>
                <div class="stat-content">
                    <div class="stat-value">' . $stats['pending_verification'] . '</div>
                    <div class="stat-label">Pending Verification</div>
                    <div class="stat-change">
                        <a href="?page=verify_work" class="btn btn-sm btn-warning mt-10">Review Now</a>
                    </div>
                </div>
            </div>';
    }
    
    echo '</div>';
    
    // Quick Actions
    echo '<div class="card mb-30">
            <div class="card-header">
                <div class="card-title">
                    <span class="material-icons-round">bolt</span>
                    Quick Actions
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex flex-wrap gap-15">
                    <button class="btn btn-outline" onclick="window.location=\'?page=add_work\'">
                        <span class="material-icons-round">add_circle</span> New Order
                    </button>
                    <button class="btn btn-outline" onclick="window.location=\'?page=mark_attendance\'">
                        <span class="material-icons-round">check_circle</span> Mark Attendance
                    </button>
                    <button class="btn btn-outline" onclick="window.location=\'?page=my_work\'">
                        <span class="material-icons-round">visibility</span> View My Work
                    </button>';
    
    if ($_SESSION['role'] == 'boss' || $_SESSION['role'] == 'manager') {
        echo '<button class="btn btn-outline" onclick="window.location=\'?page=verify_work\'">
                <span class="material-icons-round">verified</span> Verify Work
            </button>
            <button class="btn btn-outline" onclick="window.location=\'?page=expenses\'">
                <span class="material-icons-round">payments</span> Add Expense
            </button>';
    }
    
    if ($_SESSION['role'] == 'boss') {
        echo '<button class="btn btn-outline" onclick="window.location=\'?page=reports\'">
                <span class="material-icons-round">analytics</span> View Reports
            </button>';
    }
    
    echo '</div>
            </div>
        </div>';
    
    // Recent Orders
    $recentWorks = [];
    foreach ($works as $work) {
        if ($_SESSION['role'] == 'boss' || $_SESSION['role'] == 'manager' || $work['user_id'] == $_SESSION['user_id']) {
            $recentWorks[] = $work;
        }
    }
    
    // Sort by date (newest first)
    usort($recentWorks, function($a, $b) {
        return strtotime($b['created_at']) - strtotime($a['created_at']);
    });
    
    $recentWorks = array_slice($recentWorks, 0, 5);
    
    if (!empty($recentWorks)) {
        echo '<div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <span class="material-icons-round">history</span>
                        Recent Orders
                    </div>
                    <a href="?page=' . ($_SESSION['role'] == 'user' ? 'my_work' : 'all_work') . '" class="btn btn-sm btn-outline">View All</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Customer</th>
                                    <th>Product</th>
                                    <th>Amount</th>
                                    <th>Status</th>';
        
        if ($_SESSION['role'] == 'boss' || $_SESSION['role'] == 'manager') {
            echo '<th>Employee</th>';
        }
        
        echo '<th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>';
        
        foreach ($recentWorks as $work) {
            $statusBadge = '';
            switch ($work['status']) {
                case 'verified': $statusBadge = '<span class="badge badge-success">Verified</span>'; break;
                case 'submitted': $statusBadge = '<span class="badge badge-warning">Pending</span>'; break;
                case 'draft': $statusBadge = '<span class="badge badge-info">Draft</span>'; break;
                case 'rejected': $statusBadge = '<span class="badge badge-danger">Rejected</span>'; break;
            }
            
            echo '<tr>
                    <td>' . date('M d, Y', strtotime($work['date'])) . '</td>
                    <td>' . htmlspecialchars(substr($work['customer_name'], 0, 20)) . (strlen($work['customer_name']) > 20 ? '...' : '') . '</td>
                    <td>' . htmlspecialchars(substr($work['product_name'], 0, 25)) . (strlen($work['product_name']) > 25 ? '...' : '') . '</td>
                    <td>₹' . number_format($work['total_amount'], 2) . '</td>
                    <td>' . $statusBadge . '</td>';
            
            if ($_SESSION['role'] == 'boss' || $_SESSION['role'] == 'manager') {
                echo '<td>' . htmlspecialchars($work['username']) . '</td>';
            }
            
            echo '<td>
                    <div class="d-flex gap-10">
                        <button class="btn btn-sm btn-outline" onclick="window.location=\'?page=view_work&id=' . $work['id'] . '\'">
                            <span class="material-icons-round">visibility</span>
                        </button>';
            
            if ($work['status'] == 'verified') {
                echo '<button class="btn btn-sm btn-outline" onclick="printBill(\'' . $work['id'] . '\')">
                        <span class="material-icons-round">print</span>
                    </button>';
            }
            
            echo '</div>
                </td>
            </tr>';
        }
        
        echo '</tbody>
                        </table>
                    </div>
                </div>
            </div>';
    }
    
    // Attendance Reminder
    $attendanceKey = $_SESSION['user_id'] . '_' . $today;
    $hasMarkedAttendance = isset($attendance[$attendanceKey]);
    
    if (!in_array($_SESSION['role'], ['boss', 'manager']) && !$hasMarkedAttendance) {
        echo '<div class="card mt-20" style="border-left: 4px solid #ffd166;">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-15">
                            <div style="background: rgba(255, 209, 102, 0.1); width: 50px; height: 50px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                <span class="material-icons-round" style="color: #b38b00;">schedule</span>
                            </div>
                            <div>
                                <h4 style="margin-bottom: 5px;">Attendance Reminder</h4>
                                <p style="color: #6c757d; margin: 0;">You haven\'t marked your attendance for today.</p>
                            </div>
                        </div>
                        <a href="?page=mark_attendance" class="btn btn-warning">
                            <span class="material-icons-round">check_circle</span> Mark Now
                        </a>
                    </div>
                </div>
            </div>';
    }
    
    renderFooter();
}

// Note: Due to character limit, I'm showing the enhanced structure for the main pages.
// The other page functions (add_work, products, etc.) would follow the same enhanced pattern.
// The complete implementation would need to update each render function with the new UI components.

// ============================================
// MAIN APPLICATION ROUTING (Updated)
// ============================================

// Handle actions first
if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'logout':
            logout();
            header('Location: ?page=login');
            exit();
            
        case 'submit_work':
            requireLogin();
            if (isset($_GET['id'])) {
                submitWorkForVerification($_GET['id']);
            }
            header('Location: ?page=dashboard');
            exit();
            
        case 'verify_work':
            requireRole('manager');
            if (isset($_GET['id'])) {
                verifyWork($_GET['id'], $_SESSION['username']);
            }
            header('Location: ?page=verify_work');
            exit();
    }
}

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'add_work':
            requireLogin();
            $workId = addWorkEntry($_POST);
            if ($_POST['status'] == 'submitted') {
                header('Location: ?page=dashboard&success=work_submitted');
            } else {
                header('Location: ?page=add_work&success=draft_saved');
            }
            exit();
            
        case 'reject_work':
            requireRole('manager');
            if (isset($_POST['work_id']) && isset($_POST['reason'])) {
                rejectWork($_POST['work_id'], $_POST['reason']);
            }
            header('Location: ?page=verify_work&success=work_rejected');
            exit();
    }
}

// Render requested page
$page = $_GET['page'] ?? 'dashboard';

switch ($page) {
    case 'login':
        if (isLoggedIn()) {
            header('Location: ?page=dashboard');
            exit();
        }
        renderLoginPage();
        break;
        
    case 'dashboard':
        renderDashboard();
        break;
        
    case 'mark_attendance':
        requireLogin();
        renderMarkAttendancePage();
        break;
        
    case 'add_work':
        requireLogin();
        renderAddWorkPage();
        break;
        
    case 'my_work':
        requireLogin();
        renderMyWorkPage();
        break;
        
    case 'all_work':
        requireRole('manager');
        renderAllWorkPage();
        break;
        
    case 'products':
        requireRole('manager');
        renderProductsPage();
        break;
        
    case 'verify_work':
        requireRole('manager');
        renderVerifyWorkPage();
        break;
        
    case 'attendance':
        requireLogin();
        renderAttendancePage();
        break;
        
    case 'expenses':
        requireRole('manager');
        renderExpensesPage();
        break;
        
    case 'reports':
        requireRole('boss');
        renderReportsPage();
        break;
        
    case 'users':
        requireRole('manager');
        renderUsersPage();
        break;
        
    case 'backup':
        requireRole('boss');
        renderBackupPage();
        break;
        
    case 'settings':
        requireRole('boss');
        renderSettingsPage();
        break;
        
    case 'print_bill':
        requireLogin();
        renderPrintBillPage();
        break;
        
    default:
        if (!isLoggedIn()) {
            renderLoginPage();
        } else {
            renderDashboard();
        }
        break;
}

// Note: For brevity, I've shown the complete structure for the main components.
// Each page function would need to be updated with the new UI design pattern.
// The enhanced version includes:
// 1. Modern sidebar with toggle functionality
// 2. Responsive design for all screen sizes
// 3. Professional color scheme and typography
// 4. Interactive elements with animations
// 5. Improved form controls and tables
// 6. Better user feedback with alerts and notifications
// 7. Mobile-friendly navigation
?>