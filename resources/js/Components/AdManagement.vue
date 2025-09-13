<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vue.js Dashboard with Ad Management</title>
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
        }
        
        #app {
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
        
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
        }
        
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 24px;
        }
        
        .adstera .stat-icon {
            background-color: rgba(67, 97, 238, 0.1);
            color: var(--primary);
        }
        
        .propeller .stat-icon {
            background-color: rgba(247, 37, 133, 0.1);
            color: var(--warning);
        }
        
        .stat-info h3 {
            font-size: 24px;
            margin-bottom: 5px;
        }
        
        .stat-info p {
            color: var(--gray);
            font-size: 14px;
        }
        
        .ad-network-tabs {
            display: flex;
            margin-bottom: 20px;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        .tab {
            padding: 15px 20px;
            flex: 1;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .tab.active {
            background: var(--primary);
            color: white;
        }
        
        .tab-content {
            display: none;
        }
        
        .tab-content.active {
            display: block;
        }
        
        .ad-configuration {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }
        
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--light-gray);
            border-radius: 6px;
            font-size: 16px;
        }
        
        .btn {
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .btn-primary {
            background: var(--primary);
            color: white;
        }
        
        .btn-primary:hover {
            background: var(--secondary);
        }
        
        .ad-preview {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        .preview-container {
            border: 2px dashed var(--light-gray);
            border-radius: 8px;
            padding: 20px;
            min-height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 20px;
        }
        
        .ad-placeholder {
            text-align: center;
            color: var(--gray);
        }
        
        .ad-placeholder i {
            font-size: 32px;
            margin-bottom: 10px;
            display: block;
        }
        
        .section-title {
            margin: 30px 0 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--light-gray);
            color: var(--dark);
        }
        
        .mobile-menu-btn {
            display: none;
            font-size: 24px;
            cursor: pointer;
        }
        
        @media (max-width: 992px) {
            .sidebar {
                position: fixed;
                left: -250px;
                height: 100%;
                transition: left 0.3s ease;
                z-index: 1000;
            }
            
            .sidebar.active {
                left: 0;
            }
            
            .mobile-menu-btn {
                display: block;
            }
            
            .stats-container {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (max-width: 768px) {
            .stats-container {
                grid-template-columns: 1fr;
            }
            
            .header-left h1 {
                font-size: 1.2rem;
            }
        }
        
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
        
        .overlay.active {
            display: block;
        }
    </style>
</head>
<body>
    <div id="app">
        <!-- Sidebar -->
        <div class="sidebar" :class="{ active: sidebarActive }">
            <div class="logo">
                <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0MCIgaGVpZ2h0PSI0MCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiBzdHJva2U9IiNmZmYiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIj48cGF0aCBkPSJNMTAuODggMTAuODhhMyAzIDAgMSAwIDQuMjQgNC4yNCI+PC9wYXRoPjxwYXRoIGQ9Ik0xMC43MyA1LjA4QTEwLjEgMTAuMSAwIDAgMSAxMiA1YzQuNDIgMCA4IDMuNTggOCA4YTIwLjI0IDIwLjI0IDAgMCAxLS4zNCAzLjg2Ij48L3BhdGg+PHBhdGggZD0iTTYuNjEgNi42MUE5Ljg5IDkuODkgMCAwIDEgMTIgM2M0LjQyIDAgOCAzLjU4IDggOCAwIDEuNTctLjQ1IDMuMDMtMS4yMiA0LjI2Ij48L3BhdGg+PHBhdGggZD0iTTE4LjkyIDE4LjkyQTEwLjA3IDEwLjA3IDAgMCAxIDEyIDIxYy00LjQyIDAtOC0zLjU4LTgtOGMwLTEuNjEuNDUtMy4xIDEuMjItNC4zOCI+PC9wYXRoPjxwYXRoIGQ9Ik03IDcuNGE2LjQ0IDYuNDMgMCAwIDEgLS4yNi0yLjQiPjwvcGF0aD48cGF0aCBkPSJNMTIuODggMTIuODhhMyAzIDAgMCAwIDQuMjQtNC4yNCI+PC9wYXRoPjxwYXRoIGQ9Ik0xNyA3LjRhNi40NCA2LjQzIDAgMCAwLTIuNC0uMjYiPjwvcGF0aD48cGF0aCBkPSJNMyAzbDE4IDE4Ij48L3BhdGg+PC9zdmc+" alt="Logo">
                <h2>AdEarner</h2>
            </div>
            <div class="menu-item" :class="{ active: currentPage === 'dashboard' }" @click="navigateTo('dashboard')">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </div>
            <div class="menu-item" :class="{ active: currentPage === 'ad-management' }" @click="navigateTo('ad-management')">
                <i class="fas fa-ad"></i>
                <span>Ad Management</span>
            </div>
            <div class="menu-item" :class="{ active: currentPage === 'earnings' }" @click="navigateTo('earnings')">
                <i class="fas fa-wallet"></i>
                <span>Earnings</span>
            </div>
            <div class="menu-item" :class="{ active: currentPage === 'analytics' }" @click="navigateTo('analytics')">
                <i class="fas fa-chart-line"></i>
                <span>Analytics</span>
            </div>
            <div class="menu-item" :class="{ active: currentPage === 'settings' }" @click="navigateTo('settings')">
                <i class="fas fa-cog"></i>
                <span>Settings</span>
            </div>
        </div>
        
        <!-- Overlay for mobile -->
        <div class="overlay" :class="{ active: sidebarActive }" @click="sidebarActive = false"></div>
        
        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <div class="header-left">
                    <span class="mobile-menu-btn" @click="sidebarActive = !sidebarActive">
                        <i class="fas fa-bars"></i>
                    </span>
                    <h1>{{ pageTitle }}</h1>
                </div>
                <div class="header-right">
                    <div class="notification-btn">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">3</span>
                    </div>
                    <div class="user-profile">
                        <div class="user-avatar">JD</div>
                        <div class="user-info">
                            <div class="user-name">John Doe</div>
                            <div class="user-role">Administrator</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="content">
                <!-- Dashboard Content -->
                <div v-if="currentPage === 'dashboard'">
                    <h2 class="section-title">Dashboard Overview</h2>
                    
                    <div class="stats-container">
                        <div class="stat-card">
                            <div class="stat-icon" style="background-color: rgba(76, 201, 240, 0.1); color: var(--success);">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                            <div class="stat-info">
                                <h3>$1,248.50</h3>
                                <p>Total Earnings</p>
                            </div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-icon" style="background-color: rgba(247, 37, 133, 0.1); color: var(--warning);">
                                <i class="fas fa-eye"></i>
                            </div>
                            <div class="stat-info">
                                <h3>24,892</h3>
                                <p>Total Impressions</p>
                            </div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-icon" style="background-color: rgba(67, 97, 238, 0.1); color: var(--primary);">
                                <i class="fas fa-mouse-pointer"></i>
                            </div>
                            <div class="stat-info">
                                <h3>1,842</h3>
                                <p>Total Clicks</p>
                            </div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-icon" style="background-color: rgba(58, 12, 163, 0.1); color: var(--secondary);">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div class="stat-info">
                                <h3>7.4%</h3>
                                <p>Overall CTR</p>
                            </div>
                        </div>
                    </div>
                    
                    <h2 class="section-title">Recent Activity</h2>
                    
                    <div class="ad-configuration">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                            <div>
                                <h3 style="margin-bottom: 15px; color: var(--primary);">Recent Earnings</h3>
                                <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 10px;">
                                    <div style="display: flex; justify-content: space-between;">
                                        <span>Today:</span>
                                        <strong>$42.80</strong>
                                    </div>
                                </div>
                                <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 10px;">
                                    <div style="display: flex; justify-content: space-between;">
                                        <span>This Week:</span>
                                        <strong>$286.40</strong>
                                    </div>
                                </div>
                                <div style="background: #f8f9fa; padding: 15px; border-radius: 8px;">
                                    <div style="display: flex; justify-content: space-between;">
                                        <span>This Month:</span>
                                        <strong>$1,048.50</strong>
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <h3 style="margin-bottom: 15px; color: var(--warning);">Performance Summary</h3>
                                <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 10px;">
                                    <div style="display: flex; justify-content: space-between;">
                                        <span>Best Performing Network:</span>
                                        <strong>Propeller Ads</strong>
                                    </div>
                                </div>
                                <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 10px;">
                                    <div style="display: flex; justify-content: space-between;">
                                        <span>Best Ad Format:</span>
                                        <strong>Display Ads</strong>
                                    </div>
                                </div>
                                <div style="background: #f8f9fa; padding: 15px; border-radius: 8px;">
                                    <div style="display: flex; justify-content: space-between;">
                                        <span>Top Category:</span>
                                        <strong>Entertainment</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Ad Management Content -->
                <div v-if="currentPage === 'ad-management'">
                    <h2 class="section-title">Real-time Ad Performance</h2>
                    
                    <!-- Stats Cards -->
                    <div class="stats-container">
                        <div class="stat-card adstera">
                            <div class="stat-icon">
                                <i class="fas fa-ad"></i>
                            </div>
                            <div class="stat-info">
                                <h3>{{ adsteraImpressions.toLocaleString() }}</h3>
                                <p>AdStera Impressions</p>
                            </div>
                        </div>
                        
                        <div class="stat-card propeller">
                            <div class="stat-icon">
                                <i class="fas fa-rocket"></i>
                            </div>
                            <div class="stat-info">
                                <h3>{{ propellerClicks.toLocaleString() }}</h3>
                                <p>Propeller Clicks</p>
                            </div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-icon" style="background-color: rgba(76, 201, 240, 0.1); color: var(--success);">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                            <div class="stat-info">
                                <h3>${{ totalRevenue.toFixed(2) }}</h3>
                                <p>Total Revenue</p>
                            </div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-icon" style="background-color: rgba(247, 37, 133, 0.1); color: var(--warning);">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div class="stat-info">
                                <h3>{{ ctr }}%</h3>
                                <p>CTR Rate</p>
                            </div>
                        </div>
                    </div>
                    
                    <h2 class="section-title">Ad Network Configuration</h2>
                    
                    <!-- Ad Network Tabs -->
                    <div class="ad-network-tabs">
                        <div class="tab" :class="{ active: activeTab === 'adstera' }" @click="activeTab = 'adstera'">
                            <i class="fas fa-ad"></i> AdStera Ads
                        </div>
                        <div class="tab" :class="{ active: activeTab === 'propeller' }" @click="activeTab = 'propeller'">
                            <i class="fas fa-rocket"></i> Propeller Ads
                        </div>
                    </div>
                    
                    <!-- AdStera Configuration -->
                    <div class="tab-content" :class="{ active: activeTab === 'adstera' }">
                        <div class="ad-configuration">
                            <h2>AdStera Configuration</h2>
                            <div class="form-group">
                                <label for="adstera-zone">Ad Zone ID</label>
                                <input type="text" id="adstera-zone" v-model="adsteraConfig.zoneId" placeholder="Enter your zone ID">
                            </div>
                            <div class="form-group">
                                <label for="adstera-type">Ad Type</label>
                                <select id="adstera-type" v-model="adsteraConfig.type">
                                    <option value="banner">Banner</option>
                                    <option value="popunder">Popunder</option>
                                    <option value="interstitial">Interstitial</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="adstera-size">Ad Size</label>
                                <select id="adstera-size" v-model="adsteraConfig.size">
                                    <option value="300x250">300x250 (Medium Rectangle)</option>
                                    <option value="728x90">728x90 (Leaderboard)</option>
                                    <option value="160x600">160x600 (Wide Skyscraper)</option>
                                    <option value="320x50">320x50 (Mobile Banner)</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="adstera-status">Status</label>
                                <select id="adstera-status" v-model="adsteraConfig.status">
                                    <option value="active">Active</option>
                                    <option value="paused">Paused</option>
                                    <option value="disabled">Disabled</option>
                                </select>
                            </div>
                            <button class="btn btn-primary" @click="saveAdsteraConfig">
                                <i class="fas fa-save"></i> Save Configuration
                            </button>
                        </div>
                        
                        <div class="ad-preview">
                            <h2>Ad Preview</h2>
                            <div class="preview-container">
                                <div class="ad-placeholder">
                                    <i class="fas fa-ad"></i>
                                    <p>AdStera Ad Preview</p>
                                    <p>{{ adsteraConfig.size }} {{ adsteraConfig.type }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Propeller Ads Configuration -->
                    <div class="tab-content" :class="{ active: activeTab === 'propeller' }">
                        <div class="ad-configuration">
                            <h2>Propeller Ads Configuration</h2>
                            <div class="form-group">
                                <label for="propeller-id">Publisher ID</label>
                                <input type="text" id="propeller-id" v-model="propellerConfig.publisherId" placeholder="Enter your publisher ID">
                            </div>
                            <div class="form-group">
                                <label for="propeller-type">Ad Format</label>
                                <select id="propeller-type" v-model="propellerConfig.type">
                                    <option value="display">Display Ads</option>
                                    <option value="push">Push Notifications</option>
                                    <option value="native">Native Ads</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="propeller-category">Ad Category</label>
                                <select id="propeller-category" v-model="propellerConfig.category">
                                    <option value="general">General</option>
                                    <option value="gaming">Gaming</option>
                                    <option value="finance">Finance</option>
                                    <option value="entertainment">Entertainment</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="propeller-status">Status</label>
                                <select id="propeller-status" v-model="propellerConfig.status">
                                    <option value="active">Active</option>
                                    <option value="paused">Paused</option>
                                    <option value="disabled">Disabled</option>
                                </select>
                            </div>
                            <button class="btn btn-primary" @click="savePropellerConfig">
                                <i class="fas fa-save"></i> Save Configuration
                            </button>
                        </div>
                        
                        <div class="ad-preview">
                            <h2>Ad Preview</h2>
                            <div class="preview-container">
                                <div class="ad-placeholder">
                                    <i class="fas fa-rocket"></i>
                                    <p>Propeller Ad Preview</p>
                                    <p>{{ propellerConfig.type }} Format</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Other pages would go here -->
                <div v-if="currentPage !== 'dashboard' && currentPage !== 'ad-management'">
                    <h2 class="section-title">{{ pageTitle }}</h2>
                    <div class="ad-configuration">
                        <p>This section is under development. Coming soon!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const { createApp, ref, computed, onMounted } = Vue;
        
        createApp({
            setup() {
                const currentPage = ref('dashboard');
                const sidebarActive = ref(false);
                const activeTab = ref('adstera');
                
                const adsteraImpressions = ref(2548);
                const propellerClicks = ref(3712);
                const totalRevenue = ref(426.80);
                const ctr = ref(8.2);
                
                const adsteraConfig = ref({
                    zoneId: 'AST-4892-37',
                    type: 'banner',
                    size: '300x250',
                    status: 'active'
                });
                
                const propellerConfig = ref({
                    publisherId: 'PL-7263-12',
                    type: 'display',
                    category: 'general',
                    status: 'active'
                });
                
                const pageTitle = computed(() => {
                    switch(currentPage.value) {
                        case 'dashboard': return 'Dashboard Overview';
                        case 'ad-management': return 'Ad Management';
                        case 'earnings': return 'Earnings Report';
                        case 'analytics': return 'Analytics';
                        case 'settings': return 'Settings';
                        default: return 'Dashboard';
                    }
                });
                
                const navigateTo = (page) => {
                    currentPage.value = page;
                    sidebarActive.value = false;
                };
                
                const saveAdsteraConfig = () => {
                    console.log('Saving Adstera config:', adsteraConfig.value);
                    // Here you would typically make an API call to save the configuration
                    alert('AdStera configuration saved successfully!');
                };
                
                const savePropellerConfig = () => {
                    console.log('Saving Propeller config:', propellerConfig.value);
                    // Here you would typically make an API call to save the configuration
                    alert('Propeller Ads configuration saved successfully!');
                };
                
                // Simulate real-time data updates
                onMounted(() => {
                    setInterval(() => {
                        adsteraImpressions.value += Math.floor(Math.random() * 10);
                        propellerClicks.value += Math.floor(Math.random() * 5);
                        totalRevenue.value += (Math.random() * 2).toFixed(2);
                    }, 3000);
                });
                
                return {
                    currentPage,
                    sidebarActive,
                    activeTab,
                    adsteraImpressions,
                    propellerClicks,
                    totalRevenue,
                    ctr,
                    adsteraConfig,
                    propellerConfig,
                    pageTitle,
                    navigateTo,
                    saveAdsteraConfig,
                    savePropellerConfig
                };
            }
        }).mount('#app');
    </script>
</body>
</html>