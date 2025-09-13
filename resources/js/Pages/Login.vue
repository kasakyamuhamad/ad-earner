<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'AdEarner') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Manual asset loading as fallback -->
    <script src="https://cdn.jsdelivr.net/npm/vue@3.2.31/dist/vue.global.js"></script>
    <script src="https://unpkg.com/@inertiajs/vue3"></script>
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
            font-family: 'Figtree', sans-serif;
        }
        
        body {
            background-color: #f5f7fb;
            color: var(--dark);
            line-height: 1.6;
        }
        
        .container {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            background: linear-gradient(to bottom, var(--primary), var(--secondary));
            color: white;
            padding: 20px 0;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
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
        
        /* Main Content Styles */
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
        
        .notification-btn {
            position: relative;
            cursor: pointer;
        }
        
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: var(--warning);
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
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
            padding: 20px;
            flex: 1;
            overflow-y: auto;
        }
        
        .error-container {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 2rem auto;
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
        
        .logo {
            font-size: 2rem;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 1.5rem;
            text-align: center;
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
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo">
                <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0MCIgaGVpZ2h0PSI0MCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiBzdHJva2U9IiNmZmYiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIj48cGF0aCBkPSJNMTAuODggMTAuODhhMyAzIDAgMSAwIDQuMjQgNC4yNCI+PC9wYXRoPjxwYXRoIGQ9Ik0xMC43MyA1LjA4QTEwLjEgMTAuMSAwIDAgMSAxMiA1YzQuNDIgMCA4IDMuNTggOCA4YTIwLjI0IDIwLjI0IDAgMCAxLS4zNCAzLjg2Ij48L3BhdGg+PHBhdGggZD0iTTYuNjEgNi42MUE5Ljg5IDkuODkgMCAwIDEgMTIgM2M0LjQyIDAgOCAzLjU4IDggOCAwIDEuNTctLjQ1IDMuMDMtMS4yMiA0LjI2Ij48L3BhdGg+PHBhdGggZD0iTTE4LjkyIDE4LjkyQTEwLjA3IDEwLjA3IDwgMCAxIDEyIDIxYy00LjQyIDAtOC0zLjU4LTgtOGMwLTEuNjEuNDUtMy4xIDEuMjItNC4zOCI+PC9wYXRoPjxwYXRoIGQ9Ik03IDcuNGE2LjQ0IDYuNDMgMCAwIDEgLS4yNi0yLjQiPjwvcGF0aD48cGF0aCBkPSJNMTIuODggMTIuODhhMyAzIDAgMCAwIDQuMjQtNC4yNCI+PC9wYXRoPjxwYXRoIGQ9Ik0xNyA3LjRhNi40NCA2LjQzIDAgMCAwLTIuNC0uMjYiPjwvcGF0h+PHBhdGggZD0iTTMgM2wxOCAxOCI+PC9wYXRoPjwvc3ZnPg==" alt="Logo">
                <h2>AdEarner</h2>
            </div>
            <div class="menu-item active">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </div>
            <div class="menu-item">
                <i class="fas fa-ad"></i>
                <span>Ad Management</span>
            </div>
            <div class="menu-item">
                <i class="fas fa-wallet"></i>
                <span>Earnings</span>
            </div>
            <div class="menu-item">
                <i class="fas fa-chart-line"></i>
                <span>Analytics</span>
            </div>
            <div class="menu-item">
                <i class="fas fa-cog"></i>
                <span>Settings</span>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <div class="header-left">
                    <h1>Vite Configuration Error</h1>
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
                <div class="error-container">
                    <div class="logo">AdEarner</div>
                    <h1 class="error-title">Vite Dependency Scanning Error</h1>
                    <p class="error-description">
                        The application encountered an error while trying to scan dependencies in your <code>app.js</code> file.
                        This is usually caused by missing files, incorrect paths, or syntax errors.
                    </p>
                    
                    <div class="error-code">
                        Error: Failed to scan for dependencies from entries: /home/spar/Desktop/dev/ad-earner/resources/js/app.js
                    </div>
                    
                    <h2>How to Fix This Issue:</h2>
                    <ol class="solution-list">
                        <li><strong>Check your app.js file</strong> for syntax errors or incorrect import paths</li>
                        <li><strong>Verify all imported files exist</strong> at the specified locations</li>
                        <li><strong>Run npm install</strong> to ensure all dependencies are installed</li>
                        <li><strong>Check your vite.config.js</strong> for correct configuration</li>
                        <li><strong>Clear node_modules and reinstall</strong> if necessary</li>
                    </ol>
                    
                    <h3>Example of a correct app.js file:</h3>
                    <div class="code-block">
import { createApp, h } from 'vue'<br>
import { createInertiaApp } from '@inertiajs/vue3'<br>
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'<br>
<br>
createInertiaApp({<br>
&nbsp;&nbsp;title: (title) => `${title} - ${appName}`,<br>
&nbsp;&nbsp;resolve: (name) => resolvePageComponent(<br>
&nbsp;&nbsp;&nbsp;&nbsp;`./Pages/${name}.vue`,<br>
&nbsp;&nbsp;&nbsp;&nbsp;import.meta.glob('./Pages/**/*.vue')<br>
&nbsp;&nbsp;),<br>
&nbsp;&nbsp;setup({ el, App, props, plugin }) {<br>
&nbsp;&nbsp;&nbsp;&nbsp;createApp({ render: () => h(App, props) })<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.use(plugin)<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.mount(el)<br>
&nbsp;&nbsp;},<br>
})
                    </div>
                    
                    <h3>Steps to resolve:</h3>
                    <div class="code-block">
# 1. Check for syntax errors in your app.js<br>
node -c resources/js/app.js<br><br>

# 2. Install dependencies if missing<br>
npm install<br><br>

# 3. Clear cache and restart Vite<br>
php artisan optimize:clear<br>
npm run dev<br><br>

# 4. If problems persist, remove node_modules and reinstall<br>
rm -rf node_modules package-lock.json<br>
npm install<br>
npm run dev
                    </div>
                    
                    <div style="text-align: center; margin-top: 2rem;">
                        <button onclick="location.reload()" class="btn">Retry Loading</button>
                        <a href="/" class="btn btn-success">Return to Homepage</a>
                        <button onclick="showDebugInfo()" class="btn-secondary">Show Debug Info</button>
                    </div>
                    
                    <div id="debug-info" style="display: none; margin-top: 20px; text-align: left;">
                        <h3>Debug Information:</h3>
                        <p><strong>APP_URL:</strong> {{ config('app.url') }}</p>
                        <p><strong>Environment:</strong> {{ config('app.env') }}</p>
                        <p><strong>Vite Server:</strong> <span id="vite-status">Checking...</span></p>
                        <p><strong>Current Time:</strong> <span id="current-time"></span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('current-time').textContent = new Date().toLocaleString();
        
        // Check if Vite server is running
        fetch('http://localhost:3000')
            .then(response => {
                document.getElementById('vite-status').textContent = 'Running';
                document.getElementById('vite-status').style.color = 'green';
            })
            .catch(error => {
                document.getElementById('vite-status').textContent = 'Not running - try "npm run dev"';
                document.getElementById('vite-status').style.color = 'red';
            });
        
        function showDebugInfo() {
            document.getElementById('debug-info').style.display = 'block';
        }
        
        console.error('Vite dependency scanning error: Failed to scan for dependencies from entries: /home/spar/Desktop/dev/ad-earner/resources/js/app.js');
        console.info('Check your app.js file for syntax errors or missing imports');
    </script>
</body>
</html>