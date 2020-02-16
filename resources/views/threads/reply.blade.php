<div class="card">
    <div class="card-header">
        {{$reply->owner->name}}
        <a href="#">

        </a> said {{$reply->created_at->diffForHumans()}}...
    </div>
    <div class="card-body">
        {{$reply->body}}
    </div>
</div>
