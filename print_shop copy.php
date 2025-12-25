<?php
/**
 * Print Shop Management System
 * Single File Version with JSON Storage
 * Author: Your Name
 * Version: 1.0
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
function renderNotImplemented($title) {
    requireLogin();
    renderHeader();
    echo "<div class='main-content'>
            <div class='alert alert-info'>
                <strong>$title</strong> is under development.
            </div>
          </div>";
    renderFooter();
}

function initializeJsonFiles() {
    $files = [
        USERS_FILE => ['admin' => [
            'id' => 1,
            'username' => 'admin',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'full_name' => 'System Administrator',
            'role' => 'boss',
            'created_at' => date('Y-m-d H:i:s'),
            'is_active' => true
        ]],
        ATTENDANCE_FILE => [],
        PRODUCTS_FILE => [],
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
    $workEntry = [
        'id' => $workId,
        'user_id' => $_SESSION['user_id'],
        'username' => $_SESSION['username'],
        'date' => $data['date'],
        'customer_name' => $data['customer_name'],
        'product_id' => $data['product_id'],
        'product_name' => getProductName($data['product_id']),
        'quantity' => $data['quantity'],
        'unit_price' => getProductPrice($data['product_id']),
        'total_amount' => $data['quantity'] * getProductPrice($data['product_id']),
        'status' => $data['status'],
        'bill_id' => null,
        'verified_by' => null,
        'verified_at' => null,
        'rejection_reason' => null,
        'created_at' => date('Y-m-d H:i:s')
    ];
    
    $works[$workId] = $workEntry;
    saveJsonData(WORK_FILE, $works);
    
    logAction('work_added', "Added work #$workId as " . $data['status']);
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

function markAttendance($userId, $date) {
    $attendance = getJsonData(ATTENDANCE_FILE);
    $key = $userId . '_' . $date;
    
    if (!isset($attendance[$key])) {
        $attendance[$key] = [
            'user_id' => $userId,
            'date' => $date,
            'check_in_time' => date('H:i:s'),
            'status' => 'Present',
            'marked_by' => 'system'
        ];
        saveJsonData(ATTENDANCE_FILE, $attendance);
        return true;
    }
    return false;
}

// ============================================
// HTML TEMPLATES
// ============================================

function renderHeader() {
    $role = $_SESSION['role'] ?? 'guest';
    $fullName = $_SESSION['full_name'] ?? 'Guest';
    
    $menuItems = [
        'dashboard' => '📊 Dashboard',
        'attendance' => '📅 Attendance',
        'add_work' => '➕ Add Work',
    ];
    
    if ($role == 'manager' || $role == 'boss') {
        $menuItems['verify_work'] = '✓ Verify Work';
        $menuItems['products'] = '🏷️ Products';
        $menuItems['expenses'] = '💰 Expenses';
    }
    
    if ($role == 'boss') {
        $menuItems['users'] = '👥 Users';
        $menuItems['reports'] = '📈 Reports';
        $menuItems['backup'] = '💾 Backup';
    }
    
    echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Print Shop Management System</title>
        <style>
            * { margin: 0; padding: 0; box-sizing: border-box; }
            body { font-family: Arial, sans-serif; background: #f0f2f5; }
            
            .header {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                padding: 1rem 2rem;
                display: flex;
                justify-content: space-between;
                align-items: center;
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            }
            
            .logo { display: flex; align-items: center; gap: 10px; }
            .logo h1 { font-size: 1.5rem; }
            
            .user-info {
                display: flex;
                align-items: center;
                gap: 15px;
            }
            
            .role-badge {
                padding: 4px 12px;
                border-radius: 20px;
                font-size: 12px;
                font-weight: bold;
            }
            
            .role-boss { background: #dc2626; }
            .role-manager { background: #f59e0b; }
            .role-user { background: #10b981; }
            
            .nav-menu {
                background: white;
                padding: 1rem 2rem;
                border-bottom: 1px solid #ddd;
                display: flex;
                gap: 20px;
                flex-wrap: wrap;
            }
            
            .nav-link {
                color: #333;
                text-decoration: none;
                padding: 8px 16px;
                border-radius: 4px;
                transition: all 0.3s;
            }
            
            .nav-link:hover {
                background: #667eea;
                color: white;
            }
            
            .nav-link.active {
                background: #667eea;
                color: white;
            }
            
            .main-content {
                padding: 2rem;
                max-width: 1200px;
                margin: 0 auto;
            }
            
            .card {
                background: white;
                border-radius: 8px;
                padding: 1.5rem;
                margin-bottom: 1.5rem;
                box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            }
            
            .btn {
                padding: 8px 16px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                font-weight: 500;
                text-decoration: none;
                display: inline-block;
            }
            
            .btn-primary { background: #667eea; color: white; }
            .btn-success { background: #10b981; color: white; }
            .btn-danger { background: #ef4444; color: white; }
            .btn-secondary { background: #6b7280; color: white; }
            
            .form-group { margin-bottom: 1rem; }
            .form-group label { display: block; margin-bottom: 5px; font-weight: 500; }
            .form-control {
                width: 100%;
                padding: 8px 12px;
                border: 1px solid #ddd;
                border-radius: 4px;
            }
            
            table {
                width: 100%;
                border-collapse: collapse;
                background: white;
                border-radius: 8px;
                overflow: hidden;
            }
            
            th, td {
                padding: 12px 15px;
                text-align: left;
                border-bottom: 1px solid #ddd;
            }
            
            th {
                background: #f8f9fa;
                font-weight: 600;
            }
            
            .status-badge {
                padding: 4px 12px;
                border-radius: 20px;
                font-size: 12px;
                font-weight: bold;
            }
            
            .status-draft { background: #d1d5db; color: #374151; }
            .status-submitted { background: #f59e0b; color: white; }
            .status-verified { background: #10b981; color: white; }
            .status-rejected { background: #ef4444; color: white; }
            
            .alert {
                padding: 12px 15px;
                border-radius: 4px;
                margin-bottom: 1rem;
            }
            
            .alert-success { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
            .alert-danger { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
            .alert-info { background: #dbeafe; color: #1e40af; border: 1px solid #bfdbfe; }
        </style>
    </head>
    <body>
        <div class="header">
            <div class="logo">
                <h1>🖨️ Print Shop Management</h1>
            </div>
            <div class="user-info">
                <span>' . htmlspecialchars($fullName) . '</span>
                <span class="role-badge role-' . $role . '">' . ucfirst($role) . '</span>
                <a href="?action=logout" class="btn btn-danger">Logout</a>
            </div>
        </div>
        
        <div class="nav-menu">';
    
    foreach ($menuItems as $page => $title) {
        $active = (($_GET['page'] ?? 'dashboard') == $page) ? 'active' : '';
        echo '<a href="?page=' . $page . '" class="nav-link ' . $active . '">' . $title . '</a>';
    }
    
    echo '</div>';
}

function renderFooter() {
    echo '
       
     <script>
        function toggleCustomTitle() {
            const category = document.getElementById("productCategory");
            if (!category) return;

            const customBox = document.getElementById("customTitleBox");
            const description = document.getElementById("descriptionField");

            if (category.value === "Custom") {
                customBox.style.display = "block";
                description.value = "";
                description.readOnly = true;
            } else {
                customBox.style.display = "none";
                description.readOnly = false;
            }
        }

        function syncDescription() {
            const custom = document.getElementById("customTitle");
            const description = document.getElementById("descriptionField");
            if (custom && description) {
                description.value = custom.value;
            }
        }
        </script> </body>
    </html>';
}

// ============================================
// PAGE RENDERING FUNCTIONS
// ============================================
 

function renderLoginPage() {
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
        <title>Login - Print Shop Management</title>
        <style>
            body {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                font-family: Arial, sans-serif;
            }
            
            .login-box {
                background: white;
                padding: 40px;
                border-radius: 10px;
                box-shadow: 0 10px 40px rgba(0,0,0,0.1);
                width: 100%;
                max-width: 400px;
            }
            
            .login-title {
                text-align: center;
                margin-bottom: 30px;
            }
            
            .login-title h1 {
                color: #333;
                margin-bottom: 10px;
            }
            
            .form-group {
                margin-bottom: 20px;
            }
            
            .form-control {
                width: 100%;
                padding: 12px;
                border: 1px solid #ddd;
                border-radius: 4px;
                font-size: 16px;
            }
            
            .btn-login {
                width: 100%;
                padding: 12px;
                background: #667eea;
                color: white;
                border: none;
                border-radius: 4px;
                font-size: 16px;
                cursor: pointer;
            }
            
            .btn-login:hover {
                background: #5a6fd8;
            }
            
            .error {
                background: #fee2e2;
                color: #991b1b;
                padding: 10px;
                border-radius: 4px;
                margin-bottom: 20px;
            }
            
            .note {
                text-align: center;
                margin-top: 20px;
                color: #666;
                font-size: 14px;
            }
        </style>
    </head>
    <body>
        <div class="login-box">
            <div class="login-title">
                <h1>🖨️ PrintShop Pro</h1>
                <p>Management System</p>
            </div>';
    
    if (isset($error)) {
        echo '<div class="error">' . htmlspecialchars($error) . '</div>';
    }
    
    echo '
            <form method="POST">
                <div class="form-group">
                    <input type="text" name="username" class="form-control" placeholder="Username" required value="admin">
                </div>
                
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Password" required value="admin123">
                </div>
                
                <button type="submit" name="login" class="btn-login">Login</button>
            </form>
            
            <div class="note">
                Default: admin / admin123
            </div>
        </div>
    </body>
    </html>';
}

function renderDashboard() {
    requireLogin();
    $works = getJsonData(WORK_FILE);
    $users = getJsonData(USERS_FILE);
    
    // Filter works based on role
    $filteredWorks = [];
    foreach ($works as $work) {
        if ($_SESSION['role'] == 'boss' || $_SESSION['role'] == 'manager') {
            $filteredWorks[] = $work;
        } elseif ($work['user_id'] == $_SESSION['user_id']) {
            $filteredWorks[] = $work;
        }
    }
    
    // Calculate stats
    $stats = [
        'total_work' => count($filteredWorks),
        'verified_work' => 0,
        'today_work' => 0,
        'pending_verification' => 0
    ];
    
    foreach ($filteredWorks as $work) {
        if ($work['status'] == 'verified') $stats['verified_work']++;
        if ($work['date'] == date('Y-m-d')) $stats['today_work']++;
        if ($work['status'] == 'submitted') $stats['pending_verification']++;
    }
    
    renderHeader();
    echo '<div class="main-content">
        <h1>📊 Dashboard</h1>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin: 30px 0;">
            <div class="card">
                <h3>Total Work</h3>
                <div style="font-size: 32px; font-weight: bold;">' . $stats['total_work'] . '</div>
            </div>
            
            <div class="card">
                <h3>Verified Work</h3>
                <div style="font-size: 32px; font-weight: bold;">' . $stats['verified_work'] . '</div>
            </div>
            
            <div class="card">
                <h3>Today\'s Work</h3>
                <div style="font-size: 32px; font-weight: bold;">' . $stats['today_work'] . '</div>
            </div>';
    
    if ($_SESSION['role'] == 'boss' || $_SESSION['role'] == 'manager') {
        echo '<div class="card">
                <h3>Pending Verification</h3>
                <div style="font-size: 32px; font-weight: bold;">' . $stats['pending_verification'] . '</div>
            </div>';
    }
    
    echo '</div>';
    
    // Recent Work Table
    if (!empty($filteredWorks)) {
        echo '<div class="card">
            <h3>Recent Work Entries</h3>
            <table>
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
        
        echo '<th>Actions</th></tr></thead><tbody>';
        
        $recentWorks = array_slice($filteredWorks, 0, 10);
        foreach ($recentWorks as $work) {
            echo '<tr>
                <td>' . $work['date'] . '</td>
                <td>' . htmlspecialchars($work['customer_name']) . '</td>
                <td>' . htmlspecialchars($work['product_name']) . '</td>
                <td>₹' . number_format($work['total_amount'], 2) . '</td>
                <td><span class="status-badge status-' . $work['status'] . '">' . ucfirst($work['status']) . '</span></td>';
            
            if ($_SESSION['role'] == 'boss' || $_SESSION['role'] == 'manager') {
                echo '<td>' . htmlspecialchars($work['username']) . '</td>';
            }
            
            echo '<td>';
            if ($work['status'] == 'draft' && $work['user_id'] == $_SESSION['user_id']) {
                echo '<a href="?page=edit_work&id=' . $work['id'] . '" class="btn btn-primary">Edit</a> ';
                echo '<a href="?action=submit_work&id=' . $work['id'] . '" class="btn btn-success">Submit</a>';
            } elseif ($work['status'] == 'submitted' && ($_SESSION['role'] == 'boss' || $_SESSION['role'] == 'manager')) {
                echo '<a href="?action=verify_work&id=' . $work['id'] . '" class="btn btn-success">Verify</a> ';
                echo '<a href="?page=reject_work&id=' . $work['id'] . '" class="btn btn-danger">Reject</a>';
            } elseif ($work['status'] == 'verified') {
                echo '<a href="?page=generate_bill&id=' . $work['id'] . '" class="btn btn-primary">Generate Bill</a>';
            }
            echo '</td></tr>';
        }
        
        echo '</tbody></table></div>';
    }
    
    renderFooter();
}

function renderAddWorkPage() {
    requireLogin();
    markAttendance($_SESSION['user_id'], date('Y-m-d'));
    
    $products = getJsonData(PRODUCTS_FILE);
    
    renderHeader();
    echo '<div class="main-content">
        <h1>➕ Add New Work</h1>
        
        <div class="card">
            <form method="POST">
                <input type="hidden" name="action" value="add_work">
                
                <div class="form-group">
                    <label>Date</label>
                    <input type="date" name="date" class="form-control" value="' . date('Y-m-d') . '" required>
                </div>
                
                <div class="form-group">
                    <label>Customer Name *</label>
                    <input type="text" name="customer_name" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label>Product *</label>
                    <select name="product_id" class="form-control" required>';
    
    foreach ($products as $product) {
        echo '<option value="' . $product['id'] . '">' . htmlspecialchars($product['description']) . ' - ₹' . $product['price'] . '</option>';
    }
    
    echo '</select>
                </div>
                
                <div class="form-group">
                    <label>Quantity *</label>
                    <input type="number" name="quantity" class="form-control" min="1" value="1" required>
                </div>
                
                <div class="form-group">
                    <label>Save as:</label><br>
                    <label><input type="radio" name="status" value="draft" checked> Draft</label>
                    <label><input type="radio" name="status" value="submitted"> Submit for Verification</label>
                </div>
                
                <div style="margin-top: 20px;">
                    <button type="submit" class="btn btn-primary">Save Work</button>
                    <a href="?page=dashboard" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>';
    renderFooter();
}

function renderProductsPage() {
    requireRole('manager');
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
        if ($_POST['action'] == 'add_product') {
            $products = getJsonData(PRODUCTS_FILE);
            $productId = empty($products)
    ? 1
    : max(array_column($products, 'id')) + 1;

            
            $products[] = [
                'id' => $productId,
                'category' => $_POST['category'],
                'description' => $_POST['description'],
                'price' => $_POST['price'],
                'created_by' => $_SESSION['username'],
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            saveJsonData(PRODUCTS_FILE, $products);
            logAction('product_added', "Added product: " . $_POST['description']);
            echo '<div class="alert alert-success">Product added successfully!</div>';
        }
    }
    
    $products = getJsonData(PRODUCTS_FILE);
    
    renderHeader();
    echo '<div class="main-content">
        <h1>🏷️ Products Management</h1>
        
        <div class="card">
            <h3>Add New Product</h3>
           <form method="POST">
    <input type="hidden" name="action" value="add_product">

    <div class="form-group">
        <label>Category</label>
        <select name="category" id="productCategory"
                class="form-control" required
                onchange="toggleCustomTitle()">
            <option value="">Select Category</option>
            <option value="Card Print">Card Print</option>
            <option value="Paper Print (Black)">Paper Print (Black)</option>
            <option value="Paper Print (Color)">Paper Print (Color)</option>
            <option value="Panaflex Print">Panaflex Print</option>
            <option value="Custom">Custom / Other</option>
        </select>
    </div>

    <div class="form-group" id="customTitleBox" style="display:none;">
        <label>Custom Item Title</label>
        <input type="text"
               id="customTitle"
               class="form-control"
               placeholder="Enter custom product name"
               onkeyup="syncDescription()">
    </div>

    <div class="form-group">
        <label>Description</label>
        <input type="text"
               name="description"
               id="descriptionField"
               class="form-control"
               required
               placeholder="e.g., A4 Color Print">
    </div>

    <div class="form-group">
        <label>Price (RS:)</label>
        <input type="number"
               name="price"
               class="form-control"
               step="0.01"
               min="0"
               required>
    </div>

    <button type="submit" class="btn btn-primary">Add Product</button>
</form>

        </div>
        
        <div class="card">
            <h3>Product List</h3>';
    
    if (empty($products)) {
        echo '<p>No products added yet.</p>';
    } else {
        echo '<table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Price (RS)</th>
                        <th>Added By</th>
                        <th>Added On</th>
                    </tr>
                </thead>
                <tbody>';
        
        foreach ($products as $product) {
            echo '<tr>
                    <td>' . $product['id'] . '</td>
                    <td>' . htmlspecialchars($product['category']) . '</td>
                    <td>' . htmlspecialchars($product['description']) . '</td>
                    <td>₹' . number_format($product['price'], 2) . '</td>
                    <td>' . htmlspecialchars($product['created_by'] ?? 'System') . '</td>
                    <td>' . ($product['created_at'] ?? 'N/A') . '</td>
                </tr>';
        }
        
        echo '</tbody></table>';
    }
    
    echo '</div></div>';
    renderFooter();
}

function renderVerifyWorkPage() {
    requireRole('manager');
    
    $works = getJsonData(WORK_FILE);
    $pendingWorks = [];
    
    foreach ($works as $work) {
        if ($work['status'] == 'submitted') {
            $pendingWorks[] = $work;
        }
    }
    
    renderHeader();
    echo '<div class="main-content">
        <h1>✓ Verify Submitted Work</h1>';
    
    if (empty($pendingWorks)) {
        echo '<div class="alert alert-info">No work pending verification.</div>';
    } else {
        echo '<div class="card">
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Employee</th>
                            <th>Customer</th>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Amount</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>';
        
        foreach ($pendingWorks as $work) {
            echo '<tr>
                    <td>' . $work['date'] . '</td>
                    <td>' . htmlspecialchars($work['username']) . '</td>
                    <td>' . htmlspecialchars($work['customer_name']) . '</td>
                    <td>' . htmlspecialchars($work['product_name']) . '</td>
                    <td>' . $work['quantity'] . '</td>
                    <td>₹' . number_format($work['total_amount'], 2) . '</td>
                    <td>
                        <a href="?action=verify_work&id=' . $work['id'] . '" class="btn btn-success">✓ Verify</a>
                        <a href="?page=reject_work&id=' . $work['id'] . '" class="btn btn-danger">✗ Reject</a>
                    </td>
                </tr>';
        }
        
        echo '</tbody></table></div>';
    }
    
    echo '</div>';
    renderFooter();
}

function renderUsersPage() {
    requireRole('boss');
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
        if ($_POST['action'] == 'add_user') {
            $users = getJsonData(USERS_FILE);
            $username = $_POST['username'];
            
            if (!isset($users[$username])) {
                $userId = count($users) + 1;
                $users[$username] = [
                    'id' => $userId,
                    'username' => $username,
                    'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                    'full_name' => $_POST['full_name'],
                    'role' => $_POST['role'],
                    'created_at' => date('Y-m-d H:i:s'),
                    'is_active' => true
                ];
                
                saveJsonData(USERS_FILE, $users);
                logAction('user_added', "Added user: $username");
                echo '<div class="alert alert-success">User added successfully!</div>';
            } else {
                echo '<div class="alert alert-danger">Username already exists!</div>';
            }
        }
    }
    
    $users = getJsonData(USERS_FILE);
    
    renderHeader();
    echo '<div class="main-content">
        <h1>👥 User Management</h1>
        
        <div class="card">
            <h3>Add New User</h3>
            <form method="POST">
                <input type="hidden" name="action" value="add_user">
                
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="full_name" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label>Role</label>
                    <select name="role" class="form-control" required>
                        <option value="user">User (Employee)</option>
                        <option value="manager">Manager</option>
                        <option value="boss">Boss (Admin)</option>
                    </select>
                </div>
                
                <button type="submit" class="btn btn-primary">Add User</button>
            </form>
        </div>
        
        <div class="card">
            <h3>User List</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Full Name</th>
                        <th>Role</th>
                        <th>Created</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>';
    
    foreach ($users as $user) {
        echo '<tr>
                <td>' . $user['id'] . '</td>
                <td>' . htmlspecialchars($user['username']) . '</td>
                <td>' . htmlspecialchars($user['full_name']) . '</td>
                <td><span class="role-badge role-' . $user['role'] . '">' . ucfirst($user['role']) . '</span></td>
                <td>' . $user['created_at'] . '</td>
                <td>' . ($user['is_active'] ? 'Active' : 'Inactive') . '</td>
            </tr>';
    }
    
    echo '</tbody></table></div></div>';
    renderFooter();
}

function renderBackupPage() {
    requireRole('boss');
    
    if (isset($_GET['action']) && $_GET['action'] == 'backup') {
        $allData = [
            'users' => getJsonData(USERS_FILE),
            'attendance' => getJsonData(ATTENDANCE_FILE),
            'products' => getJsonData(PRODUCTS_FILE),
            'work' => getJsonData(WORK_FILE),
            'expenses' => getJsonData(EXPENSES_FILE),
            'logs' => getJsonData(LOGS_FILE)
        ];
        
        $backupFile = BACKUP_DIR . 'backup_' . date('Y-m-d_H-i-s') . '.json';
        file_put_contents($backupFile, json_encode($allData, JSON_PRETTY_PRINT));
        
        logAction('backup_created', "Created backup: " . basename($backupFile));
        echo '<div class="alert alert-success">Backup created successfully!</div>';
    }
    
    $backups = glob(BACKUP_DIR . '*.json');
    
    renderHeader();
    echo '<div class="main-content">
        <h1>💾 Backup & Restore</h1>
        
        <div class="card">
            <h3>Create Backup</h3>
            <p>Create a complete backup of all system data (JSON format)</p>
            <a href="?page=backup&action=backup" class="btn btn-primary">Create Backup Now</a>
        </div>
        
        <div class="card">
            <h3>Existing Backups</h3>';
    
    if (empty($backups)) {
        echo '<p>No backups found.</p>';
    } else {
        echo '<table>
                <thead>
                    <tr>
                        <th>Filename</th>
                        <th>Size</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>';
        
        rsort($backups);
        foreach ($backups as $backup) {
            $filename = basename($backup);
            $size = round(filesize($backup) / 1024, 2);
            $date = date('Y-m-d H:i:s', filemtime($backup));
            
            echo '<tr>
                    <td>' . $filename . '</td>
                    <td>' . $size . ' KB</td>
                    <td>' . $date . '</td>
                    <td>
                        <a href="' . $backup . '" download class="btn btn-primary">Download</a>
                        <a href="?page=backup&action=delete&file=' . $filename . '" class="btn btn-danger" onclick="return confirm(\'Delete this backup?\')">Delete</a>
                    </td>
                </tr>';
        }
        
        echo '</tbody></table>';
    }
    
    echo '</div></div>';
    renderFooter();
}

// ============================================
// MAIN APPLICATION ROUTING
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
                header('Location: ?page=dashboard');
            } else {
                header('Location: ?page=add_work&success=1');
            }
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
        
    case 'add_work':
        renderAddWorkPage();
        break;
        
    case 'products':
        renderProductsPage();
        break;
        
    case 'verify_work':
        renderVerifyWorkPage();
        break;
        
    case 'users':
        renderUsersPage();
        break;
        
    case 'backup':
        renderBackupPage();
        break;
            case 'attendance':
        renderNotImplemented('Attendance');
        break;

    case 'expenses':
        renderNotImplemented('Expenses');
        break;

    case 'reports':
        renderNotImplemented('Reports');
        break;

    case 'edit_work':
        renderNotImplemented('Edit Work');
        break;

    case 'reject_work':
        renderNotImplemented('Reject Work');
        break;

    case 'generate_bill':
        renderNotImplemented('Generate Bill');
        break;

    default:
        if (!isLoggedIn()) {
            renderLoginPage();
        } else {
            renderDashboard();
        }
        break;
}
?>