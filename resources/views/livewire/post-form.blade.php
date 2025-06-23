<div class="container pt-5">

    <div class="row">
        <div class="col-8 m-auto">

            <form wire:submit="savePost">
                <div class="card shadow border-1">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-xl-6">
                                <h5 class="fw-bold ">{{$isView ? 'View' : 'Create' }} Post</h5>
                            </div>
                            <div class="col-xl-6 text-end">
                                <a wire:navigate href="{{ route('posts') }}" class="btn btn-primary btn-sm ">Back to
                                    Posts</a>
                            </div>
                        </div>

                    </div>

                    <div class="card-body">

                        {{-- Post Title --}}
                        <div class="form-group mb-2">
                            <label for="title">Title<span class="text-danger">*</span></label>
                            <input type="text" {{ $isView ? 'disabled' : '' }} wire:model="title" class="form-control"
                                id="title" placeholder="Enter Post Title" />

                            @error('title')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Post Content --}}
                        <div class="form-group mb-4">
                            <label for="content">Content<span class="text-danger">*</span></label>
                            <textarea class="form-control" {{ $isView ? 'disabled' : '' }} wire:model="content"
                                id="content" placeholder="Enter Post Content" rows="5"></textarea>

                            @error('content')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- View Featured Image --}}
                        @if ($post)
                        <label class="my-2">Uploaded Featured Image</label>
                            <div class="my-2">
                                <img src="{{ Storage::url($post->featured_image) }}" class="img-fluid" width="500px"/>
                            </div>
                        @endif

                        {{-- Post Featured Image --}}
                        @if (!$isView)
                            <div class="form-group mb-2">
                                <label for="featuredImage">Featured Image<span class="text-danger">*</span></label>
                                <input type="file" wire:model="featuredImage" class="form-control" id="featuredImage" />

                                {{-- preview Image --}}
                                @if ($featuredImage)
                                    <div class="my-2">
                                        <img src="{{ $featuredImage->temporaryUrl() }}" class="img-fluid mt-2"
                                            style="max-height: 200px; max-width: 100%;" />
                                    </div>
                                @endif

                                @error('featuredImage')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                            </div>
                        @endif
                    </div>


                    {{-- Footer --}}
                    @if (!$isView)
                        <div class="card-footer">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary ">Save</button>
                            </div>
                        </div>
                    @endif
                </div>
            </form>
        </div>
    </div>

</div>