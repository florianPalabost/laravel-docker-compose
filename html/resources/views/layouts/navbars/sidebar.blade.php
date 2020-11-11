<div class="bg-light border-right" id="sidebar-wrapper">
    <div class="sidebar-heading">LaraFlo </div>
    <div class="list-group list-group-flush">
        <a href="{{route('dashboard')}}" class="list-group-item list-group-item-action bg-light">Dashboard</a>
        <a href="{{route('user.animes.status', 'watch')}}" class="list-group-item list-group-item-action bg-light">Watched</a>
        <a href="{{route('user.animes.status', 'like')}}" class="list-group-item list-group-item-action bg-light">Liked</a>
        <a href="{{route('user.animes.status', 'want_to_watch')}}" class="list-group-item list-group-item-action bg-light">Wanted to watch</a>
    </div>
</div>
