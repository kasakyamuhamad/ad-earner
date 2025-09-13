<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @routes
    
    <!-- Fix for Vite manifest error -->
    @php
        // Get the component path from the Inertia page data
        $componentPath = $page['component'];
        
        // Define the expected base path
        $basePath = 'resources/js/Pages/';
        
        // Check if the component exists with various extensions and locations
        $possibleExtensions = ['.vue', '.js', ''];
        $possiblePaths = [];
        
        foreach ($possibleExtensions as $ext) {
            // Standard path
            $possiblePaths[] = $basePath . $componentPath . $ext;
            
            // With Index suffix for directory components
            $possiblePaths[] = $basePath . $componentPath . '/Index' . $ext;
            
            // Handle nested components (replace dots with slashes)
            $nestedPath = $basePath . str_replace('.', '/', $componentPath) . $ext;
            $possiblePaths[] = $nestedPath;
            
            $nestedIndexPath = $basePath . str_replace('.', '/', $componentPath) . '/Index' . $ext;
            $possiblePaths[] = $nestedIndexPath;
        }
        
        // Check if any of the possible paths exist
        $componentExists = false;
        $foundPath = null;
        
        foreach ($possiblePaths as $path) {
            if (file_exists(base_path($path))) {
                $componentExists = true;
                $foundPath = $path;
                break;
            }
        }
        
        // If component doesn't exist, use a fallback
        if (!$componentExists) {
            // Log the error for debugging
            \Log::error('Vite manifest error: Unable to locate component file', [
                'component' => $componentPath,
                'possible_paths' => $possiblePaths
            ]);
            
            // Try to use a fallback component that likely exists
            $fallbackComponents = ['Welcome', 'Dashboard', 'Home'];
            foreach ($fallbackComponents as $fallback) {
                $fallbackPath = $basePath . $fallback . '.vue';
                if (file_exists(base_path($fallbackPath))) {
                    $componentPath = $fallback;
                    $foundPath = $fallbackPath;
                    $componentExists = true;
                    break;
                }
            }
        }
        
        // Final check - if still not found, we'll need to handle the error
        if (!$componentExists) {
            // Last resort - check if it's a case sensitivity issue
            $allFiles = glob(base_path($basePath) . '*.vue');
            foreach ($allFiles as $file) {
                $filename = pathinfo($file, PATHINFO_FILENAME);
                if (strtolower($filename) === strtolower($componentPath)) {
                    $componentPath = $filename;
                    $componentExists = true;
                    break;
                }
            }
        }
    @endphp
    
    @if($componentExists)
        @vite(['resources/js/app.js', "resources/js/Pages/{$componentPath}.vue"])
    @else
        <!-- Load without the specific component -->
        @vite(['resources/js/app.js'])
    @endif
    
    @inertiaHead

    <style>
        body {
            font-family: 'Figtree', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .error-container {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 90%;
            text-align: center;
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
        
        .logo {
            font-size: 2rem;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body>
    @inertia
    
    <!-- Fallback content in case Inertia fails -->
    <div id="fallback-content" style="display: none;">
        <div class="error-container">
            <div class="logo">AdEarner</div>
            <h1 class="error-title">Component Loading Error</h1>
            <p class="error-description">
                The application encountered an error while trying to load the component. 
                This is usually caused by a missing Vue component file or Vite configuration issue.
            </p>
            
            <div class="error-code">
                Error: Unable to locate file in Vite manifest: resources/js/Pages/{{ $page['component'] }}.vue
                @if($componentExists)
                    <br><br>Loaded fallback: {{ $componentPath }}.vue
                @else
                    <br><br>No fallback component found.
                @endif
            </div>
            
            <h2>Possible Solutions:</h2>
            <ol class="solution-list">
                <li>Run <code>npm run dev</code> or <code>npm run build</code> to rebuild assets</li>
                <li>Clear Laravel cache with <code>php artisan optimize:clear</code></li>
                <li>Check Vite configuration in <code>vite.config.js</code></li>
                <li>Restart the Vite development server</li>
                <li>Check for case sensitivity in file names</li>
            </ol>
            
            <div>
                <a href="/" class="btn">Return to Homepage</a>
                <a href="javascript:location.reload()" class="btn">Reload Page</a>
                <button onclick="showDebugInfo()" class="btn-secondary">Show Debug Info</button>
            </div>
            
            <div id="debug-info" style="display: none; margin-top: 20px; text-align: left;">
                <h3>Debug Information:</h3>
                <p><strong>Component:</strong> {{ $page['component'] }}</p>
                <p><strong>Fallback:</strong> {{ $componentPath }}</p>
                <p><strong>Found Path:</strong> {{ $foundPath ?? 'None' }}</p>
                <p><strong>File Exists:</strong> {{ file_exists(base_path('resources/js/Pages/Welcome.vue')) ? 'Yes' : 'No' }}</p>
                <p><strong>File Size:</strong> {{ file_exists(base_path('resources/js/Pages/Welcome.vue')) ? filesize(base_path('resources/js/Pages/Welcome.vue')) : 'N/A' }} bytes</p>
            </div>
        </div>
    </div>

    <script>
        // Show fallback content if Inertia doesn't load within 3 seconds
        setTimeout(() => {
            if (!document.querySelector('[data-page]')) {
                document.getElementById('fallback-content').style.display = 'block';
            }
        }, 3000);
        
        function showDebugInfo() {
            document.getElementById('debug-info').style.display = 'block';
        }
        
        // Console debug information
        console.error('Vite manifest error: Unable to locate file:', 'resources/js/Pages/{{ $page['component'] }}.vue');
        @if($componentExists)
            console.info('Trying to load instead:', 'resources/js/Pages/{{ $componentPath }}.vue');
        @endif
        console.info('Check that the file exists and run: npm run dev');
    </script>
</body>
</html>