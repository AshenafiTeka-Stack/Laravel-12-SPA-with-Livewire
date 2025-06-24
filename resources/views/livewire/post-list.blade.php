<div class="container my-3 ">
    <div class="row border-bottom py-2">
        <div class="col-xl-11">
            <h4 class="text-center fw-bold">SPA CRUD App With LiveWire-3</h4>
        </div>

        <div class="col-xl-1">
            <a wire:navigate href="{{ route('posts.create') }}" class="btn btn-primary btn-sm">Add Post</a>
        </div>
    </div>


    {{-- Alert Componenet --}}
    <div class="my-3">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                {{ session('success') }}
            </div>
        @elseif (session('error'))
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                {{ session('error') }}
            </div>
        @endif
    </div>

    {{-- Table post listing --}}
    <div class="card ">
        <div class="card-body mt-4 table-responsive shadow">

            {{-- Search Blog Post --}}
            <div class="my-3 col-xl-4 ms-auto">
                <input type="text" class="form-control" placeholder="Search Blog Post"
                    wire:model.live.debounce="searchTerm" />
            </div>



            <table class="table table-striped ">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Featured Image
                            <span wire:click="sortBy('featured_image')">
                                @if ($sortColumn === 'featured_image')
                                    @if ($sortOrder === 'asc')
                                        <i class="fa-solid fa-sort-up"></i>
                                    @else
                                        <i class="fa-solid fa-sort-down"></i>
                                    @endif
                                @else
                                    <i class="fa-solid fa-sort"></i>
                                @endif
                            </span>
                        </th>
                        <th>Title <span wire:click="sortBy('title')">
                            @if ($sortColumn === 'title')
                                    @if ($sortOrder === 'asc')
                                        <i class="fa-solid fa-sort-up"></i>
                                    @else
                                        <i class="fa-solid fa-sort-down"></i>
                                    @endif
                                @else
                                    <i class="fa-solid fa-sort"></i>
                                @endif
                        </span>
                    </th>
                        <th>Content <span wire:click="sortBy('content')">
                            @if ($sortColumn === 'content')
                                    @if ($sortOrder === 'asc')
                                        <i class="fa-solid fa-sort-up"></i>
                                    @else
                                        <i class="fa-solid fa-sort-down"></i>
                                    @endif
                                @else
                                    <i class="fa-solid fa-sort"></i>
                                @endif
                        </span>
                    </th>
                        <th>Date <span wire:click="sortBy('created_at')">
                            @if ($sortColumn === 'created_at')
                                    @if ($sortOrder === 'asc')
                                        <i class="fa-solid fa-sort-up"></i>
                                    @else
                                        <i class="fa-solid fa-sort-down"></i>
                                    @endif
                                @else
                                    <i class="fa-solid fa-sort"></i>
                                @endif
                        </span>
                    </th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($posts as $post)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><a wire:navigate href="{{ route('posts.view', $post->id) }}"><img
                                        src="{{ Storage::url($post->featured_image) }}" class="img-fluid"
                                        width="100px" /></a></td>
                            <td><a class="text-decoration-none" wire:navigate href="{{ route('posts.view', $post->id) }}">
                                    {{ $post->title }} </a> </td>
                            <td>{{ $post->content }}</td>
                            <td>
                                <p>
                                    <small>
                                        <strong>Posted:</strong>
                                        {{ \Carbon\Carbon::parse($post->created_at)->diffForHumans() }}<br>
                                        <strong>Updated:</strong>
                                        {{ \Carbon\Carbon::parse($post->updated_at)->diffForHumans() }}
                                    </small>
                                </p>
                            </td>
                            <td>
                                <a href="{{ route('posts.edit', $post->id) }}" wire:navigate
                                    class="btn btn-success btn-sm">Edit</a>
                                <button wire:confirm="Are you sure, you want to delete?"
                                    wire:click="deletePost({{ $post->id }})" type="button"
                                    class="btn btn-danger btn-sm">Delete</button>
                            </td>

                        </tr>
                    @empty

                    @endforelse
                </tbody>
            </table>
            {{ $posts->links() }}
        </div>

    </div>
</div>