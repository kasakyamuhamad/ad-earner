<!-- resources/views/ads/index.blade.php -->
@foreach($ads as $ad)
<div class="ad-card">
    {!! $ad->embed_code !!}
    <button onclick="creditAd({{ $ad->id }})">Earn 10 Coins</button>
</div>
@endforeach

<script>
function creditAd(adId) {
    fetch(`/ads/${adId}/credit`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            alert('Coins credited!');
        }
    });
}
</script>