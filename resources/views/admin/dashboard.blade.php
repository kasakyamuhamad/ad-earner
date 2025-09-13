<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - AdEarn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/admin/dashboard">AdEarn Admin</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="/admin/dashboard">Dashboard</a>
                <a class="nav-link" href="/admin/users">Users</a>
                <a class="nav-link" href="/admin/ads">Ads</a>
                <a class="nav-link" href="/admin/withdrawals">Withdrawals</a>
                <a class="nav-link" href="/dashboard">User View</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-link btn btn-link">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1>Admin Dashboard</h1>
        
        <div class="row mt-4">
            <div class="col-md-3">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Users</h5>
                        <h3 class="card-text">{{ $stats['total_users'] ?? 0 }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Ads</h5>
                        <h3 class="card-text">{{ $stats['total_ads'] ?? 0 }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Pending Withdrawals</h5>
                        <h3 class="card-text">{{ $stats['pending_withdrawals'] ?? 0 }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-info mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Earnings</h5>
                        <h3 class="card-text">{{ number_format($stats['total_earnings'] ?? 0) }} UGX</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <h3>Quick Actions</h3>
            <div class="d-flex gap-2">
                <a href="/admin/users" class="btn btn-outline-primary">Manage Users</a>
                <a href="/admin/ads" class="btn btn-outline-success">Manage Ads</a>
                <a href="/admin/withdrawals" class="btn btn-outline-warning">Review Withdrawals</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>