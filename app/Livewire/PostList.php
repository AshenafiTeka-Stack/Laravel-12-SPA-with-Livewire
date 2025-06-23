<?php

namespace App\Livewire;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Laravel\SerializableClosure\Serializers\Native;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Livewire\Attributes\Title;

class PostList extends Component
{
    use WithPagination, WithoutUrlPagination;


    #[Title('Post Listing ')]
    public function render()
    {
        $posts = Post::orderBy('id', 'DESC')->paginate(5);
        return view('livewire.post-list', compact('posts'));
    }

    public function deletePost(Post $post)
    {
        if ($post) {
            // Check if the post has a featured image and delete it from storage
            if (Storage::exists($post->featured_image)) {
                Storage::delete($post->featured_image);
            }
            $deleteResponse = $post->delete();

            if ($deleteResponse) {
                session()->flash('success', 'Post deleted successfully.');
            } else {
                session()->flash('error', 'Failed to delete the post.');
            }
        } else {
            session()->flash('error', 'Post not found.');
        }
        return $this->redirect('/posts', navigate: true);
    }
}
