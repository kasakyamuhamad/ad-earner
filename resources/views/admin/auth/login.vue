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
        $componentPath = $page['component'];
        $jsPath = "resources/js/Pages/{$componentPath}.vue";
        
        // Check if the file exists, otherwise use a fallback
        if (!file_exists($jsPath)) {
            // Log the error for debugging
            logger()->error("Vite manifest error: File not found - {$jsPath}");
            
            // Use a default component that exists
            $componentPath = 'Welcome';
        }
    @endphp
    
    @vite(['resources/js/app.js', "resources/js/Pages/{$componentPath}.vue"])
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
        }
        
        .solution-list {
            text-align: left;
            margin: 1.5rem 0;
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
    </style>
</head>
<body>
    @inertia
    
    <!-- Fallback content in case Inertia fails -->
    <div id="fallback-content" style="display: none;">
        <div class="error-container">
            <h1 class="error-title">Vite Manifest Error</h1>
            <p class="error-description">
                The application encountered an error while trying to load the component. 
                This is usually caused by a missing Vue component file or incorrect path.
            </p>
            
            <div class="error-code">
                Error: Unable to locate file in Vite manifest: resources/js/Pages/{{ $page['component'] }}.vue
            </div>
            
            <h2>Possible Solutions:</h2>
            <ol class="solution-list">
                <li>Check that the file <strong>resources/js/Pages/{{ $page['component'] }}.vue</strong> exists</li>
                <li>Run <code>npm run dev</code> or <code>npm run build</code> to rebuild assets</li>
                <li>Clear Laravel cache with <code>php artisan optimize:clear</code></li>
                <li>Check your Inertia route configuration</li>
            </ol>
            
            <div>
                <a href="/" class="btn">Return to Homepage</a>
                <a href="javascript:location.reload()" class="btn">Reload Page</a>
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
        
        // Console debug information
        console.error('Vite manifest error: Unable to locate file:', 'resources/js/Pages/{{ $page['component'] }}.vue');
        console.info('Check that the file exists and run: npm run dev');
    </script>
</body>
</html>