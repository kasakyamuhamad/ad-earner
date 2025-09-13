<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Access Issue - AdEarner</title>
    <script src="https://cdn.jsdelivr.net/npm/vue@3.2.31/dist/vue.global.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3a0ca3;
            --success: #4cc9f0;
            --warning: #f72585;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
            --light-gray: #e9ecef;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f7fb;
            color: var(--dark);
            line-height: 1.6;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            display: flex;
            width: 100%;
            max-width: 1200px;
            min-height: 600px;
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        
        .sidebar {
            width: 250px;
            background: linear-gradient(to bottom, var(--primary), var(--secondary));
            color: white;
            padding: 20px 0;
            display: flex;
            flex-direction: column;
        }
        
        .logo {
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }
        
        .logo img {
            width: 40px;
            height: 40px;
            margin-right: 10px;
        }
        
        .logo h2 {
            font-weight: 600;
            font-size: 22px;
        }
        
        .menu-item {
            padding: 12px 20px;
            display: flex;
            align-items: center;
            transition: all 0.3s;
            cursor: pointer;
            border-left: 4px solid transparent;
        }
        
        .menu-item:hover, .menu-item.active {
            background-color: rgba(255, 255, 255, 0.1);
            border-left: 4px solid var(--success);
        }
        
        .menu-item i {
            margin-right: 10px;
            font-size: 18px;
            width: 24px;
            text-align: center;
        }
        
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        
        .header {
            height: 70px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        
        .header-left h1 {
            font-weight: 600;
            color: var(--dark);
            font-size: 1.5rem;
        }
        
        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }
        
        .content {
            padding: 30px;
            flex: 1;
            overflow-y: auto;
        }
        
        .error-container {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            max-width: 100%;
        }
        
        .error-title {
            color: #e53e3e;
            font-size: 1.8rem;
            margin-bottom: 1rem;
            font-weight: 600;
        }
        
        .error-description {
            color: #4a5568;
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }
        
        .error-code {
            background: #f7fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 1rem;
            font-family: monospace;
            margin: 1.5rem 0;
            text-align: left;
            overflow-x: auto;
            font-size: 0.9rem;
        }
        
        .solution-list {
            text-align: left;
            margin: 1.5rem 0;
            padding-left: 1.5rem;
        }
        
        .solution-list li {
            margin-bottom: 0.5rem;
            color: #4a5568;
        }
        
        .btn {
            display: inline-block;
            background: #667eea;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            transition: background 0.2s;
            margin: 0.5rem;
            border: none;
            cursor: pointer;
            font-size: 1rem;
        }
        
        .btn:hover {
            background: #5a67d8;
        }
        
        .btn-secondary {
            background: #e53e3e;
        }
        
        .btn-secondary:hover {
            background: #c53030;
        }
        
        .btn-success {
            background: #38a169;
        }
        
        .btn-success:hover {
            background: #2f855a;
        }
        
        .code-block {
            background: #1a202c;
            color: #e2e8f0;
            padding: 1rem;
            border-radius: 6px;
            font-family: monospace;
            overflow-x: auto;
            margin: 1rem 0;
            font-size: 0.9rem;
        }
        
        .tabs {
            display: flex;
            margin-bottom: 20px;
            border-bottom: 1px solid var(--light-gray);
        }
        
        .tab {
            padding: 10px 20px;
            cursor: pointer;
            border-bottom: 3px solid transparent;
        }
        
        .tab.active {
            border-bottom: 3px solid var(--primary);
            color: var(--primary);
            font-weight: 500;
        }
        
        .tab-content {
            display: none;
        }
        
        .tab-content.active {
            display: block;
        }
        
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                height: auto;
            }
            
            .sidebar {
                width: 100%;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div id="app">
        <div class="container">
            <div class="sidebar">
                <div class="logo">
                    <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0MCIgaGVpZ2h0PSI0MCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiBzdHJva2U9IiNmZmYiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIj48cGF0aCBkPSJNMTAuODggMTAuODhhMyAzIDAgMSAwIDQuMjQgNC4yNCI+PC9wYXRoPjxwYXRoIGQ9Ik0xMC43MyA1LjA4QTEwLjEgMTAuMSAwIDAgMSAxMiA1YzQuNDIgMCA4IDMuNTggOCA4YTIwLjI0IDIwLjI0IDAgMCAxLS4zNCAzLjg2Ij48L3BhdGg+PHBhdGggZD0iTTYuNjEgNi42MUE5Ljg5IDkuODkgMCAwIDEgMTIgM2M0LjQyIDAgOCAzLjU4IDggOCAwIDEuNTctLjQ1IDMuMDMtMS4yMiA0LjI2Ij48L3BhdGg+PHBhdGggZD0iTTE4LjkyIDE4LjkyQTEwLjA3IDEwLjA3IDAgMCAxIDEyIDIxYy00LjQyIDAtOC0zLjU4LTgtOGMwLTEuNjEuNDUtMy4xIDEuMjItNC4zOCI+PC9wYXRoPjxwYXRoIGQ9Ik03IDcuNGE2LjQ0IDYuNDMgMCAwIDEgLS4yNi0yLjQiPjwvcGF0aD48cGF0aCBkPSJNMTIuODggMTIuODhhMyAzIDAgMCAwIDQuMjQtNC4yNCI+PC9wYXRoPjxwYXRoIGQ9Ik0xNyA3LjRhNi40NCA2LjQzIDAgMCAwLTIuNC0uMjYiPjwvcGF0aD48cGF0aCBkPSJNMyAzbDE4IDE4Ij48L3BhdGg+PC9zdmc+" alt="Logo">
                    <h2>AdEarner</h2>
                </div>
                <div class="menu-item" :class="{ active: activeTab === 'issue' }" @click="activeTab = 'issue'">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>Issue Overview</span>
                </div>
                <div class="menu-item" :class="{ active: activeTab === 'solutions' }" @click="activeTab = 'solutions'">
                    <i class="fas fa-tools"></i>
                    <span>Solutions</span>
                </div>
                <div class="menu-item" :class="{ active: activeTab === 'routes' }" @click="activeTab = 'routes'">
                    <i class="fas fa-route"></i>
                    <span>Route Check</span>
                </div>
                <div class="menu-item" :class="{ active: activeTab === 'middleware' }" @click="activeTab = 'middleware'">
                    <i class="fas fa-shield-alt"></i>
                    <span>Middleware</span>
                </div>
                <div class="menu-item" :class="{ active: activeTab === 'login' }" @click="activeTab = 'login'">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Admin Login</span>
                </div>
            </div>
            
            <div class="main-content">
                <div class="header">
                    <div class="header-left">
                        <h1>Admin Access Issue</h1>
                    </div>
                    <div class="header-right">
                        <div class="user-profile">
                            <div class="user-avatar">AD</div>
                            <div class="user-info">
                                <div class="user-name">Admin User</div>
                                <div class="user-role">Administrator</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="content">
                    <!-- Issue Overview Tab -->
                    <div class="tab-content" :class="{ active: activeTab === 'issue' }">
                        <div class="error-container">
                            <h2 class="error-title">Admin Login & Dashboard Access Issue</h2>
                            <p class="error-description">
                                You can log in as a regular user and use the application normally, but you're unable to 
                                access the admin panel. This is typically caused by one of the following issues:
                            </p>
                            
                            <ul class="solution-list">
                                <li>Incorrect admin route configuration</li>
                                <li>Middleware not properly checking for admin privileges</li>
                                <li>Session or authentication issues</li>
                                <li>Incorrect user role assignment in the database</li>
                                <li>Vue component rendering issues for admin routes</li>
                            </ul>
                            
                            <div class="error-code">
                                // Common symptoms:<br>
                                - Regular user login works fine<br>
                                - Admin login redirects or shows errors<br>
                                - Admin routes return 403 or 404 errors<br>
                                - Admin dashboard doesn't render properly
                            </div>
                        </div>
                    </div>
                    
                    <!-- Solutions Tab -->
                    <div class="tab-content" :class="{ active: activeTab === 'solutions' }">
                        <div class="error-container">
                            <h2>Solutions to Fix Admin Access</h2>
                            
                            <h3>1. Check Admin Middleware</h3>
                            <p>Ensure you have an admin middleware that correctly checks user roles:</p>
                            <div class="code-block">
// In app/Http/Middleware/AdminMiddleware.php<br>
public function handle($request, Closure $next)<br>
{<br>
&nbsp;&nbsp;if (auth()->check() && auth()->user()->is_admin) {<br>
&nbsp;&nbsp;&nbsp;&nbsp;return $next($request);<br>
&nbsp;&nbsp;}<br>
<br>
&nbsp;&nbsp;return redirect('/')->with('error', 'Access denied.');<br>
}
                            </div>
                            
                            <h3>2. Verify Routes</h3>
                            <p>Check your routes in routes/web.php:</p>
                            <div class="code-block">
// Admin routes with admin middleware<br>
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {<br>
&nbsp;&nbsp;Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');<br>
&nbsp;&nbsp;// Other admin routes...<br>
});<br>
<br>
// Admin login routes (without admin middleware)<br>
Route::prefix('admin')->group(function () {<br>
&nbsp;&nbsp;Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');<br>
&nbsp;&nbsp;Route::post('/login', [AdminAuthController::class, 'login']);<br>
});
                            </div>
                            
                            <h3>3. Check User Model</h3>
                            <p>Ensure your User model has the is_admin attribute:</p>
                            <div class="code-block">
// In app/Models/User.php<br>
protected $fillable = [<br>
&nbsp;&nbsp;'name', 'email', 'password', 'is_admin'<br>
];<br>
<br>
protected $casts = [<br>
&nbsp;&nbsp;'is_admin' => 'boolean'<br>
];
                            </div>
                        </div>
                    </div>
                    
                    <!-- Route Check Tab -->
                    <div class="tab-content" :class="{ active: activeTab === 'routes' }">
                        <div class="error-container">
                            <h2>Route Configuration Check</h2>
                            <p>Based on your routes, here's what you need to verify:</p>
                            
                            <div class="code-block">
// Your current admin routes from routes/web.php:<br>
Route::prefix('admin')->name('admin.')->group(function () {<br>
&nbsp;&nbsp;Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');<br>
&nbsp;&nbsp;Route::post('/login', [LoginController::class, 'login']);<br>
&nbsp;&nbsp;Route::post('/logout', [LoginController::class, 'logout'])->name('logout');<br>
});<br>
<br>
// Admin routes with auth and admin middleware<br>
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {<br>
&nbsp;&nbsp;Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');<br>
&nbsp;&nbsp;Route::get('/users', [UserController::class, 'index']);<br>
&nbsp;&nbsp;Route::get('/ads', [AdController::class, 'index']);<br>
&nbsp;&nbsp;Route::get('/withdrawals', [WithdrawalController::class, 'index']);<br>
&nbsp;&nbsp;Route::post('/withdrawals/{withdrawal}/approve', [WithdrawalController::class, 'approve'])->name('admin.withdrawals.approve');<br>
&nbsp;&nbsp;Route::post('/withdrawals/{withdrawal}/reject', [WithdrawalController::class, 'reject'])->name('admin.withdrawals.reject');<br>
&nbsp;&nbsp;Route::get('/withdrawals/{withdrawal}', [WithdrawalController::class, 'show'])->name('admin.withdrawals.show');<br>
});
                            </div>
                            
                            <h3>Things to check:</h3>
                            <ol class="solution-list">
                                <li>Ensure the <code>admin</code> middleware exists and is registered in Kernel.php</li>
                                <li>Verify that the admin login routes are accessible without authentication</li>
                                <li>Check that the admin dashboard routes are properly protected</li>
                                <li>Confirm that the controllers exist and have the correct methods</li>
                            </ol>
                        </div>
                    </div>
                    
                    <!-- Middleware Tab -->
                    <div class="tab-content" :class="{ active: activeTab === 'middleware' }">
                        <div class="error-container">
                            <h2>Middleware Configuration</h2>
                            <p>Admin access issues are often related to middleware configuration.</p>
                            
                            <h3>1. Create Admin Middleware</h3>
                            <div class="code-block">
// Run this command to create admin middleware<br>
php artisan make:middleware AdminMiddleware
                            </div>
                            
                            <h3>2. Implement the middleware logic</h3>
                            <div class="code-block">
// In app/Http/Middleware/AdminMiddleware.php<br>
public function handle($request, Closure $next)<br>
{<br>
&nbsp;&nbsp;// Check if user is authenticated and is an admin<br>
&nbsp;&nbsp;if (auth()->check() && auth()->user()->is_admin) {<br>
&nbsp;&nbsp;&nbsp;&nbsp;return $next($request);<br>
&nbsp;&nbsp;}<br>
<br>
&nbsp;&nbsp;// If not admin, redirect with error<br>
&nbsp;&nbsp;return redirect('/')->with('error', 'You do not have admin access.');<br>
}
                            </div>
                            
                            <h3>3. Register the middleware</h3>
                            <div class="code-block">
// In app/Http/Kernel.php<br>
protected $routeMiddleware = [<br>
&nbsp;&nbsp;// Other middlewares...<br>
&nbsp;&nbsp;'admin' => \App\Http\Middleware\AdminMiddleware::class,<br>
];
                            </div>
                            
                            <h3>4. Apply to admin routes</h3>
                            <div class="code-block">
// In routes/web.php<br>
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {<br>
&nbsp;&nbsp;// All admin routes that require admin privileges<br>
});
                            </div>
                        </div>
                    </div>
                    
                    <!-- Admin Login Tab -->
                    <div class="tab-content" :class="{ active: activeTab === 'login' }">
                        <div class="error-container">
                            <h2>Admin Login Test</h2>
                            <p>Try logging in as an admin using this test form:</p>
                            
                            <div style="max-width: 400px; margin: 0 auto;">
                                <div class="form-group">
                                    <label for="email">Email Address</label>
                                    <input type="email" id="email" v-model="loginForm.email" placeholder="admin@example.com" class="form-control">
                                </div>
                                
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" id="password" v-model="loginForm.password" placeholder="Your password" class="form-control">
                                </div>
                                
                                <button @click="testAdminLogin" class="btn" style="width: 100%">
                                    <span v-if="!loginLoading">Test Admin Login</span>
                                    <span v-else><i class="fas fa-spinner fa-spin"></i> Testing...</span>
                                </button>
                                
                                <div v-if="loginResult" class="error-code" :style="{ color: loginResult.success ? 'green' : '#e53e3e', marginTop: '20px' }">
                                    {{ loginResult.message }}
                                </div>
                            </div>
                            
                            <h3 style="margin-top: 30px;">Common Admin Login Issues:</h3>
                            <ol class="solution-list">
                                <li>Admin user doesn't have <code>is_admin = 1</code> in database</li>
                                <li>Admin login controller not properly handling authentication</li>
                                <li>Session configuration issues</li>
                                <li>Redirects after login not working correctly</li>
                            </ol>
                        </div>
                    </div>
                    
                    <div style="text-align: center; margin-top: 2rem;">
                        <button onclick="location.reload()" class="btn">Refresh</button>
                        <a href="/admin/login" class="btn btn-success">Go to Admin Login</a>
                        <a href="/" class="btn btn-secondary">Return to Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const { createApp, ref } = Vue;
        
        createApp({
            setup() {
                const activeTab = ref('issue');
                const loginForm = ref({
                    email: '',
                    password: ''
                });
                const loginLoading = ref(false);
                const loginResult = ref(null);
                
                const testAdminLogin = () => {
                    loginLoading.value = true;
                    loginResult.value = null;
                    
                    // Simulate API call
                    setTimeout(() => {
                        loginLoading.value = false;
                        
                        // This would be an actual API call in a real application
                        loginResult.value = {
                            success: false,
                            message: 'Login failed. Check that your admin account has is_admin set to 1 in the database.'
                        };
                    }, 1500);
                };
                
                return {
                    activeTab,
                    loginForm,
                    loginLoading,
                    loginResult,
                    testAdminLogin
                };
            }
        }).mount('#app');
    </script>
</body>
</html>