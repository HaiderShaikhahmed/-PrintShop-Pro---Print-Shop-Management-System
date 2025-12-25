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
        PRODUCTS_FILE => [
            // Card Printing
            [
                'id' => 1,
                'category' => 'Card Print',
                'description' => 'Business Card (100 pcs)',
                'price' => 500,
                'created_by' => 'admin',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 2,
                'category' => 'Card Print',
                'description' => 'Visiting Card (100 pcs)',
                'price' => 300,
                'created_by' => 'admin',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 3,
                'category' => 'Card Print',
                'description' => 'PVC Card',
                'price' => 100,
                'created_by' => 'admin',
                'created_at' => date('Y-m-d H:i:s')
            ],
            
            // Paper Printing - Color
            [
                'id' => 4,
                'category' => 'Paper Print (Color)',
                'description' => 'A4 Color Print',
                'price' => 20,
                'created_by' => 'admin',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 5,
                'category' => 'Paper Print (Color)',
                'description' => 'A3 Color Print',
                'price' => 40,
                'created_by' => 'admin',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 6,
                'category' => 'Paper Print (Color)',
                'description' => 'Photo Print 4x6',
                'price' => 30,
                'created_by' => 'admin',
                'created_at' => date('Y-m-d H:i:s')
            ],
            
            // Paper Printing - Black & White
            [
                'id' => 7,
                'category' => 'Paper Print (Black)',
                'description' => 'A4 Black & White',
                'price' => 5,
                'created_by' => 'admin',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 8,
                'category' => 'Paper Print (Black)',
                'description' => 'A3 Black & White',
                'price' => 10,
                'created_by' => 'admin',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 9,
                'category' => 'Paper Print (Black)',
                'description' => 'Legal Size B&W',
                'price' => 8,
                'created_by' => 'admin',
                'created_at' => date('Y-m-d H:i:s')
            ],
            
            // Flex Printing
            [
                'id' => 10,
                'category' => 'Panaflex Print',
                'description' => '3x2 feet Flex',
                'price' => 800,
                'created_by' => 'admin',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 11,
                'category' => 'Panaflex Print',
                'description' => '4x3 feet Flex',
                'price' => 1200,
                'created_by' => 'admin',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 12,
                'category' => 'Panaflex Print',
                'description' => '6x4 feet Flex',
                'price' => 2000,
                'created_by' => 'admin',
                'created_at' => date('Y-m-d H:i:s')
            ],
            
            // Binding & Lamination
            [
                'id' => 13,
                'category' => 'Binding',
                'description' => 'Spiral Binding',
                'price' => 100,
                'created_by' => 'admin',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 14,
                'category' => 'Lamination',
                'description' => 'A4 Lamination',
                'price' => 20,
                'created_by' => 'admin',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 15,
                'category' => 'Lamination',
                'description' => 'A3 Lamination',
                'price' => 40,
                'created_by' => 'admin',
                'created_at' => date('Y-m-d H:i:s')
            ],
            
            // Scanning & Xerox
            [
                'id' => 16,
                'category' => 'Scanning',
                'description' => 'A4 Scan',
                'price' => 10,
                'created_by' => 'admin',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 17,
                'category' => 'Xerox',
                'description' => 'A4 Xerox',
                'price' => 3,
                'created_by' => 'admin',
                'created_at' => date('Y-m-d H:i:s')
            ],
            
            // Design Services
            [
                'id' => 18,
                'category' => 'Design',
                'description' => 'Logo Design',
                'price' => 1500,
                'created_by' => 'admin',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 19,
                'category' => 'Design',
                'description' => 'Brochure Design',
                'price' => 1000,
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
    
    // Allow users to add work for past dates with warning (already handled in JS)
    
    $workEntry = [
        'id' => $workId,
        'user_id' => $_SESSION['user_id'],
        'username' => $_SESSION['username'],
        'date' => $data['date'],
        'customer_name' => $data['customer_name'],
        'product_id' => $data['product_id'],
        'product_name' => $productName,
        'quantity' => $data['quantity'],
        'unit_price' => $unitPrice,
        'total_amount' => $totalAmount,
        'status' => $data['status'],
        'priority' => $data['priority'] ?? 'normal',
        'notes' => $data['notes'] ?? '',
        'delivery_date' => $data['delivery_date'] ?? null,
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
            'check_in_time' => date('h:i:s A'),  // Changed to 12-hour format
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
    'mark_attendance' => '✅ Mark Attendance',
    'attendance' => '📅 Attendance',
    'add_work' => '➕ Add Work',
];
    
    if ($role == 'manager' || $role == 'boss') {
        $menuItems['verify_work'] = '✓ Verify Work';
        $menuItems['products'] = '🏷️ Products';
        $menuItems['expenses'] = '💰 Expenses';
    }
    
   if ($role == 'boss' || $role == 'manager') {
    $menuItems['users'] = '👥 Users';
}

if ($role == 'boss') {
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
            .btn-info { background: #3b82f6; color: white; }
            .btn-warning { background: #f59e0b; color: white; }
            
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
                display: inline-block;
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
            .alert-warning { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
            
            .dashboard-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 20px;
                margin: 20px 0;
            }
            
            .stat-card {
                background: white;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 2px 10px rgba(0,0,0,0.05);
                text-align: center;
            }
            
            .stat-value {
                font-size: 32px;
                font-weight: bold;
                margin: 10px 0;
            }
            
            .stat-label {
                color: #666;
                font-size: 14px;
            }
            
            .modal {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.5);
                z-index: 1000;
                justify-content: center;
                align-items: center;
            }
            
            .modal-content {
                background: white;
                padding: 30px;
                border-radius: 8px;
                max-width: 500px;
                width: 90%;
            }
            
            .action-buttons {
                display: flex;
                gap: 10px;
                flex-wrap: wrap;
            }
            
            .filter-form {
                background: #f8f9fa;
                padding: 15px;
                border-radius: 6px;
                margin-bottom: 20px;
                display: flex;
                gap: 15px;
                flex-wrap: wrap;
                align-items: flex-end;
            }
            
            .filter-group {
                flex: 1;
                min-width: 200px;
            }
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
        
        function toggleCustomCategory() {
            const category = document.getElementById("expenseCategory");
            if (!category) return;

            const customBox = document.getElementById("customCategoryBox");
            const customInput = document.getElementById("customCategory");

            if (category.value === "Other") {
                customBox.style.display = "block";
                if (customInput) customInput.required = true;
            } else {
                customBox.style.display = "none";
                if (customInput) customInput.required = false;
            }
        }
        
        function showRejectModal(workId) {
            document.getElementById("rejectWorkId").value = workId;
            document.getElementById("rejectModal").style.display = "flex";
        }
        
        function closeModal() {
            document.getElementById("rejectModal").style.display = "none";
        }
        
        function confirmAction(message, url) {
            if (confirm(message)) {
                window.location.href = url;
            }
        }
        
        function printBill(workId) {
            window.open("?page=print_bill&id=" + workId, "_blank");
        }
       function validatePasswordReset(form) {
            const newPassword = form.new_password.value;
            const confirmPassword = form.confirm_password.value;
            
            if (newPassword !== confirmPassword) {
                alert("Passwords do not match!");
                return false;
            }
            
            if (newPassword.length < 6) {
                alert("Password must be at least 6 characters long!");
                return false;
            }
            
            return confirm("Are you sure you want to reset this user\'s password?");
        }
        </script>
    </body>
    </html>';

    //     <script>
    //     function toggleCustomTitle() {
    //         const category = document.getElementById("productCategory");
    //         if (!category) return;

    //         const customBox = document.getElementById("customTitleBox");
    //         const description = document.getElementById("descriptionField");

    //         if (category.value === "Custom") {
    //             customBox.style.display = "block";
    //             description.value = "";
    //             description.readOnly = true;
    //         } else {
    //             customBox.style.display = "none";
    //             description.readOnly = false;
    //         }
    //     }

    //     function syncDescription() {
    //         const custom = document.getElementById("customTitle");
    //         const description = document.getElementById("descriptionField");
    //         if (custom && description) {
    //             description.value = custom.value;
    //         }
    //     }
        
    //     function showRejectModal(workId) {
    //         document.getElementById("rejectWorkId").value = workId;
    //         document.getElementById("rejectModal").style.display = "flex";
    //     }
        
    //     function closeModal() {
    //         document.getElementById("rejectModal").style.display = "none";
    //     }
        
    //     function confirmAction(message, url) {
    //         if (confirm(message)) {
    //             window.location.href = url;
    //         }
    //     }
        
    //     function printBill(workId) {
    //         window.open("?page=print_bill&id=" + workId, "_blank");
    //     }
    //     </script>
    // </body>
    // </html>';
}
// function renderFooter() {
//     echo '
//         <script>
//         function toggleCustomTitle() {
//             const category = document.getElementById("productCategory");
//             if (!category) return;

//             const customBox = document.getElementById("customTitleBox");
//             const description = document.getElementById("descriptionField");

//             if (category.value === "Custom") {
//                 customBox.style.display = "block";
//                 description.value = "";
//                 description.readOnly = true;
//             } else {
//                 customBox.style.display = "none";
//                 description.readOnly = false;
//             }
//         }

//         function syncDescription() {
//             const custom = document.getElementById("customTitle");
//             const description = document.getElementById("descriptionField");
//             if (custom && description) {
//                 description.value = custom.value;
//             }
//         }
        
//         function showRejectModal(workId) {
//             document.getElementById("rejectWorkId").value = workId;
//             document.getElementById("rejectModal").style.display = "flex";
//         }
        
//         function closeModal() {
//             document.getElementById("rejectModal").style.display = "none";
//         }
        
//         function confirmAction(message, url) {
//             if (confirm(message)) {
//                 window.location.href = url;
//             }
//         }
        
//         function printBill(workId) {
//             window.open("?page=print_bill&id=" + workId, "_blank");
//         }
//         </script>
//     </body>
//     </html>';
// }

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
    $attendance = getJsonData(ATTENDANCE_FILE);
    
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
        'pending_verification' => 0,
        'total_revenue' => 0,
        'total_expenses' => 0
    ];
    
    foreach ($filteredWorks as $work) {
        if ($work['status'] == 'verified') {
            $stats['verified_work']++;
            $stats['total_revenue'] += $work['total_amount'];
        }
        if ($work['date'] == date('Y-m-d')) $stats['today_work']++;
        if ($work['status'] == 'submitted') $stats['pending_verification']++;
    }
    
    // Calculate expenses
    $expenses = getJsonData(EXPENSES_FILE);
    foreach ($expenses as $expense) {
        $stats['total_expenses'] += $expense['amount'];
    }
    
    renderHeader();
    echo '<div class="main-content">
        <h1>📊 Dashboard</h1>
        
        <div class="dashboard-grid">
            <div class="stat-card">
                <div class="stat-label">Total Work</div>
                <div class="stat-value">' . $stats['total_work'] . '</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-label">Verified Work</div>
                <div class="stat-value">' . $stats['verified_work'] . '</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-label">Today\'s Work</div>
                <div class="stat-value">' . $stats['today_work'] . '</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-label">Total Revenue</div>
                <div class="stat-value">Rs:' . number_format($stats['total_revenue'], 2) . '</div>
            </div>';
    
    if ($_SESSION['role'] == 'boss' || $_SESSION['role'] == 'manager') {
        echo '<div class="stat-card">
                <div class="stat-label">Pending Verification</div>
                <div class="stat-value">' . $stats['pending_verification'] . '</div>
            </div>';
    }
    
    if ($_SESSION['role'] == 'boss') {
        echo '<div class="stat-card">
                <div class="stat-label">Total Expenses</div>
                <div class="stat-value">Rs:' . number_format($stats['total_expenses'], 2) . '</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Net Profit</div>
                <div class="stat-value">Rs:' . number_format($stats['total_revenue'] - $stats['total_expenses'], 2) . '</div>
            </div>';
    }
    
    echo '</div>';

        // Check today's attendance (ADD THIS CODE)
    $today = date('Y-m-d');
    $attendance = getJsonData(ATTENDANCE_FILE);
    $attendanceKey = $_SESSION['user_id'] . '_' . $today;
    $hasMarkedAttendance = isset($attendance[$attendanceKey]);

    if (!in_array($_SESSION['role'], ['boss', 'manager']) && !$hasMarkedAttendance) {
        echo '<div class="card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; margin-top: 20px;">
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <div>
                        <h3 style="margin: 0 0 10px 0;">⏰ Attendance Reminder</h3>
                        <p style="margin: 0; opacity: 0.9;">You haven\'t marked your attendance for today.</p>
                    </div>
                    <a href="?page=mark_attendance" class="btn btn-light" style="font-weight: bold;">
                        ✅ Mark Attendance Now
                    </a>
                </div>
              </div>';
    }
    
    echo '</div>'; // Close the main-content div
    
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
        
        $recentWorks = array_slice(array_reverse($filteredWorks), 0, 10);
        foreach ($recentWorks as $work) {
            echo '<tr>
                <td>' . $work['date'] . '</td>
                <td>' . htmlspecialchars($work['customer_name']) . '</td>
                <td>' . htmlspecialchars($work['product_name']) . '</td>
                <td>Rs:' . number_format($work['total_amount'], 2) . '</td>
                <td><span class="status-badge status-' . $work['status'] . '">' . ucfirst($work['status']) . '</span></td>';
            
            if ($_SESSION['role'] == 'boss' || $_SESSION['role'] == 'manager') {
                echo '<td>' . htmlspecialchars($work['username']) . '</td>';  }
            echo '<td class="action-buttons">';
            if ($work['status'] == 'draft' && $work['user_id'] == $_SESSION['user_id']) {
                echo '<a href="?page=edit_work&id=' . $work['id'] . '" class="btn btn-primary btn-sm">Edit</a>
                      <a href="?action=submit_work&id=' . $work['id'] . '" class="btn btn-success btn-sm" onclick="return confirm(\'Submit for verification?\')">Submit</a>';
            } elseif ($work['status'] == 'submitted' && ($_SESSION['role'] == 'boss' || $_SESSION['role'] == 'manager')) {
                echo '<a href="?action=verify_work&id=' . $work['id'] . '" class="btn btn-success btn-sm" onclick="return confirm(\'Verify this work?\')">Verify</a>
                      <button onclick="showRejectModal(\'' . $work['id'] . '\')" class="btn btn-danger btn-sm">Reject</button>';
            } elseif ($work['status'] == 'verified') {
                echo '<button onclick="printBill(\'' . $work['id'] . '\')" class="btn btn-primary btn-sm">Print Bill</a>';
            }
            echo '</td></tr>';
        }
        
        echo '</tbody></table></div>';
    }
    
    renderFooter();
}

function renderAddWorkPage() {
    requireLogin();
    
    // Mark attendance when user accesses this page
    markAttendance($_SESSION['user_id'], date('Y-m-d'));
    
    $products = getJsonData(PRODUCTS_FILE);
    
    // Get user's recent customers for auto-suggest
    $works = getJsonData(WORK_FILE);
    $recentCustomers = [];
    foreach ($works as $work) {
        if ($work['user_id'] == $_SESSION['user_id']) {
            $recentCustomers[$work['customer_name']] = true;
        }
    }
    $recentCustomers = array_keys($recentCustomers);
    
    // Get user's draft works
    $draftWorks = [];
    foreach ($works as $work) {
        if ($work['user_id'] == $_SESSION['user_id'] && $work['status'] == 'draft') {
            $draftWorks[] = $work;
        }
    }
    
    if (isset($_GET['success'])) {
        echo '<div class="alert alert-success">Work saved successfully!</div>';
    }
    
    if (isset($_GET['error'])) {
        echo '<div class="alert alert-danger">' . htmlspecialchars($_GET['error']) . '</div>';
    }
    
    renderHeader();
    echo '<div class="main-content">
        <h1>➕ Add New Work</h1>';
    
    // Show draft works if any
    if (!empty($draftWorks)) {
        echo '<div class="card" style="background-color: #fef3c7; border-left: 4px solid #f59e0b;">
                <h3 style="color: #92400e;">📝 Draft Works</h3>
                <p>You have ' . count($draftWorks) . ' draft work(s) saved. You can edit or submit them.</p>
                <table style="margin-top: 15px;">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Customer</th>
                            <th>Product</th>
                            <th>Amount</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>';
        
        foreach ($draftWorks as $work) {
            echo '<tr>
                    <td>' . $work['date'] . '</td>
                    <td>' . htmlspecialchars($work['customer_name']) . '</td>
                    <td>' . htmlspecialchars($work['product_name']) . '</td>
                    <td>Rs:' . number_format($work['total_amount'], 2) . '</td>
                    <td class="action-buttons">
                        <a href="?page=edit_work&id=' . $work['id'] . '" class="btn btn-primary btn-sm">Edit</a>
                        <a href="?action=submit_work&id=' . $work['id'] . '" class="btn btn-success btn-sm" onclick="return confirm(\'Submit this work for verification?\')">Submit</a>
                        <a href="?page=add_work&action=duplicate&id=' . $work['id'] . '" class="btn btn-info btn-sm">Duplicate</a>
                    </td>
                </tr>';
        }
        
        echo '</tbody>
                </table>
            </div>';
    }
    
    echo '<div class="card">
            <h3>Create New Work Entry</h3>
            <form method="POST" id="addWorkForm">
                <input type="hidden" name="action" value="add_work">
                
                <div class="form-group">
                    <label>Date *</label>
                    <input type="date" name="date" id="workDate" class="form-control" value="' . date('Y-m-d') . '" required 
                           onchange="checkDateRestriction()">
                    <small class="text-muted" id="dateMessage"></small>
                </div>
                
                <div class="form-group">
                    <label>Customer Name *</label>
                    <input type="text" name="customer_name" id="customerName" class="form-control" required 
                           placeholder="Enter customer name" list="customerSuggestions">
                    <datalist id="customerSuggestions">';
    
    // Add recent customers to datalist
    foreach ($recentCustomers as $customer) {
        echo '<option value="' . htmlspecialchars($customer) . '">';
    }
    
    echo '</datalist>
                    <small class="text-muted">Start typing to see recent customers</small>
                </div>
                
                <div class="form-row" style="display: flex; gap: 15px; margin-bottom: 15px;">
                    <div style="flex: 1;">
                        <label>Product Category</label>
                        <select name="product_category" id="productCategory" class="form-control" onchange="loadProductsByCategory()">
                            <option value="">All Categories</option>';
    
    // Get unique categories
    $categories = [];
    foreach ($products as $product) {
        if (!in_array($product['category'], $categories)) {
            $categories[] = $product['category'];
        }
    }
    sort($categories);
    
    foreach ($categories as $category) {
        echo '<option value="' . htmlspecialchars($category) . '">' . htmlspecialchars($category) . '</option>';
    }
    
    echo '</select>
                    </div>
                    <div style="flex: 2;">
                        <label>Product *</label>
                        <select name="product_id" id="productSelect" class="form-control" required onchange="updateProductPrice()">
                            <option value="">Select Product</option>';
    
    foreach ($products as $product) {
        echo '<option value="' . $product['id'] . '" data-price="' . $product['price'] . '" data-category="' . htmlspecialchars($product['category']) . '">
                ' . htmlspecialchars($product['description']) . ' - Rs:' . number_format($product['price'], 2) . '
              </option>';
    }
    
    echo '</select>
                    </div>
                </div>
                
                <div class="form-row" style="display: flex; gap: 15px; margin-bottom: 15px;">
                    <div style="flex: 1;">
                        <label>Quantity *</label>
                        <input type="number" name="quantity" id="quantity" class="form-control" min="1" value="1" required 
                               oninput="calculateTotal()" step="1">
                    </div>
                    <div style="flex: 1;">
    <label>Unit Price (Rs:) *</label>
    <input type="number" name="unit_price" id="unitPrice" class="form-control" step="0.01" min="0" required
           oninput="calculateTotal()" placeholder="Enter unit price">
</div>
                    <div style="flex: 1;">
                        <label>Total Amount (Rs:)</label>
                        <input type="number" id="totalAmount" class="form-control" step="0.01" readonly>
                        <input type="hidden" name="total_amount" id="totalAmountHidden">
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Additional Notes</label>
                    <textarea name="notes" class="form-control" rows="3" placeholder="Any special instructions, measurements, design details..."></textarea>
                </div>
                
                <div class="form-group">
                    <label>Work Priority</label>
                    <select name="priority" class="form-control">
                        <option value="normal">Normal</option>
                        <option value="high">High Priority</option>
                        <option value="urgent">Urgent</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Delivery Date (Optional)</label>
                    <input type="date" name="delivery_date" class="form-control" min="' . date('Y-m-d') . '">
                </div>
                
                <div class="form-group">
                    <label>Save as:</label><br>
                    <div style="display: flex; gap: 20px; margin-top: 10px;">
                        <label style="display: flex; align-items: center; gap: 8px;">
                            <input type="radio" name="status" value="draft" checked>
                            <span class="status-badge status-draft">Draft (Save for later)</span>
                        </label>
                        <label style="display: flex; align-items: center; gap: 8px;">
                            <input type="radio" name="status" value="submitted">
                            <span class="status-badge status-submitted">Submit for Verification</span>
                        </label>
                    </div>
                    <small class="text-muted">Draft: Can edit later | Submitted: Sent to manager for verification</small>
                </div>
                
                <div class="action-buttons">
                    <button type="button" onclick="addAnotherItem()" class="btn btn-info">➕ Add Another Item</button>
                    <button type="submit" class="btn btn-primary">Save Work</button>
                    <a href="?page=dashboard" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>';
    
    // JavaScript for enhanced functionality
    echo '<script>
let workItems = [];
let currentItemIndex = 0;

function checkDateRestriction() {
    const dateInput = document.getElementById("workDate");
    const dateMessage = document.getElementById("dateMessage");
    
    if (!dateInput.value) {
        dateMessage.textContent = "";
        return true;
    }
    
    const selectedDate = new Date(dateInput.value);
    const today = new Date();
    
    // Set both dates to start of day for accurate comparison
    selectedDate.setHours(0, 0, 0, 0);
    today.setHours(0, 0, 0, 0);
    
    // Get time in milliseconds for comparison
    const selectedTime = selectedDate.getTime();
    const todayTime = today.getTime();
    
    if (selectedTime > todayTime) {
        dateMessage.textContent = "⚠️ You cannot add work for future dates";
        dateMessage.style.color = "#ef4444";
        return false;
    } else if (selectedTime < todayTime) {
        dateMessage.textContent = "✅ Adding work for past date (requires manager approval)";
        dateMessage.style.color = "#f59e0b";
        return true;
    } else {
        dateMessage.textContent = "✅ Adding work for today";
        dateMessage.style.color = "#10b981";
        return true;
    }
}

function loadProductsByCategory() {
    const category = document.getElementById("productCategory").value;
    const productSelect = document.getElementById("productSelect");
    const allOptions = productSelect.querySelectorAll("option");
    
    // Reset product selection
    productSelect.value = "";
    updateProductPrice();
    
    // Show/hide options based on category
    allOptions.forEach(option => {
        if (option.value === "") {
            option.style.display = "block";
        } else if (category === "" || option.getAttribute("data-category") === category) {
            option.style.display = "block";
        } else {
            option.style.display = "none";
        }
    });
}

function updateProductPrice() {
    const productSelect = document.getElementById("productSelect");
    const selectedOption = productSelect.options[productSelect.selectedIndex];
    const unitPriceInput = document.getElementById("unitPrice");
    
    if (selectedOption.value && selectedOption.getAttribute("data-price")) {
        const price = parseFloat(selectedOption.getAttribute("data-price"));
        unitPriceInput.value = price.toFixed(2);
    }
    calculateTotal();
}

function checkPriceOverride() {
    const unitPriceInput = document.getElementById("unitPrice");
    const productSelect = document.getElementById("productSelect");
    const selectedOption = productSelect.options[productSelect.selectedIndex];
    const productPrice = selectedOption.value ? parseFloat(selectedOption.getAttribute("data-price")) || 0 : 0;
    const enteredPrice = parseFloat(unitPriceInput.value) || 0;
    
    if (productPrice > 0 && Math.abs(enteredPrice - productPrice) > 0.01) {
        const discountPercent = ((productPrice - enteredPrice) / productPrice * 100).toFixed(1);
        const priceDifference = Math.abs(productPrice - enteredPrice).toFixed(2);
        
        if (enteredPrice < productPrice) {
            unitPriceInput.style.borderColor = "#10b981";
            unitPriceInput.style.backgroundColor = "#d1fae5";
            unitPriceInput.title = `Discount: ${discountPercent}% (Rs:${priceDifference} less than standard price)`;
        } else if (enteredPrice > productPrice) {
            unitPriceInput.style.borderColor = "#3b82f6";
            unitPriceInput.style.backgroundColor = "#dbeafe";
            unitPriceInput.title = `Premium: ${discountPercent}% (Rs:${priceDifference} more than standard price)`;
        }
    } else {
        unitPriceInput.style.borderColor = "";
        unitPriceInput.style.backgroundColor = "";
        unitPriceInput.title = "Standard price";
    }
    calculateTotal();
}

function calculateTotal() {
    const quantity = parseInt(document.getElementById("quantity").value) || 0;
    const unitPrice = parseFloat(document.getElementById("unitPrice").value) || 0;
    const totalAmountInput = document.getElementById("totalAmount");
    const totalAmountHidden = document.getElementById("totalAmountHidden");
    
    const total = quantity * unitPrice;
    totalAmountInput.value = total.toFixed(2);
    totalAmountHidden.value = total.toFixed(2);
    
    // Update display color based on whether price matches product price
    const productSelect = document.getElementById("productSelect");
    const selectedOption = productSelect.options[productSelect.selectedIndex];
    const productPrice = selectedOption.value ? parseFloat(selectedOption.getAttribute("data-price")) || 0 : 0;
    
    if (productPrice > 0 && Math.abs(unitPrice - productPrice) > 0.01) {
        totalAmountInput.style.borderColor = "#f59e0b";
        totalAmountInput.style.backgroundColor = "#fef3c7";
    } else {
        totalAmountInput.style.borderColor = "";
        totalAmountInput.style.backgroundColor = "";
    }
}

function addAnotherItem() {
    // Save current item to array
    const currentItem = {
        product_id: document.getElementById("productSelect").value,
        quantity: document.getElementById("quantity").value,
        unit_price: document.getElementById("unitPrice").value,
        total_amount: document.getElementById("totalAmount").value
    };
    
    if (!currentItem.product_id) {
        alert("Please select a product first!");
        return;
    }
    
    workItems.push(currentItem);
    currentItemIndex++;
    
    // Reset form for next item
    document.getElementById("productSelect").value = "";
    document.getElementById("quantity").value = "1";
    document.getElementById("unitPrice").value = "";
    document.getElementById("totalAmount").value = "";
    
    // Update item counter
    alert("Item added! Total items: " + workItems.length + "\n\nYou can continue adding more items or click Save Work when done.");
    
    // Focus on product selection
    document.getElementById("productSelect").focus();
}

// Initialize form
document.addEventListener("DOMContentLoaded", function() {
    updateProductPrice();
    checkDateRestriction();
    
    // Auto-focus customer name
    document.getElementById("customerName").focus();
});

// Form validation
document.getElementById("addWorkForm").addEventListener("submit", function(e) {
    const customerName = document.getElementById("customerName").value.trim();
    const productId = document.getElementById("productSelect").value;
    const unitPrice = parseFloat(document.getElementById("unitPrice").value) || 0;
    const quantity = parseInt(document.getElementById("quantity").value) || 0;
    const dateInput = document.getElementById("workDate");
    
    // Check date restriction
    if (!dateInput.value) {
        e.preventDefault();
        alert("Please select a date!");
        dateInput.focus();
        return;
    }
    
    const selectedDate = new Date(dateInput.value);
    const today = new Date();
    
    // Set both dates to start of day
    selectedDate.setHours(0, 0, 0, 0);
    today.setHours(0, 0, 0, 0);
    
    const selectedTime = selectedDate.getTime();
    const todayTime = today.getTime();
    
    // Check if future date (for regular users)
    if (selectedTime > todayTime) {
        e.preventDefault();
        alert("Cannot add work for future dates!");
        dateInput.focus();
        return;
    }
    
    // Regular users cannot add work for past dates
    if (selectedTime < todayTime) {
        if (!confirm("You are adding work for a past date. This requires manager approval. Continue?")) {
            e.preventDefault();
            return;
        }
    }
    
    if (!customerName) {
        e.preventDefault();
        alert("Please enter customer name!");
        document.getElementById("customerName").focus();
        return;
    }
    
    if (!productId) {
        e.preventDefault();
        alert("Please select a product!");
        document.getElementById("productSelect").focus();
        return;
    }
    
    if (unitPrice <= 0) {
        e.preventDefault();
        alert("Please enter a valid unit price (greater than 0)!");
        document.getElementById("unitPrice").focus();
        return;
    }
    
    if (quantity <= 0) {
        e.preventDefault();
        alert("Please enter a valid quantity (greater than 0)!");
        document.getElementById("quantity").focus();
        return;
    }
    
    // Check if price is significantly different from standard price
    const productSelect = document.getElementById("productSelect");
    const selectedOption = productSelect.options[productSelect.selectedIndex];
    const productPrice = selectedOption.value ? parseFloat(selectedOption.getAttribute("data-price")) || 0 : 0;
    
    if (productPrice > 0) {
        const priceDifference = Math.abs(unitPrice - productPrice);
        const differencePercent = (priceDifference / productPrice * 100);
        
        if (differencePercent > 20) { // More than 20% difference
            if (!confirm(`You are entering a price (Rs:${unitPrice.toFixed(2)}) that is ${differencePercent.toFixed(1)}% ${unitPrice < productPrice ? 'lower' : 'higher'} than the standard price (Rs:${productPrice.toFixed(2)}).\\n\\nDo you want to continue?`)) {
                e.preventDefault();
                return;
            }
        }
    }
    
    // Check if we have multiple items
    if (workItems.length > 0) {
        if (!confirm(`You have ${workItems.length + 1} items to save.\\nTotal amount will be calculated.\\n\\nContinue?`)) {
            e.preventDefault();
            return;
        }
    }
});
</script>;
    
    renderFooter();
}

function renderEditWorkPage() {
    requireLogin();
    
    $workId = $_GET['id'] ?? '';
    $works = getJsonData(WORK_FILE);
    $products = getJsonData(PRODUCTS_FILE);
    
    if (!isset($works[$workId])) {
        header('Location: ?page=dashboard');
        exit();
    }
    
    $work = $works[$workId];
    
    // Check permission
    if ($work['user_id'] != $_SESSION['user_id'] || $work['status'] != 'draft') {
        header('Location: ?page=dashboard');
        exit();
    }
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'update_work') {
        $works[$workId]['customer_name'] = $_POST['customer_name'];
        $works[$workId]['product_id'] = $_POST['product_id'];
        $works[$workId]['product_name'] = getProductName($_POST['product_id']);
        $works[$workId]['quantity'] = $_POST['quantity'];
        $works[$workId]['unit_price'] = getProductPrice($_POST['product_id']);
        $works[$workId]['total_amount'] = $_POST['quantity'] * getProductPrice($_POST['product_id']);
        $works[$workId]['date'] = $_POST['date'];
        
        saveJsonData(WORK_FILE, $works);
        logAction('work_updated', "Updated work #$workId");
        
        header('Location: ?page=dashboard&updated=1');
        exit();
    }
    
    renderHeader();
    echo '<div class="main-content">
        <h1>✏️ Edit Work</h1>
        
        <div class="card">
            <form method="POST">
                <input type="hidden" name="action" value="update_work">
                
                <div class="form-group">
                    <label>Date</label>
                    <input type="date" name="date" class="form-control" value="' . $work['date'] . '" required>
                </div>
                
                <div class="form-group">
                    <label>Customer Name *</label>
                    <input type="text" name="customer_name" class="form-control" value="' . htmlspecialchars($work['customer_name']) . '" required>
                </div>
                
                <div class="form-group">
                    <label>Product *</label>
                    <select name="product_id" class="form-control" required>';
    
    foreach ($products as $product) {
        $selected = ($product['id'] == $work['product_id']) ? 'selected' : '';
        echo '<option value="' . $product['id'] . '" ' . $selected . '>' . htmlspecialchars($product['description']) . ' - Rs:' . $product['price'] . '</option>';
    }
    
    echo '</select>
                </div>
                
                <div class="form-group">
                    <label>Quantity *</label>
                    <input type="number" name="quantity" class="form-control" min="1" value="' . $work['quantity'] . '" required>
                </div>
                
                <div class="form-group">
                    <label>Current Amount</label>
                    <input type="text" class="form-control" value="Rs:' . number_format($work['total_amount'], 2) . '" readonly>
                </div>
                
                <div class="action-buttons">
                    <button type="submit" class="btn btn-primary">Update Work</button>
                    <a href="?page=dashboard" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>';
    renderFooter();
}

// function renderProductsPage() {
//     requireRole('manager');
    
//     if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
//         if ($_POST['action'] == 'add_product') {
//             $products = getJsonData(PRODUCTS_FILE);
//             $productId = empty($products) ? 1 : (max(array_column($products, 'id')) + 1);
            
//             $products[] = [
//                 'id' => $productId,
//                 'category' => $_POST['category'],
//                 'description' => $_POST['description'],
//                 'price' => $_POST['price'],
//                 'created_by' => $_SESSION['username'],
//                 'created_at' => date('Y-m-d H:i:s')
//             ];
            
//             saveJsonData(PRODUCTS_FILE, $products);
//             logAction('product_added', "Added product: " . $_POST['description']);
//             echo '<div class="alert alert-success">Product added successfully!</div>';
//         }
//     }
    
//     $products = getJsonData(PRODUCTS_FILE);
    
//     renderHeader();
//     echo '<div class="main-content">
//         <h1>🏷️ Products Management</h1>
        
//         <div class="card">
//             <h3>Add New Product</h3>
//             <form method="POST">
//                 <input type="hidden" name="action" value="add_product">

//                 <div class="form-group">
//                     <label>Category</label>
//                     <select name="category" id="productCategory" class="form-control" required onchange="toggleCustomTitle()">
//                         <option value="">Select Category</option>
//                         <option value="Card Print">Card Print</option>
//                         <option value="Paper Print (Black)">Paper Print (Black)</option>
//                         <option value="Paper Print (Color)">Paper Print (Color)</option>
//                         <option value="Panaflex Print">Panaflex Print</option>
//                         <option value="Custom">Custom / Other</option>
//                     </select>
//                 </div>

//                 <div class="form-group" id="customTitleBox" style="display:none;">
//                     <label>Custom Item Title</label>
//                     <input type="text" id="customTitle" class="form-control" placeholder="Enter custom product name" onkeyup="syncDescription()">
//                 </div>

//                 <div class="form-group">
//                     <label>Description</label>
//                     <input type="text" name="description" id="descriptionField" class="form-control" required placeholder="e.g., A4 Color Print">
//                 </div>

//                 <div class="form-group">
//                     <label>Price (Rs:)</label>
//                     <input type="number" name="price" class="form-control" step="0.01" min="0" required>
//                 </div>

//                 <button type="submit" class="btn btn-primary">Add Product</button>
//             </form>
//         </div>
        
//         <div class="card">
//             <h3>Product List</h3>';
    
//     if (empty($products)) {
//         echo '<p>No products added yet.</p>';
//     } else {
//         echo '<table>
//                 <thead>
//                     <tr>
//                         <th>ID</th>
//                         <th>Category</th>
//                         <th>Description</th>
//                         <th>Price (Rs:)</th>
//                         <th>Added By</th>
//                         <th>Added On</th>
//                     </tr>
//                 </thead>
//                 <tbody>';
        
//         foreach ($products as $product) {
//             echo '<tr>
//                     <td>' . $product['id'] . '</td>
//                     <td>' . htmlspecialchars($product['category']) . '</td>
//                     <td>' . htmlspecialchars($product['description']) . '</td>
//                     <td>Rs:' . number_format($product['price'], 2) . '</td>
//                     <td>' . htmlspecialchars($product['created_by'] ?? 'System') . '</td>
//                     <td>' . ($product['created_at'] ?? 'N/A') . '</td>
//                 </tr>';
//         }
        
//         echo '</tbody></table>';
//     }
    
//     echo '</div></div>';
//     renderFooter();
// }
function renderProductsPage() {
    requireRole('manager');
    
    // Handle actions
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
        if ($_POST['action'] == 'add_product') {
            $products = getJsonData(PRODUCTS_FILE);
            $productId = empty($products) ? 1 : (max(array_column($products, 'id')) + 1);
            
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
        
        if ($_POST['action'] == 'update_product') {
            $products = getJsonData(PRODUCTS_FILE);
            $productId = $_POST['product_id'];
            
            foreach ($products as &$product) {
                if ($product['id'] == $productId) {
                    $product['category'] = $_POST['category'];
                    $product['description'] = $_POST['description'];
                    $product['price'] = $_POST['price'];
                    $product['updated_at'] = date('Y-m-d H:i:s');
                    $product['updated_by'] = $_SESSION['username'];
                    break;
                }
            }
            
            saveJsonData(PRODUCTS_FILE, $products);
            logAction('product_updated', "Updated product ID: $productId");
            echo '<div class="alert alert-success">Product updated successfully!</div>';
        }
    }
    
    // Handle delete action (GET request)
    if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
        $products = getJsonData(PRODUCTS_FILE);
        $productId = $_GET['id'];
        $newProducts = [];
        $deletedProduct = null;
        
        foreach ($products as $product) {
            if ($product['id'] == $productId) {
                $deletedProduct = $product;
            } else {
                $newProducts[] = $product;
            }
        }
        
        if ($deletedProduct) {
            saveJsonData(PRODUCTS_FILE, $newProducts);
            logAction('product_deleted', "Deleted product: " . $deletedProduct['description']);
            echo '<div class="alert alert-success">Product deleted successfully!</div>';
        }
    }
    
    $products = getJsonData(PRODUCTS_FILE);
    
    renderHeader();
    echo '<div class="main-content">
        <h1>🏷️ Products Management</h1>';
    
    // Add/Edit Product Form
    if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])) {
        // Edit Product Mode
        $productId = $_GET['id'];
        $editProduct = null;
        
        foreach ($products as $product) {
            if ($product['id'] == $productId) {
                $editProduct = $product;
                break;
            }
        }
        
        if ($editProduct) {
            echo '<div class="card">
                    <h3>✏️ Edit Product</h3>
                    <form method="POST">
                        <input type="hidden" name="action" value="update_product">
                        <input type="hidden" name="product_id" value="' . $editProduct['id'] . '">
                        
                        <div class="form-group">
                            <label>Category</label>
                            <select name="category" id="productCategory" class="form-control" required onchange="toggleCustomTitle()">
                                <option value="">Select Category</option>
                                <option value="Card Print"' . ($editProduct['category'] == 'Card Print' ? ' selected' : '') . '>Card Print</option>
                                <option value="Paper Print (Black)"' . ($editProduct['category'] == 'Paper Print (Black)' ? ' selected' : '') . '>Paper Print (Black)</option>
                                <option value="Paper Print (Color)"' . ($editProduct['category'] == 'Paper Print (Color)' ? ' selected' : '') . '>Paper Print (Color)</option>
                                <option value="Panaflex Print"' . ($editProduct['category'] == 'Panaflex Print' ? ' selected' : '') . '>Panaflex Print</option>
                                <option value="Custom"' . ($editProduct['category'] == 'Custom' ? ' selected' : '') . '>Custom / Other</option>
                            </select>
                        </div>
                        
                        <div class="form-group" id="customTitleBox" style="display:' . ($editProduct['category'] == 'Custom' ? 'block' : 'none') . ';">
                            <label>Custom Item Title</label>
                            <input type="text" id="customTitle" class="form-control" placeholder="Enter custom product name" onkeyup="syncDescription()" value="' . ($editProduct['category'] == 'Custom' ? htmlspecialchars($editProduct['description']) : '') . '">
                        </div>
                        
                        <div class="form-group">
                            <label>Description</label>
                            <input type="text" name="description" id="descriptionField" class="form-control" required value="' . htmlspecialchars($editProduct['description']) . '"' . ($editProduct['category'] == 'Custom' ? ' readonly' : '') . '>
                        </div>
                        
                        <div class="form-group">
                            <label>Price (Rs:)</label>
                            <input type="number" name="price" class="form-control" step="0.01" min="0" required value="' . $editProduct['price'] . '">
                        </div>
                        
                        <div class="action-buttons">
                            <button type="submit" class="btn btn-primary">Update Product</button>
                            <a href="?page=products" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>';
        }
    } else {
        // Add Product Mode (Default)
        echo '<div class="card">
                <h3>➕ Add New Product</h3>
                <form method="POST">
                    <input type="hidden" name="action" value="add_product">
                    
                    <div class="form-group">
                        <label>Category</label>
                        <select name="category" id="productCategory" class="form-control" required onchange="toggleCustomTitle()">
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
                        <input type="text" id="customTitle" class="form-control" placeholder="Enter custom product name" onkeyup="syncDescription()">
                    </div>
                    
                    <div class="form-group">
                        <label>Description</label>
                        <input type="text" name="description" id="descriptionField" class="form-control" required placeholder="e.g., A4 Color Print">
                    </div>
                    
                    <div class="form-group">
                        <label>Price (Rs:)</label>
                        <input type="number" name="price" class="form-control" step="0.01" min="0" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Add Product</button>
                </form>
            </div>';
    }
    
    // Product List Table
    echo '<div class="card">
            <h3>📋 Product List</h3>';
    
    if (empty($products)) {
        echo '<p>No products added yet.</p>';
    } else {
        echo '<table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Price (Rs:)</th>
                        <th>Added By</th>
                        <th>Added On</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>';
        
        foreach ($products as $product) {
            echo '<tr>
                    <td>' . $product['id'] . '</td>
                    <td>' . htmlspecialchars($product['category']) . '</td>
                    <td>' . htmlspecialchars($product['description']) . '</td>
                    <td>Rs:' . number_format($product['price'], 2) . '</td>
                    <td>' . htmlspecialchars($product['created_by'] ?? 'System') . '</td>
                    <td>' . ($product['created_at'] ?? 'N/A') . '</td>
                    <td class="action-buttons">
                        <a href="?page=products&action=edit&id=' . $product['id'] . '" class="btn btn-primary btn-sm">Edit</a>
                        <a href="?page=products&action=delete&id=' . $product['id'] . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to delete this product?\')">Delete</a>
                    </td>
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
                    <td>Rs:' . number_format($work['total_amount'], 2) . '</td>
                    <td class="action-buttons">
                        <a href="?action=verify_work&id=' . $work['id'] . '" class="btn btn-success btn-sm" onclick="return confirm(\'Verify this work?\')">✓ Verify</a>
                        <button onclick="showRejectModal(\'' . $work['id'] . '\')" class="btn btn-danger btn-sm">✗ Reject</button>
                    </td>
                </tr>';
        }
        
        echo '</tbody></table></div>';
    }
    
    // Reject Modal
    echo '<div id="rejectModal" class="modal">
            <div class="modal-content">
                <h3>Reject Work</h3>
                <form method="POST" action="?action=reject_work">
                    <input type="hidden" name="work_id" id="rejectWorkId">
                    <div class="form-group">
                        <label>Reason for Rejection *</label>
                        <textarea name="reason" class="form-control" rows="3" required placeholder="Enter reason for rejection..."></textarea>
                    </div>
                    <div class="action-buttons">
                        <button type="submit" class="btn btn-danger">Reject Work</button>
                        <button type="button" onclick="closeModal()" class="btn btn-secondary">Cancel</button>
                    </div>
                </form>
            </div>
        </div>';
    
    echo '</div>';
    renderFooter();
}
function renderAttendancePage() {
    requireLogin();
    
    $attendance = getJsonData(ATTENDANCE_FILE);
    $users = getJsonData(USERS_FILE);
    
    // Get current user's attendance
    $userAttendance = [];
    foreach ($attendance as $record) {
        if ($_SESSION['role'] == 'boss' || $_SESSION['role'] == 'manager') {
            $userAttendance[] = $record;
        } elseif ($record['user_id'] == $_SESSION['user_id']) {
            $userAttendance[] = $record;
        }
    }
    
    // Get month filter
    $selectedMonth = $_GET['month'] ?? date('Y-m');
    
    // Filter by month
    $filteredAttendance = [];
    foreach ($userAttendance as $record) {
        if (substr($record['date'], 0, 7) == $selectedMonth) {
            $filteredAttendance[] = $record;
        }
    }
    
    renderHeader();
    echo '<div class="main-content">
        <h1>📅 Attendance</h1>
        
        <div class="filter-form">
            <div class="filter-group">
                <label>Select Month</label>
                <input type="month" name="month" class="form-control" value="' . $selectedMonth . '" onchange="window.location=\'?page=attendance&month=\' + this.value">
            </div>
            <div class="filter-group">
                <a href="?page=attendance&month=' . date('Y-m') . '" class="btn btn-secondary">Current Month</a>
            </div>
        </div>';
    
    if (empty($filteredAttendance)) {
        echo '<div class="alert alert-info">No attendance records found for selected month.</div>';
    } else {
        echo '<div class="card">
                <h3>Attendance Records - ' . date('F Y', strtotime($selectedMonth . '-01')) . '</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Check-in Time</th>
                            <th>Status</th>';
        
        if ($_SESSION['role'] == 'boss' || $_SESSION['role'] == 'manager') {
            echo '<th>Employee</th>';
        }
        
        echo '<th>Marked By</th></tr></thead><tbody>';
        
        usort($filteredAttendance, function($a, $b) {
            return strtotime($b['date']) - strtotime($a['date']);
        });
        
        foreach ($filteredAttendance as $record) {
            $userName = '';
            if ($_SESSION['role'] == 'boss' || $_SESSION['role'] == 'manager') {
                foreach ($users as $user) {
                    if ($user['id'] == $record['user_id']) {
                        $userName = $user['full_name'];
                        break;
                    }
                }
            }
            
            $statusClass = '';
            if ($record['status'] == 'Present') $statusClass = 'status-verified';
            elseif ($record['status'] == 'Late') $statusClass = 'status-submitted';
            elseif ($record['status'] == 'Absent') $statusClass = 'status-rejected';
            
            // Convert 24-hour time to 12-hour AM/PM format
            $checkInTime = $record['check_in_time'] ?? 'N/A';
            if ($checkInTime != 'N/A') {
                $checkInTime = date("h:i A", strtotime($checkInTime));  // Removed seconds for cleaner display
            }
            
            echo '<tr>
                    <td>' . $record['date'] . '</td>
                    <td>' . $checkInTime . '</td>
                    <td><span class="status-badge ' . $statusClass . '">' . $record['status'] . '</span></td>';
            
            if ($_SESSION['role'] == 'boss' || $_SESSION['role'] == 'manager') {
                echo '<td>' . htmlspecialchars($userName) . '</td>';
            }
            
            echo '<td>' . ($record['marked_by'] ?? 'System') . '</td>
                </tr>';
        }
        
        echo '</tbody></table></div>';
    }
    
    // Summary
    $summary = [
        'present' => 0,
        'late' => 0,
        'absent' => 0,
        'total' => count($filteredAttendance)
    ];
    
    foreach ($filteredAttendance as $record) {
        if ($record['status'] == 'Present') $summary['present']++;
        elseif ($record['status'] == 'Late') $summary['late']++;
        elseif ($record['status'] == 'Absent') $summary['absent']++;
    }
    
    echo '<div class="dashboard-grid">
            <div class="stat-card">
                <div class="stat-label">Total Days</div>
                <div class="stat-value">' . $summary['total'] . '</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Present</div>
                <div class="stat-value" style="color: #10b981;">' . $summary['present'] . '</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Late</div>
                <div class="stat-value" style="color: #f59e0b;">' . $summary['late'] . '</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Absent</div>
                <div class="stat-value" style="color: #ef4444;">' . $summary['absent'] . '</div>
            </div>
        </div>';
    
    echo '</div>';
    renderFooter();
}
function renderMarkAttendancePage() {
    requireLogin();
    
    $today = date('Y-m-d');
    $attendance = getJsonData(ATTENDANCE_FILE);
    $attendanceKey = $_SESSION['user_id'] . '_' . $today;
    
    $hasMarkedAttendance = isset($attendance[$attendanceKey]);
    
    // Handle attendance marking
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
        if ($_POST['action'] == 'mark_attendance') {
            if (!$hasMarkedAttendance) {
                $attendance[$attendanceKey] = [
                    'user_id' => $_SESSION['user_id'],
                    'date' => $today,
                    'check_in_time' => date('H:i:s'),
                    'status' => 'Present',
                    'marked_by' => $_SESSION['username']
                ];
                saveJsonData(ATTENDANCE_FILE, $attendance);
                logAction('attendance_marked', "Marked attendance for " . $today);
                $hasMarkedAttendance = true;
                echo '<div class="alert alert-success">Attendance marked successfully!</div>';
            }
        }
    }
    
    renderHeader();
    echo '<div class="main-content">
        <h1>✅ Mark Attendance</h1>
        
        <div class="card">
            <div style="text-align: center; padding: 30px;">
                <div style="font-size: 48px; margin-bottom: 20px;">' . ($hasMarkedAttendance ? '✅' : '⏰') . '</div>
                <h3>' . ($hasMarkedAttendance ? 'Attendance Already Marked' : 'Mark Your Attendance') . '</h3>
                
                <div style="background: #f8f9fa; padding: 20px; border-radius: 10px; margin: 20px 0;">
                    <div style="font-size: 18px; color: #666;">Today\'s Date</div>
                    <div style="font-size: 32px; font-weight: bold; color: #333;">' . date('l, F j, Y') . '</div>
                </div>';
    
    if ($hasMarkedAttendance) {
        $record = $attendance[$attendanceKey];
        $checkInTime = date("h:i A", strtotime($record['check_in_time']));
        
        echo '<div style="background: #d1fae5; padding: 20px; border-radius: 10px; margin: 20px 0;">
                <div style="display: flex; justify-content: space-around; text-align: center;">
                    <div>
                        <div style="color: #666; font-size: 14px;">Check-in Time</div>
                        <div style="font-size: 24px; font-weight: bold; color: #065f46;">' . $checkInTime . '</div>
                    </div>
                    <div>
                        <div style="color: #666; font-size: 14px;">Status</div>
                        <div style="font-size: 24px; font-weight: bold; color: #065f46;">' . $record['status'] . '</div>
                    </div>
                </div>
            </div>
            <p>Your attendance for today has been recorded.</p>
            <a href="?page=dashboard" class="btn btn-primary">Go to Dashboard</a>';
    } else {
        echo '<p>Click the button below to mark your attendance for today.</p>
              <form method="POST">
                <input type="hidden" name="action" value="mark_attendance">
                <button type="submit" class="btn btn-success" style="font-size: 20px; padding: 15px 40px;">
                    ✅ Mark Attendance Now
                </button>
              </form>';
    }
    
    echo '</div>
        </div>
    </div>';
    renderFooter();
}
// function renderAttendancePage() {
//     requireLogin();
    
//     $attendance = getJsonData(ATTENDANCE_FILE);
//     $users = getJsonData(USERS_FILE);
    
//     // Get current user's attendance
//     $userAttendance = [];
//     foreach ($attendance as $record) {
//         if ($_SESSION['role'] == 'boss' || $_SESSION['role'] == 'manager') {
//             $userAttendance[] = $record;
//         } elseif ($record['user_id'] == $_SESSION['user_id']) {
//             $userAttendance[] = $record;
//         }
//     }
    
//     // Get month filter
//     $selectedMonth = $_GET['month'] ?? date('Y-m');
    
//     // Filter by month
//     $filteredAttendance = [];
//     foreach ($userAttendance as $record) {
//         if (substr($record['date'], 0, 7) == $selectedMonth) {
//             $filteredAttendance[] = $record;
//         }
//     }
    
//     renderHeader();
//     echo '<div class="main-content">
//         <h1>📅 Attendance</h1>
        
//         <div class="filter-form">
//             <div class="filter-group">
//                 <label>Select Month</label>
//                 <input type="month" name="month" class="form-control" value="' . $selectedMonth . '" onchange="window.location=\'?page=attendance&month=\' + this.value">
//             </div>
//             <div class="filter-group">
//                 <a href="?page=attendance&month=' . date('Y-m') . '" class="btn btn-secondary">Current Month</a>
//             </div>
//         </div>';
    
//     if (empty($filteredAttendance)) {
//         echo '<div class="alert alert-info">No attendance records found for selected month.</div>';
//     } else {
//         echo '<div class="card">
//                 <h3>Attendance Records - ' . date('F Y', strtotime($selectedMonth . '-01')) . '</h3>
//                 <table>
//                     <thead>
//                         <tr>
//                             <th>Date</th>
//                             <th>Check-in Time</th>
//                             <th>Status</th>';
        
//         if ($_SESSION['role'] == 'boss' || $_SESSION['role'] == 'manager') {
//             echo '<th>Employee</th>';
//         }
        
//         echo '<th>Marked By</th></tr></thead><tbody>';
        
//         usort($filteredAttendance, function($a, $b) {
//             return strtotime($b['date']) - strtotime($a['date']);
//         });
        
//          foreach ($filteredAttendance as $record) {
//     $userName = '';
//     if ($_SESSION['role'] == 'boss' || $_SESSION['role'] == 'manager') {
//         foreach ($users as $user) {
//             if ($user['id'] == $record['user_id']) {
//                 $userName = $user['full_name'];
//                 break;
//             }
//         }
//     }
    
//     $statusClass = '';
//     if ($record['status'] == 'Present') $statusClass = 'status-verified';
//     elseif ($record['status'] == 'Late') $statusClass = 'status-submitted';
//     elseif ($record['status'] == 'Absent') $statusClass = 'status-rejected';
    
//     // Convert 24-hour time to 12-hour AM/PM format
//     $checkInTime = $record['check_in_time'] ?? 'N/A';
//     if ($checkInTime != 'N/A') {
//         $checkInTime = date("h:i:s A", strtotime($checkInTime));
//     }
    
//     echo '<tr>
//             <td>' . $record['date'] . '</td>
//             <td>' . $checkInTime . '</td>
//             <td><span class="status-badge ' . $statusClass . '">' . $record['status'] . '</span></td>';
    
//     if ($_SESSION['role'] == 'boss' || $_SESSION['role'] == 'manager') {
//         echo '<td>' . htmlspecialchars($userName) . '</td>';
//     }
    
//     echo '<td>' . ($record['marked_by'] ?? 'System') . '</td>
//         </tr>';
// }
        
//         echo '</tbody></table></div>';
//     }
    
//     // Summary
//     $summary = [
//         'present' => 0,
//         'late' => 0,
//         'absent' => 0,
//         'total' => count($filteredAttendance)
//     ];
    
//     foreach ($filteredAttendance as $record) {
//         if ($record['status'] == 'Present') $summary['present']++;
//         elseif ($record['status'] == 'Late') $summary['late']++;
//         elseif ($record['status'] == 'Absent') $summary['absent']++;
//     }
    
//     echo '<div class="dashboard-grid">
//             <div class="stat-card">
//                 <div class="stat-label">Total Days</div>
//                 <div class="stat-value">' . $summary['total'] . '</div>
//             </div>
//             <div class="stat-card">
//                 <div class="stat-label">Present</div>
//                 <div class="stat-value" style="color: #10b981;">' . $summary['present'] . '</div>
//             </div>
//             <div class="stat-card">
//                 <div class="stat-label">Late</div>
//                 <div class="stat-value" style="color: #f59e0b;">' . $summary['late'] . '</div>
//             </div>
//             <div class="stat-card">
//                 <div class="stat-label">Absent</div>
//                 <div class="stat-value" style="color: #ef4444;">' . $summary['absent'] . '</div>
//             </div>
//         </div>';
    
//     echo '</div>';
//     renderFooter();
// }
function renderExpensesPage() {
    requireRole('manager');
    
    // Handle actions
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
        if ($_POST['action'] == 'add_expense') {
            $expenses = getJsonData(EXPENSES_FILE);
            $expenseId = time() . rand(100, 999);
            
            // Add new category to list if it doesn't exist
            $newCategory = $_POST['category'];
            if ($newCategory == 'Other' && !empty($_POST['custom_category'])) {
                $newCategory = $_POST['custom_category'];
            }
            
            $expenses[$expenseId] = [
                'id' => $expenseId,
                'category' => $newCategory,
                'description' => $_POST['description'],
                'amount' => $_POST['amount'],
                'date' => $_POST['date'],
                'added_by' => $_SESSION['username'],
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            saveJsonData(EXPENSES_FILE, $expenses);
            logAction('expense_added', "Added expense: " . $_POST['description'] . " - Rs:" . $_POST['amount']);
            echo '<div class="alert alert-success">Expense added successfully!</div>';
        }
        
        if ($_POST['action'] == 'update_expense') {
            $expenses = getJsonData(EXPENSES_FILE);
            $expenseId = $_POST['expense_id'];
            
            if (isset($expenses[$expenseId])) {
                // Add new category to list if it doesn't exist
                $newCategory = $_POST['category'];
                if ($newCategory == 'Other' && !empty($_POST['custom_category'])) {
                    $newCategory = $_POST['custom_category'];
                }
                
                $expenses[$expenseId]['category'] = $newCategory;
                $expenses[$expenseId]['description'] = $_POST['description'];
                $expenses[$expenseId]['amount'] = $_POST['amount'];
                $expenses[$expenseId]['date'] = $_POST['date'];
                $expenses[$expenseId]['updated_at'] = date('Y-m-d H:i:s');
                $expenses[$expenseId]['updated_by'] = $_SESSION['username'];
                
                saveJsonData(EXPENSES_FILE, $expenses);
                logAction('expense_updated', "Updated expense ID: $expenseId");
                echo '<div class="alert alert-success">Expense updated successfully!</div>';
            }
        }
    }
    
    // Handle delete action (GET request)
    if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
        $expenses = getJsonData(EXPENSES_FILE);
        $expenseId = $_GET['id'];
        
        if (isset($expenses[$expenseId])) {
            $deletedExpense = $expenses[$expenseId];
            unset($expenses[$expenseId]);
            saveJsonData(EXPENSES_FILE, $expenses);
            
            logAction('expense_deleted', "Deleted expense: " . $deletedExpense['description']);
            echo '<div class="alert alert-success">Expense deleted successfully!</div>';
        }
    }
    
    $expenses = getJsonData(EXPENSES_FILE);
    $expenseArray = array_values($expenses);
    
    // Get month filter
    $selectedMonth = $_GET['month'] ?? date('Y-m');
    $selectedCategory = $_GET['category'] ?? '';
    
    // Filter expenses
    $filteredExpenses = [];
    $totalAmount = 0;
    foreach ($expenseArray as $expense) {
        $include = true;
        
        if ($selectedMonth && substr($expense['date'], 0, 7) != $selectedMonth) {
            $include = false;
        }
        
        if ($selectedCategory && $expense['category'] != $selectedCategory) {
            $include = false;
        }
        
        if ($include) {
            $filteredExpenses[] = $expense;
            $totalAmount += $expense['amount'];
        }
    }
    
    // Get unique categories from existing expenses
    $categories = [
        'Ink & Toner',
        'Paper',
        'Maintenance',
        'Rent',
        'Electricity',
        'Internet',
        'Salary',
        'Transportation',
        'Office Supplies',
        'Marketing',
        'Software',
        'Hardware'
    ];
    
    // Add categories from existing expenses
    foreach ($expenseArray as $expense) {
        if (!in_array($expense['category'], $categories)) {
            $categories[] = $expense['category'];
        }
    }
    sort($categories);
    
    renderHeader();
    echo '<div class="main-content">
        <h1>💰 Expenses Management</h1>';
    
    // Add/Edit Expense Form
    if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])) {
        // Edit Expense Mode
        $expenseId = $_GET['id'];
        $editExpense = isset($expenses[$expenseId]) ? $expenses[$expenseId] : null;
        
        if ($editExpense) {
            echo '<div class="card">
                    <h3>✏️ Edit Expense</h3>
                    <form method="POST">
                        <input type="hidden" name="action" value="update_expense">
                        <input type="hidden" name="expense_id" value="' . $expenseId . '">
                        
                        <div class="form-group">
                            <label>Date</label>
                            <input type="date" name="date" class="form-control" value="' . $editExpense['date'] . '" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Category</label>
                            <select name="category" id="expenseCategory" class="form-control" required onchange="toggleCustomCategory()">
                                <option value="">Select Category</option>';
            
            foreach ($categories as $category) {
                $selected = ($category == $editExpense['category']) ? 'selected' : '';
                echo '<option value="' . htmlspecialchars($category) . '" ' . $selected . '>' . htmlspecialchars($category) . '</option>';
            }
            
            $isCustomCategory = !in_array($editExpense['category'], $categories);
            
            echo '<option value="Other"' . ($isCustomCategory ? ' selected' : '') . '>Other (Enter Custom)</option>
                            </select>
                        </div>
                        
                        <div class="form-group" id="customCategoryBox" style="display:' . ($isCustomCategory ? 'block' : 'none') . ';">
                            <label>Custom Category Name</label>
                            <input type="text" name="custom_category" id="customCategory" class="form-control" placeholder="Enter new category name" value="' . ($isCustomCategory ? htmlspecialchars($editExpense['category']) : '') . '">
                        </div>
                        
                        <div class="form-group">
                            <label>Description</label>
                            <input type="text" name="description" class="form-control" required value="' . htmlspecialchars($editExpense['description']) . '" placeholder="e.g., Purchased printer ink">
                        </div>
                        
                        <div class="form-group">
                            <label>Amount (Rs:)</label>
                            <input type="number" name="amount" class="form-control" step="0.01" min="0" required value="' . $editExpense['amount'] . '">
                        </div>
                        
                        <div class="action-buttons">
                            <button type="submit" class="btn btn-primary">Update Expense</button>
                            <a href="?page=expenses" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>';
        }
    } else {
        // Add Expense Mode (Default)
        echo '<div class="card">
                <h3>➕ Add New Expense</h3>
                <form method="POST">
                    <input type="hidden" name="action" value="add_expense">
                    
                    <div class="form-group">
                        <label>Date</label>
                        <input type="date" name="date" class="form-control" value="' . date('Y-m-d') . '" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Category</label>
                        <select name="category" id="expenseCategory" class="form-control" required onchange="toggleCustomCategory()">
                            <option value="">Select Category</option>';
        
        foreach ($categories as $category) {
            echo '<option value="' . htmlspecialchars($category) . '">' . htmlspecialchars($category) . '</option>';
        }
        
        echo '<option value="Other">Other (Enter Custom)</option>
                        </select>
                    </div>
                    
                    <div class="form-group" id="customCategoryBox" style="display:none;">
                        <label>Custom Category Name</label>
                        <input type="text" name="custom_category" id="customCategory" class="form-control" placeholder="Enter new category name">
                    </div>
                    
                    <div class="form-group">
                        <label>Description</label>
                        <input type="text" name="description" class="form-control" required placeholder="e.g., Purchased printer ink">
                    </div>
                    
                    <div class="form-group">
                        <label>Amount (Rs:)</label>
                        <input type="number" name="amount" class="form-control" step="0.01" min="0" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Add Expense</button>
                </form>
            </div>';
    }
    
    // Filters
    echo '<div class="filter-form">
            <div class="filter-group">
                <label>Month</label>
                <input type="month" class="form-control" value="' . $selectedMonth . '" onchange="window.location=\'?page=expenses&month=\' + this.value">
            </div>
            <div class="filter-group">
                <label>Category</label>
                <select class="form-control" onchange="window.location=\'?page=expenses&month=' . $selectedMonth . '&category=\' + this.value">
                    <option value="">All Categories</option>';
    
    foreach ($categories as $category) {
        $selected = ($category == $selectedCategory) ? 'selected' : '';
        echo '<option value="' . htmlspecialchars($category) . '" ' . $selected . '>' . htmlspecialchars($category) . '</option>';
    }
    
    echo '</select>
            </div>
            <div class="filter-group">
                <a href="?page=expenses" class="btn btn-secondary">Clear Filters</a>
            </div>
        </div>';
    
    // Expense List Table
    echo '<div class="card">
            <h3>📋 Expense List - Total: Rs:' . number_format($totalAmount, 2) . '</h3>';
    
    if (empty($filteredExpenses)) {
        echo '<p>No expenses found for selected filters.</p>';
    } else {
        echo '<table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Amount (Rs:)</th>
                        <th>Added By</th>
                        <th>Added On</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>';
        
        usort($filteredExpenses, function($a, $b) {
            return strtotime($b['date']) - strtotime($a['date']);
        });
        
        foreach ($filteredExpenses as $expense) {
            echo '<tr>
                    <td>' . $expense['date'] . '</td>
                    <td>' . htmlspecialchars($expense['category']) . '</td>
                    <td>' . htmlspecialchars($expense['description']) . '</td>
                    <td>Rs:' . number_format($expense['amount'], 2) . '</td>
                    <td>' . htmlspecialchars($expense['added_by']) . '</td>
                    <td>' . $expense['created_at'] . '</td>
                    <td class="action-buttons">
                        <a href="?page=expenses&action=edit&id=' . $expense['id'] . '" class="btn btn-primary btn-sm">Edit</a>
                        <a href="?page=expenses&action=delete&id=' . $expense['id'] . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to delete this expense?\')">Delete</a>
                    </td>
                </tr>';
        }
        
        echo '</tbody></table>';
    }
    
    // Category Summary
    if (!empty($filteredExpenses)) {
        $categorySummary = [];
        foreach ($filteredExpenses as $expense) {
            $category = $expense['category'];
            if (!isset($categorySummary[$category])) {
                $categorySummary[$category] = 0;
            }
            $categorySummary[$category] += $expense['amount'];
        }
        
        arsort($categorySummary);
        
        echo '<div style="margin-top: 30px;">
                <h4>📊 Category-wise Summary</h4>
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-top: 15px;">';
        
        foreach ($categorySummary as $category => $amount) {
            $percentage = $totalAmount > 0 ? ($amount / $totalAmount * 100) : 0;
            $colorClass = '';
            
            if ($percentage > 30) $colorClass = 'danger';
            elseif ($percentage > 15) $colorClass = 'warning';
            else $colorClass = 'success';
            
            echo '<div style="flex: 1; min-width: 200px; background: white; padding: 15px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                    <div style="font-weight: bold; margin-bottom: 5px;">' . htmlspecialchars($category) . '</div>
                    <div style="font-size: 24px; font-weight: bold; color: #ef4444;">Rs:' . number_format($amount, 2) . '</div>
                    <div style="color: #666; font-size: 14px;">' . number_format($percentage, 1) . '% of total</div>
                  </div>';
        }
        
        echo '</div></div>';
    }
    
    echo '</div></div>';
    
    // Add JavaScript for custom category toggle
    echo '<script>
    function toggleCustomCategory() {
        const categorySelect = document.getElementById("expenseCategory");
        const customCategoryBox = document.getElementById("customCategoryBox");
        const customCategoryInput = document.getElementById("customCategory");
        
        if (categorySelect.value === "Other") {
            customCategoryBox.style.display = "block";
            if (customCategoryInput) {
                customCategoryInput.required = true;
            }
        } else {
            customCategoryBox.style.display = "none";
            if (customCategoryInput) {
                customCategoryInput.required = false;
            }
        }
    }
    </script>';
    
    renderFooter();
}
// function renderExpensesPage() {
//     requireRole('manager');
    
//     if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
//         if ($_POST['action'] == 'add_expense') {
//             $expenses = getJsonData(EXPENSES_FILE);
//             $expenseId = time() . rand(100, 999);
            
//             $expenses[$expenseId] = [
//                 'id' => $expenseId,
//                 'category' => $_POST['category'],
//                 'description' => $_POST['description'],
//                 'amount' => $_POST['amount'],
//                 'date' => $_POST['date'],
//                 'added_by' => $_SESSION['username'],
//                 'created_at' => date('Y-m-d H:i:s')
//             ];
            
//             saveJsonData(EXPENSES_FILE, $expenses);
//             logAction('expense_added', "Added expense: " . $_POST['description'] . " - Rs:" . $_POST['amount']);
//             echo '<div class="alert alert-success">Expense added successfully!</div>';
//         }
//     }
    
//     $expenses = getJsonData(EXPENSES_FILE);
//     $expenseArray = array_values($expenses);
    
//     // Get month filter
//     $selectedMonth = $_GET['month'] ?? date('Y-m');
//     $selectedCategory = $_GET['category'] ?? '';
    
//     // Filter expenses
//     $filteredExpenses = [];
//     $totalAmount = 0;
//     foreach ($expenseArray as $expense) {
//         $include = true;
        
//         if ($selectedMonth && substr($expense['date'], 0, 7) != $selectedMonth) {
//             $include = false;
//         }
        
//         if ($selectedCategory && $expense['category'] != $selectedCategory) {
//             $include = false;
//         }
        
//         if ($include) {
//             $filteredExpenses[] = $expense;
//             $totalAmount += $expense['amount'];
//         }
//     }
    
//     // Get unique categories for filter
//     $categories = [];
//     foreach ($expenseArray as $expense) {
//         if (!in_array($expense['category'], $categories)) {
//             $categories[] = $expense['category'];
//         }
//     }
    
//     renderHeader();
//     echo '<div class="main-content">
//         <h1>💰 Expenses Management</h1>
        
//         <div class="card">
//             <h3>Add New Expense</h3>
//             <form method="POST">
//                 <input type="hidden" name="action" value="add_expense">
                
//                 <div class="form-group">
//                     <label>Date</label>
//                     <input type="date" name="date" class="form-control" value="' . date('Y-m-d') . '" required>
//                 </div>
                
//                 <div class="form-group">
//                     <label>Category</label>
//                     <select name="category" class="form-control" required>
//                         <option value="">Select Category</option>
//                         <option value="Ink & Toner">Ink & Toner</option>
//                         <option value="Paper">Paper</option>
//                         <option value="Maintenance">Maintenance</option>
//                         <option value="Rent">Rent</option>
//                         <option value="Electricity">Electricity</option>
//                         <option value="Internet">Internet</option>
//                         <option value="Salary">Salary</option>
//                         <option value="Other">Other</option>
//                     </select>
//                 </div>
                
//                 <div class="form-group">
//                     <label>Description</label>
//                     <input type="text" name="description" class="form-control" required placeholder="e.g., Purchased printer ink">
//                 </div>
                
//                 <div class="form-group">
//                     <label>Amount (Rs:)</label>
//                     <input type="number" name="amount" class="form-control" step="0.01" min="0" required>
//                 </div>
                
//                 <button type="submit" class="btn btn-primary">Add Expense</button>
//             </form>
//         </div>
        
//         <div class="filter-form">
//             <div class="filter-group">
//                 <label>Month</label>
//                 <input type="month" class="form-control" value="' . $selectedMonth . '" onchange="window.location=\'?page=expenses&month=\' + this.value">
//             </div>
//             <div class="filter-group">
//                 <label>Category</label>
//                 <select class="form-control" onchange="window.location=\'?page=expenses&month=' . $selectedMonth . '&category=\' + this.value">
//                     <option value="">All Categories</option>';
    
//     foreach ($categories as $category) {
//         $selected = ($category == $selectedCategory) ? 'selected' : '';
//         echo '<option value="' . $category . '" ' . $selected . '>' . $category . '</option>';
//     }
    
//     echo '</select>
//             </div>
//             <div class="filter-group">
//                 <a href="?page=expenses" class="btn btn-secondary">Clear Filters</a>
//             </div>
//         </div>
        
//         <div class="card">
//             <h3>Expense List - Total: Rs:' . number_format($totalAmount, 2) . '</h3>';
    
//     if (empty($filteredExpenses)) {
//         echo '<p>No expenses found for selected filters.</p>';
//     } else {
//         echo '<table>
//                 <thead>
//                     <tr>
//                         <th>Date</th>
//                         <th>Category</th>
//                         <th>Description</th>
//                         <th>Amount</th>
//                         <th>Added By</th>
//                         <th>Added On</th>
//                     </tr>
//                 </thead>
//                 <tbody>';
        
//         usort($filteredExpenses, function($a, $b) {
//             return strtotime($b['date']) - strtotime($a['date']);
//         });
        
//         foreach ($filteredExpenses as $expense) {
//             echo '<tr>
//                     <td>' . $expense['date'] . '</td>
//                     <td>' . htmlspecialchars($expense['category']) . '</td>
//                     <td>' . htmlspecialchars($expense['description']) . '</td>
//                     <td>Rs:' . number_format($expense['amount'], 2) . '</td>
//                     <td>' . htmlspecialchars($expense['added_by']) . '</td>
//                     <td>' . $expense['created_at'] . '</td>
//                 </tr>';
//         }
        
//         echo '</tbody></table>';
//     }
    
//     echo '</div></div>';
//     renderFooter();
// }

function renderReportsPage() {
    requireRole('boss');
    
    $works = getJsonData(WORK_FILE);
    $expenses = getJsonData(EXPENSES_FILE);
    $users = getJsonData(USERS_FILE);
    
    // Get date range
    $startDate = $_GET['start_date'] ?? date('Y-m-01');
    $endDate = $_GET['end_date'] ?? date('Y-m-d');
    $userId = $_GET['user_id'] ?? '';
    $reportType = $_GET['report_type'] ?? 'sales';
    
    // Prepare data
    $reportData = [];
    $totalRevenue = 0;
    $totalExpenses = 0;
    
    // Filter works
    foreach ($works as $work) {
        if ($work['status'] == 'verified' && 
            $work['date'] >= $startDate && 
            $work['date'] <= $endDate &&
            ($userId == '' || $work['user_id'] == $userId)) {
            
            $reportData[] = $work;
            $totalRevenue += $work['total_amount'];
        }
    }
    
    // Calculate expenses
    $expenseArray = array_values($expenses);
    foreach ($expenseArray as $expense) {
        if ($expense['date'] >= $startDate && $expense['date'] <= $endDate) {
            $totalExpenses += $expense['amount'];
        }
    }
    
    // Group by product for product-wise report
    $productSales = [];
    foreach ($reportData as $work) {
        $productName = $work['product_name'];
        if (!isset($productSales[$productName])) {
            $productSales[$productName] = [
                'quantity' => 0,
                'amount' => 0
            ];
        }
        $productSales[$productName]['quantity'] += $work['quantity'];
        $productSales[$productName]['amount'] += $work['total_amount'];
    }
    
    // Group by user for user-wise report
    $userSales = [];
    foreach ($reportData as $work) {
        $userName = $work['username'];
        if (!isset($userSales[$userName])) {
            $userSales[$userName] = [
                'count' => 0,
                'amount' => 0
            ];
        }
        $userSales[$userName]['count']++;
        $userSales[$userName]['amount'] += $work['total_amount'];
    }
    
    renderHeader();
    echo '<div class="main-content">
        <h1>📈 Reports</h1>
        
        <div class="filter-form">
            <div class="filter-group">
                <label>Report Type</label>
                <select class="form-control" onchange="window.location=\'?page=reports&report_type=\' + this.value + \'&start_date=' . $startDate . '&end_date=' . $endDate . '\'">
                    <option value="sales" ' . ($reportType == 'sales' ? 'selected' : '') . '>Sales Report</option>
                    <option value="product" ' . ($reportType == 'product' ? 'selected' : '') . '>Product-wise</option>
                    <option value="user" ' . ($reportType == 'user' ? 'selected' : '') . '>User-wise</option>
                    <option value="financial" ' . ($reportType == 'financial' ? 'selected' : '') . '>Financial Summary</option>
                </select>
            </div>
            <div class="filter-group">
                <label>Start Date</label>
                <input type="date" class="form-control" value="' . $startDate . '" onchange="updateDateRange()" id="startDate">
            </div>
            <div class="filter-group">
                <label>End Date</label>
                <input type="date" class="form-control" value="' . $endDate . '" onchange="updateDateRange()" id="endDate">
            </div>
            <div class="filter-group">
                <label>User</label>
                <select class="form-control" onchange="window.location=\'?page=reports&report_type=' . $reportType . '&start_date=' . $startDate . '&end_date=' . $endDate . '&user_id=\' + this.value">
                    <option value="">All Users</option>';
    
    foreach ($users as $user) {
        $selected = ($user['id'] == $userId) ? 'selected' : '';
        echo '<option value="' . $user['id'] . '" ' . $selected . '>' . htmlspecialchars($user['full_name']) . '</option>';
    }
    
    echo '</select>
            </div>
        </div>
        
        <div class="dashboard-grid">
            <div class="stat-card">
                <div class="stat-label">Total Revenue</div>
                <div class="stat-value" style="color: #10b981;">Rs:' . number_format($totalRevenue, 2) . '</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Total Expenses</div>
                <div class="stat-value" style="color: #ef4444;">Rs:' . number_format($totalExpenses, 2) . '</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Net Profit</div>
                <div class="stat-value" style="color: #3b82f6;">Rs:' . number_format($totalRevenue - $totalExpenses, 2) . '</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Total Jobs</div>
                <div class="stat-value">' . count($reportData) . '</div>
            </div>
        </div>';
    
    // Display report based on type
    switch ($reportType) {
        case 'sales':
            echo '<div class="card">
                    <h3>Sales Report (' . date('d/m/Y', strtotime($startDate)) . ' to ' . date('d/m/Y', strtotime($endDate)) . ')</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Customer</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Amount</th>
                                <th>Employee</th>
                            </tr>
                        </thead>
                        <tbody>';
            
            if (empty($reportData)) {
                echo '<tr><td colspan="6" style="text-align: center;">No sales data found for selected period.</td></tr>';
            } else {
                usort($reportData, function($a, $b) {
                    return strtotime($b['date']) - strtotime($a['date']);
                });
                
                foreach ($reportData as $work) {
                    echo '<tr>
                            <td>' . $work['date'] . '</td>
                            <td>' . htmlspecialchars($work['customer_name']) . '</td>
                            <td>' . htmlspecialchars($work['product_name']) . '</td>
                            <td>' . $work['quantity'] . '</td>
                            <td>Rs:' . number_format($work['total_amount'], 2) . '</td>
                            <td>' . htmlspecialchars($work['username']) . '</td>
                        </tr>';
                }
            }
            
            echo '</tbody></table></div>';
            break;
            
        case 'product':
            echo '<div class="card">
                    <h3>Product-wise Sales Report</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Total Quantity</th>
                                <th>Total Amount</th>
                                <th>Percentage</th>
                            </tr>
                        </thead>
                        <tbody>';
            
            if (empty($productSales)) {
                echo '<tr><td colspan="4" style="text-align: center;">No product sales data found.</td></tr>';
            } else {
                arsort($productSales);
                foreach ($productSales as $product => $data) {
                    $percentage = $totalRevenue > 0 ? ($data['amount'] / $totalRevenue * 100) : 0;
                    echo '<tr>
                            <td>' . htmlspecialchars($product) . '</td>
                            <td>' . $data['quantity'] . '</td>
                            <td>Rs:' . number_format($data['amount'], 2) . '</td>
                            <td>' . number_format($percentage, 1) . '%</td>
                        </tr>';
                }
            }
            
            echo '</tbody></table></div>';
            break;
            
        case 'user':
            echo '<div class="card">
                    <h3>User-wise Performance Report</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>Employee</th>
                                <th>Total Jobs</th>
                                <th>Total Revenue</th>
                                <th>Average per Job</th>
                            </tr>
                        </thead>
                        <tbody>';
            
            if (empty($userSales)) {
                echo '<tr><td colspan="4" style="text-align: center;">No user performance data found.</td></tr>';
            } else {
                arsort($userSales);
                foreach ($userSales as $user => $data) {
                    $average = $data['count'] > 0 ? $data['amount'] / $data['count'] : 0;
                    echo '<tr>
                            <td>' . htmlspecialchars($user) . '</td>
                            <td>' . $data['count'] . '</td>
                            <td>Rs:' . number_format($data['amount'], 2) . '</td>
                            <td>Rs:' . number_format($average, 2) . '</td>
                        </tr>';
                }
            }
            
            echo '</tbody></table></div>';
            break;
            
        case 'financial':
            echo '<div class="card">
                    <h3>Financial Summary Report</h3>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                        <div>
                            <h4>Revenue Breakdown</h4>
                            <table>
                                <tr><td>Total Revenue:</td><td style="text-align: right;">Rs:' . number_format($totalRevenue, 2) . '</td></tr>
                                <tr><td>Total Expenses:</td><td style="text-align: right;">Rs:' . number_format($totalExpenses, 2) . '</td></tr>
                                <tr style="font-weight: bold; border-top: 2px solid #ddd;">
                                    <td>Net Profit:</td>
                                    <td style="text-align: right; color: ' . (($totalRevenue - $totalExpenses) >= 0 ? '#10b981' : '#ef4444') . ';">
                                        Rs:' . number_format($totalRevenue - $totalExpenses, 2) . '
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div>
                            <h4>Profit Margin</h4>';
            
            if ($totalRevenue > 0) {
                $profitMargin = (($totalRevenue - $totalExpenses) / $totalRevenue) * 100;
                echo '<div style="text-align: center;">
                        <div style="font-size: 48px; font-weight: bold; color: ' . ($profitMargin >= 0 ? '#10b981' : '#ef4444') . ';">
                            ' . number_format($profitMargin, 1) . '%
                        </div>
                        <div style="color: #666;">Profit Margin</div>
                    </div>';
            }
            
            echo '</div></div></div>';
            break;
    }
    
    echo '<script>
        function updateDateRange() {
            const start = document.getElementById("startDate").value;
            const end = document.getElementById("endDate").value;
            window.location = "?page=reports&report_type=' . $reportType . '&start_date=" + start + "&end_date=" + end + "&user_id=' . $userId . '";
        }
    </script>';
    
    echo '</div>';
    renderFooter();
}
function renderUsersPage() {
    requireRole('manager');
    
    // Handle actions
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
        
        if ($_POST['action'] == 'reset_password') {
            $users = getJsonData(USERS_FILE);
            $username = $_POST['username'];
            
            if (isset($users[$username])) {
                $newPassword = $_POST['new_password'];
                $confirmPassword = $_POST['confirm_password'];
                
                if ($newPassword !== $confirmPassword) {
                    echo '<div class="alert alert-danger">Passwords do not match!</div>';
                } elseif (strlen($newPassword) < 6) {
                    echo '<div class="alert alert-danger">Password must be at least 6 characters long!</div>';
                } else {
                    $users[$username]['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
                    $users[$username]['password_reset_at'] = date('Y-m-d H:i:s');
                    $users[$username]['password_reset_by'] = $_SESSION['username'];
                    
                    saveJsonData(USERS_FILE, $users);
                    logAction('password_reset', "Reset password for user: $username");
                    echo '<div class="alert alert-success">Password reset successfully!</div>';
                }
            } else {
                echo '<div class="alert alert-danger">User not found!</div>';
            }
        }
        
        if ($_POST['action'] == 'update_user') {
            $users = getJsonData(USERS_FILE);
            $username = $_POST['username'];
            
            if (isset($users[$username])) {
                // Fix: Check if is_active is set in POST
                $isActive = isset($_POST['is_active']) && $_POST['is_active'] == '1';
                
                $users[$username]['full_name'] = $_POST['full_name'];
                $users[$username]['role'] = $_POST['role'];
                $users[$username]['is_active'] = $isActive;  // Fixed this line
                $users[$username]['updated_at'] = date('Y-m-d H:i:s');
                $users[$username]['updated_by'] = $_SESSION['username'];
                
                saveJsonData(USERS_FILE, $users);
                logAction('user_updated', "Updated user: $username");
                echo '<div class="alert alert-success">User updated successfully!</div>';
            }
        }
    }
    
    // Handle delete action
    if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['username'])) {
        $users = getJsonData(USERS_FILE);
        $username = $_GET['username'];
        
        if (isset($users[$username]) && $username != $_SESSION['username']) {
            $deletedUser = $users[$username];
            unset($users[$username]);
            saveJsonData(USERS_FILE, $users);
            
            logAction('user_deleted', "Deleted user: $username");
            echo '<div class="alert alert-success">User deleted successfully!</div>';
        } elseif ($username == $_SESSION['username']) {
            echo '<div class="alert alert-danger">You cannot delete your own account!</div>';
        }
    }
    
    $users = getJsonData(USERS_FILE);
    
    renderHeader();
    echo '<div class="main-content">
        <h1>👥 User Management</h1>';
    
    // Check if we're in edit mode or add mode
    if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['username'])) {
        // Edit User Mode
        $username = $_GET['username'];
        $editUser = isset($users[$username]) ? $users[$username] : null;
        
        if ($editUser) {
            echo '<div class="card">
                    <h3>✏️ Edit User</h3>
                    <form method="POST" onsubmit="return validateUserForm(this)">
                        <input type="hidden" name="action" value="update_user">
                        <input type="hidden" name="username" value="' . $username . '">
                        
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" class="form-control" value="' . htmlspecialchars($editUser['username']) . '" readonly>
                            <small class="text-muted">Username cannot be changed</small>
                        </div>
                        
                        <div class="form-group">
                            <label>Full Name *</label>
                            <input type="text" name="full_name" class="form-control" value="' . htmlspecialchars($editUser['full_name']) . '" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Role *</label>
                            <select name="role" class="form-control" required>';
            
            // Role options - restrict managers from creating boss accounts
            $roleOptions = [
                'user' => 'User (Employee)',
                'manager' => 'Manager'
            ];
            
            // Only boss can create/edit boss accounts
            if ($_SESSION['role'] == 'boss') {
                $roleOptions['boss'] = 'Boss (Admin)';
            }
            
            foreach ($roleOptions as $roleValue => $roleLabel) {
                $selected = ($editUser['role'] == $roleValue) ? 'selected' : '';
                echo '<option value="' . $roleValue . '" ' . $selected . '>' . $roleLabel . '</option>';
            }
            
            echo '</select>
                        </div>
                        
                        <div class="form-group">
                            <label>Account Status</label><br>
                            <div style="display: flex; gap: 20px; margin-top: 10px;">
                                <label style="display: flex; align-items: center; gap: 8px;">
                                    <input type="radio" name="is_active" value="1" ' . ($editUser['is_active'] ? 'checked' : '') . '>
                                    <span class="status-badge status-verified">Active</span>
                                </label>
                                <label style="display: flex; align-items: center; gap: 8px;">
                                    <input type="radio" name="is_active" value="0" ' . (!$editUser['is_active'] ? 'checked' : '') . '>
                                    <span class="status-badge status-rejected">Inactive</span>
                                </label>
                            </div>
                            <small class="text-muted">Inactive users cannot login to the system</small>
                        </div>
                        
                        <div class="action-buttons">
                            <button type="submit" class="btn btn-primary">Update User</button>
                            <a href="?page=users" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>';
        }
    } elseif (isset($_GET['action']) && $_GET['action'] == 'reset_password' && isset($_GET['username'])) {
        // Reset Password Mode
        $username = $_GET['username'];
        $user = isset($users[$username]) ? $users[$username] : null;
        
        if ($user) {
            echo '<div class="card">
                    <h3>🔑 Reset Password</h3>
                    <form method="POST" onsubmit="return validatePasswordReset(this)">
                        <input type="hidden" name="action" value="reset_password">
                        <input type="hidden" name="username" value="' . $username . '">
                        
                        <div class="form-group">
                            <label>User</label>
                            <div class="form-control" style="background-color: #f8f9fa;">
                                <strong>' . htmlspecialchars($user['full_name']) . '</strong> (' . htmlspecialchars($user['username']) . ')
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>New Password *</label>
                            <input type="password" name="new_password" id="newPassword" class="form-control" required 
                                   placeholder="Enter new password (min. 6 characters)"
                                   oninput="checkPasswordStrength(this.value)">
                            <small class="text-muted" id="passwordStrength"></small>
                        </div>
                        
                        <div class="form-group">
                            <label>Confirm New Password *</label>
                            <input type="password" name="confirm_password" id="confirmPassword" class="form-control" required 
                                   placeholder="Confirm new password"
                                   oninput="checkPasswordMatch()">
                            <small class="text-muted" id="passwordMatch"></small>
                        </div>
                        
                        <div class="alert alert-info">
                            <strong>Note:</strong> The user will need to use this new password to login.
                        </div>
                        
                        <div class="action-buttons">
                            <button type="submit" class="btn btn-warning">Reset Password</button>
                            <a href="?page=users" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>';
        }
    } else {
        // Add User Mode (Default)
        echo '<div class="card">
                <h3>➕ Add New User</h3>
                <form method="POST" onsubmit="return validateNewUserForm(this)">
                    <input type="hidden" name="action" value="add_user">
                    
                    <div class="form-group">
                        <label>Full Name *</label>
                        <input type="text" name="full_name" class="form-control" required placeholder="Enter full name">
                    </div>
                    
                    <div class="form-group">
                        <label>Username *</label>
                        <input type="text" name="username" class="form-control" required 
                               placeholder="Enter username (for login)"
                               oninput="checkUsernameAvailability(this.value)">
                        <small class="text-muted" id="usernameAvailability">Username cannot be changed later</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Initial Password *</label>
                        <input type="password" name="password" class="form-control" required 
                               placeholder="Enter initial password (min. 6 characters)">
                    </div>
                    
                    <div class="form-group">
                        <label>Role *</label>
                        <select name="role" class="form-control" required>';
        
        // Role options - restrict managers from creating boss accounts
        $roleOptions = [
            'user' => 'User (Employee)',
            'manager' => 'Manager'
        ];
        
        // Only boss can create boss accounts
        if ($_SESSION['role'] == 'boss') {
            $roleOptions['boss'] = 'Boss (Admin)';
        }
        
        foreach ($roleOptions as $roleValue => $roleLabel) {
            echo '<option value="' . $roleValue . '">' . $roleLabel . '</option>';
        }
        
        echo '</select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Add User</button>
                </form>
            </div>';
    }
    
    // User List Table
    echo '<div class="card">
            <h3>📋 User List</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Full Name</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Last Login</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>';
    
    foreach ($users as $user) {
        $lastLogin = 'Never';
        $logs = getJsonData(LOGS_FILE);
        foreach (array_reverse($logs) as $log) {
            if ($log['username'] == $user['username'] && $log['action'] == 'login') {
                $lastLogin = date('M d, h:i A', strtotime($log['timestamp']));
                break;
            }
        }
        
        // Don't allow editing/deleting own account (except for boss)
        $canEdit = true;
        $canDelete = ($user['username'] != $_SESSION['username']);
        $canResetPassword = ($user['username'] != $_SESSION['username'] || $_SESSION['role'] == 'boss');
        
        echo '<tr>
                <td>' . $user['id'] . '</td>
                <td>' . htmlspecialchars($user['username']) . '</td>
                <td>' . htmlspecialchars($user['full_name']) . '</td>
                <td><span class="role-badge role-' . $user['role'] . '">' . ucfirst($user['role']) . '</span></td>
                <td>' . 
                    ($user['is_active'] ? 
                        '<span class="status-badge status-verified">Active</span>' : 
                        '<span class="status-badge status-rejected">Inactive</span>'
                    ) . 
                '</td>
                <td>' . date('M d, Y', strtotime($user['created_at'])) . '</td>
                <td>' . $lastLogin . '</td>
                <td class="action-buttons">';
        
        if ($canEdit) {
            echo '<a href="?page=users&action=edit&username=' . $user['username'] . '" class="btn btn-primary btn-sm">Edit</a> ';
        }
        
        if ($canResetPassword) {
            echo '<a href="?page=users&action=reset_password&username=' . $user['username'] . '" class="btn btn-warning btn-sm">Reset Password</a> ';
        }
        
        if ($canDelete && $_SESSION['role'] == 'boss') {
            echo '<a href="?page=users&action=delete&username=' . $user['username'] . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to delete user: ' . htmlspecialchars($user['full_name']) . '?\n\nThis action cannot be undone!\')">Delete</a>';
        }
        
        echo '</td>
            </tr>';
    }
    
    echo '</tbody></table></div>';
    
    // User Statistics
    $userStats = [
        'total' => count($users),
        'active' => 0,
        'inactive' => 0,
        'by_role' => ['boss' => 0, 'manager' => 0, 'user' => 0]
    ];
    
    foreach ($users as $user) {
        if ($user['is_active']) $userStats['active']++;
        else $userStats['inactive']++;
        
        $userStats['by_role'][$user['role']]++;
    }
    
    echo '<div class="dashboard-grid" style="margin-top: 20px;">
            <div class="stat-card">
                <div class="stat-label">Total Users</div>
                <div class="stat-value">' . $userStats['total'] . '</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Active Users</div>
                <div class="stat-value" style="color: #10b981;">' . $userStats['active'] . '</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Inactive Users</div>
                <div class="stat-value" style="color: #ef4444;">' . $userStats['inactive'] . '</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Admins (Boss)</div>
                <div class="stat-value" style="color: #dc2626;">' . $userStats['by_role']['boss'] . '</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Managers</div>
                <div class="stat-value" style="color: #f59e0b;">' . $userStats['by_role']['manager'] . '</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Users (Employees)</div>
                <div class="stat-value" style="color: #3b82f6;">' . $userStats['by_role']['user'] . '</div>
            </div>
        </div>';
    
    echo '</div>';
    
    // Add JavaScript for form validation
    echo '<script>
    function validatePasswordReset(form) {
        const newPassword = form.new_password.value;
        const confirmPassword = form.confirm_password.value;
        
        if (newPassword !== confirmPassword) {
            alert("Passwords do not match!");
            return false;
        }
        
        if (newPassword.length < 6) {
            alert("Password must be at least 6 characters long!");
            return false;
        }
        
        return confirm("Are you sure you want to reset the password for this user?");
    }
    
    function validateUserForm(form) {
        return confirm("Are you sure you want to update this user?");
    }
    
    function validateNewUserForm(form) {
        if (form.password.value.length < 6) {
            alert("Password must be at least 6 characters long!");
            return false;
        }
        return confirm("Are you sure you want to add this new user?");
    }
    
    function checkPasswordStrength(password) {
        const strengthText = document.getElementById("passwordStrength");
        if (password.length === 0) {
            strengthText.textContent = "";
            strengthText.style.color = "#666";
        } else if (password.length < 6) {
            strengthText.textContent = "Weak (min. 6 characters)";
            strengthText.style.color = "#ef4444";
        } else if (password.length < 8) {
            strengthText.textContent = "Moderate";
            strengthText.style.color = "#f59e0b";
        } else {
            strengthText.textContent = "Strong";
            strengthText.style.color = "#10b981";
        }
    }
    
    function checkPasswordMatch() {
        const password = document.getElementById("newPassword").value;
        const confirm = document.getElementById("confirmPassword").value;
        const matchText = document.getElementById("passwordMatch");
        
        if (confirm.length === 0) {
            matchText.textContent = "";
        } else if (password === confirm) {
            matchText.textContent = "✓ Passwords match";
            matchText.style.color = "#10b981";
        } else {
            matchText.textContent = "✗ Passwords do not match";
            matchText.style.color = "#ef4444";
        }
    }
    
    function checkUsernameAvailability(username) {
        // This would require AJAX to check against existing users
        // For now, just clear the field
        const availabilityText = document.getElementById("usernameAvailability");
        if (username.length > 0) {
            availabilityText.textContent = "Checking availability...";
            availabilityText.style.color = "#f59e0b";
        } else {
            availabilityText.textContent = "Username cannot be changed later";
            availabilityText.style.color = "#666";
        }
    }
    </script>';
    
    renderFooter();
}
// function renderUsersPage() {
//     requireRole('boss');
    
//     if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
//         if ($_POST['action'] == 'add_user') {
//             $users = getJsonData(USERS_FILE);
//             $username = $_POST['username'];
            
//             if (!isset($users[$username])) {
//                 $userId = count($users) + 1;
//                 $users[$username] = [
//                     'id' => $userId,
//                     'username' => $username,
//                     'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
//                     'full_name' => $_POST['full_name'],
//                     'role' => $_POST['role'],
//                     'created_at' => date('Y-m-d H:i:s'),
//                     'is_active' => true
//                 ];
                
//                 saveJsonData(USERS_FILE, $users);
//                 logAction('user_added', "Added user: $username");
//                 echo '<div class="alert alert-success">User added successfully!</div>';
//             } else {
//                 echo '<div class="alert alert-danger">Username already exists!</div>';
//             }
//         }
//     }
    
//     $users = getJsonData(USERS_FILE);
    
//     renderHeader();
//     echo '<div class="main-content">
//         <h1>👥 User Management</h1>
        
//         <div class="card">
//             <h3>Add New User</h3>
//             <form method="POST">
//                 <input type="hidden" name="action" value="add_user">
                
//                 <div class="form-group">
//                     <label>Full Name</label>
//                     <input type="text" name="full_name" class="form-control" required placeholder="Enter full name">
//                 </div>
                
//                 <div class="form-group">
//                     <label>Username</label>
//                     <input type="text" name="username" class="form-control" required placeholder="Enter username">
//                 </div>
                
//                 <div class="form-group">
//                     <label>Password</label>
//                     <input type="password" name="password" class="form-control" required placeholder="Enter password">
//                 </div>
                
//                 <div class="form-group">
//                     <label>Role</label>
//                     <select name="role" class="form-control" required>
//                         <option value="user">User (Employee)</option>
//                         <option value="manager">Manager</option>
//                         <option value="boss">Boss (Admin)</option>
//                     </select>
//                 </div>
                
//                 <button type="submit" class="btn btn-primary">Add User</button>
//             </form>
//         </div>
        
//         <div class="card">
//             <h3>User List</h3>
//             <table>
//                 <thead>
//                     <tr>
//                         <th>ID</th>
//                         <th>Username</th>
//                         <th>Full Name</th>
//                         <th>Role</th>
//                         <th>Created</th>
//                         <th>Status</th>
//                     </tr>
//                 </thead>
//                 <tbody>';
    
//     foreach ($users as $user) {
//         echo '<tr>
//                 <td>' . $user['id'] . '</td>
//                 <td>' . htmlspecialchars($user['username']) . '</td>
//                 <td>' . htmlspecialchars($user['full_name']) . '</td>
//                 <td><span class="role-badge role-' . $user['role'] . '">' . ucfirst($user['role']) . '</span></td>
//                 <td>' . $user['created_at'] . '</td>
//                 <td>' . ($user['is_active'] ? '<span style="color: #10b981;">Active</span>' : '<span style="color: #ef4444;">Inactive</span>') . '</td>
//             </tr>';
//     }
    
//     echo '</tbody></table></div></div>';
//     renderFooter();
// }

function renderBackupPage() {
    requireRole('boss');
    
    if (isset($_GET['action'])) {
        if ($_GET['action'] == 'backup') {
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
        
        if ($_GET['action'] == 'delete' && isset($_GET['file'])) {
            $file = BACKUP_DIR . $_GET['file'];
            if (file_exists($file) && unlink($file)) {
                logAction('backup_deleted', "Deleted backup: " . $_GET['file']);
                echo '<div class="alert alert-success">Backup deleted successfully!</div>';
            }
        }
    }
    
    $backups = glob(BACKUP_DIR . '*.json');
    
    renderHeader();
    echo '<div class="main-content">
        <h1>💾 Backup & Restore</h1>
        
        <div class="card">
            <h3>Create Backup</h3>
            <p>Create a complete backup of all system data (JSON format)</p>
            <a href="?page=backup&action=backup" class="btn btn-primary" onclick="return confirm(\'Create backup now?\')">Create Backup Now</a>
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
                    <td class="action-buttons">
                        <a href="' . $backup . '" download class="btn btn-primary btn-sm">Download</a>
                        <a href="?page=backup&action=delete&file=' . $filename . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Delete this backup?\')">Delete</a>
                    </td>
                </tr>';
        }
        
        echo '</tbody></table>';
    }
    
    echo '</div></div>';
    renderFooter();
}

function renderPrintBillPage() {
    requireLogin();
    
    $workId = $_GET['id'] ?? '';
    $works = getJsonData(WORK_FILE);
    
    if (!isset($works[$workId]) || $works[$workId]['status'] != 'verified') {
        header('Location: ?page=dashboard');
        exit();
    }
    
    $work = $works[$workId];
    
    echo '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Bill - ' . $work['bill_id'] . '</title>
        <style>
            body { font-family: Arial, sans-serif; margin: 0; padding: 20px; }
            .invoice-box {
                max-width: 800px;
                margin: 0 auto;
                padding: 30px;
                border: 1px solid #eee;
                box-shadow: 0 0 10px rgba(0, 0, 0, .15);
            }
            .invoice-header {
                display: flex;
                justify-content: space-between;
                border-bottom: 2px solid #333;
                padding-bottom: 20px;
                margin-bottom: 30px;
            }
            .company-info h1 { margin: 0; color: #333; }
            .invoice-info { text-align: right; }
            .bill-id { font-size: 24px; font-weight: bold; color: #667eea; }
            .bill-date { color: #666; }
            .section { margin: 30px 0; }
            .section-title { border-bottom: 1px solid #ddd; padding-bottom: 10px; margin-bottom: 20px; color: #333; }
            table { width: 100%; border-collapse: collapse; }
            th { background: #f5f5f5; padding: 12px; text-align: left; border-bottom: 2px solid #ddd; }
            td { padding: 12px; border-bottom: 1px solid #ddd; }
            .total-row { font-weight: bold; font-size: 16px; background: #f9f9f9; }
            .footer {
                margin-top: 50px;
                padding-top: 20px;
                border-top: 1px solid #ddd;
                text-align: center;
                color: #666;
                font-size: 14px;
            }
            @media print {
                body { padding: 0; }
                .no-print { display: none; }
                .invoice-box { box-shadow: none; border: none; }
            }
        </style>
    </head>
    <body>
        <div class="invoice-box">
            <div class="invoice-header">
                <div class="company-info">
                    <h1>PRINT SHOP</h1>
                    <p>123 Business Street</p>
                    <p>City, State 12345</p>
                    <p>Phone: (123) 456-7890</p>
                    <p>Email: info@printshop.com</p>
                </div>
                <div class="invoice-info">
                    <div class="bill-id">' . $work['bill_id'] . '</div>
                    <div class="bill-date">Date: ' . $work['date'] . '</div>
                    <div>Bill Type: Invoice</div>
                </div>
            </div>
            
            <div class="section">
                <div class="section-title">Bill To</div>
                <p><strong>' . htmlspecialchars($work['customer_name']) . '</strong></p>
            </div>
            
            <div class="section">
                <div class="section-title">Items</div>
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Description</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>' . htmlspecialchars($work['product_name']) . '</td>
                            <td>' . $work['quantity'] . '</td>
                            <td>Rs:' . number_format($work['unit_price'], 2) . '</td>
                            <td>Rs:' . number_format($work['total_amount'], 2) . '</td>
                        </tr>
                        <tr class="total-row">
                            <td colspan="4" style="text-align: right;">Total Amount:</td>
                            <td>Rs:' . number_format($work['total_amount'], 2) . '</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="section">
                <div class="section-title">Payment Information</div>
                <p>Amount in Words: ' . convertNumberToWords($work['total_amount']) . ' Rupees Only</p>
                <p>Payment Status: <strong>Pending</strong></p>
            </div>
            
            <div class="section">
                <div class="section-title">Terms & Conditions</div>
                <p>1. Payment due within 15 days</p>
                <p>2. Late payment interest @ 1.5% per month</p>
                <p>3. Goods once sold will not be taken back</p>
            </div>
            
            <div class="footer">
                <p>Thank you for your business!</p>
                <p>For any queries, contact: support@printshop.com</p>
                <p>Verified by: ' . htmlspecialchars($work['verified_by']) . ' on ' . $work['verified_at'] . '</p>
            </div>
            
            <div class="no-print" style="margin-top: 30px; text-align: center;">
                <button onclick="window.print()" class="btn btn-primary">Print Bill</button>
                <button onclick="window.close()" class="btn btn-secondary">Close</button>
            </div>
        </div>
    </body>
    </html>';
}

function convertNumberToWords($number) {
    // Simple number to words converter (basic)
    $ones = array("", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine");
    $tens = array("", "", "Twenty", "Thirty", "Forty", "Fifty", "Sixty", "Seventy", "Eighty", "Ninety");
    $teens = array("Ten", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eighteen", "Nineteen");
    
    $whole = floor($number);
    $fraction = round(($number - $whole) * 100);
    
    $words = "";
    
    if ($whole == 0) {
        $words = "Zero";
    } else {
        // Handle thousands
        if ($whole >= 1000) {
            $thousands = floor($whole / 1000);
            $words .= convertNumberToWords($thousands) . " Thousand ";
            $whole %= 1000;
        }
        
        // Handle hundreds
        if ($whole >= 100) {
            $hundreds = floor($whole / 100);
            $words .= $ones[$hundreds] . " Hundred ";
            $whole %= 100;
        }
        
        // Handle tens and ones
        if ($whole > 0) {
            if ($whole < 10) {
                $words .= $ones[$whole];
            } elseif ($whole < 20) {
                $words .= $teens[$whole - 10];
            } else {
                $words .= $tens[floor($whole / 10)];
                if ($whole % 10 > 0) {
                    $words .= " " . $ones[$whole % 10];
                }
            }
        }
    }
    
    // Handle fraction
    if ($fraction > 0) {
        $words .= " and " . $fraction . "/100";
    }
    
    return $words;
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
            
        case 'reject_work':
            requireRole('manager');
            if (isset($_POST['work_id']) && isset($_POST['reason'])) {
                rejectWork($_POST['work_id'], $_POST['reason']);
            }
            header('Location: ?page=verify_work');
            exit();
    }
}
// // Render requested page
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
    case 'mark_attendance':  // <-- ADD THIS NEW CASE
        renderMarkAttendancePage();
        break;
    case 'add_work':
        renderAddWorkPage();
        break;
        
    case 'edit_work':
        renderEditWorkPage();
        break;
        
    case 'products':
        renderProductsPage();
        break;
        
    case 'verify_work':
        renderVerifyWorkPage();
        break;
        
    case 'attendance':
        renderAttendancePage();
        break;
        
    case 'expenses':
        renderExpensesPage();
        break;
        
    case 'reports':
        renderReportsPage();
        break;
        
    case 'users':
        renderUsersPage();
        break;
        
    case 'backup':
        renderBackupPage();
        break;
        
    case 'print_bill':
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
?>