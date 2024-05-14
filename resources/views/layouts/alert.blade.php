<?php
$status = session('status');
$notification = session('notification');
?>
@if($status)
    <div class="alert alert-{{ $status == 200 ? 'success' : 'danger' }}" role="alert">
        {{ $notification }}
    </div>
@endif
