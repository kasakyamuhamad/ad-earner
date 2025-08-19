<!-- resources/views/dashboard.blade.php -->
<div class="balance-card">
    <h3>Your Balance</h3>
    <p>{{ number_format($balance) }} Coins</p>
    <small>= {{ number_format($balance / 10) }} UGX</small>
</div>

<div class="withdrawal-form">
    <form action="{{ route('withdraw') }}" method="POST">
        @csrf
        <input type="number" name="amount" placeholder="Min 5000" min="5000">
        <input type="tel" name="phone" placeholder="+256..." pattern="\+256[0-9]{9}">
        <button type="submit">Withdraw</button>
    </form>
</div>

<div class="transaction-history">
    @foreach($withdrawals as $withdrawal)
    <div class="transaction">
        <span>{{ $withdrawal->created_at->format('d/m/Y') }}</span>
        <span>-{{ number_format($withdrawal->amount) }}</span>
        <span>{{ $withdrawal->status }}</span>
    </div>
    @endforeach
</div>