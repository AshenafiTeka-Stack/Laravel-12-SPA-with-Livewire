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


    public $searchTerm = null;
    public $activePageNumber = 1;

    public $sortColumn = 'id';
    public $sortOrder = 'asc';

    public function sortBy($columnName)
    {
        if ($this->sortColumn === $columnName) {
            $this->sortOrder = $this->sortOrder === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortColumn = $columnName;
            $this->sortOrder = 'asc';
        }
    }

    public function fetchPosts()
    {
        return Post::where('title', 'like', '%' . $this->searchTerm . '%')
            ->orwhere('content', 'like', '%' . $this->searchTerm . '%')
            ->orderBy($this->sortColumn, $this->sortOrder)->paginate(5);
    }

    public function render()
    {
        $posts = $this->fetchPosts();


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

        $posts = $this->fetchPosts();

        if ($posts->isEmpty() && $this->activePageNumber > 1) {
            # If the current page is empty, go to the previous page
            $this->gotoPage($this->activePageNumber - 1);

        } else {

            // Reset the search term and active page number
            $this->gotoPage($this->activePageNumber);
        }

        // return $this->redirect('/posts', navigate: true);
    }

    /** Function: Track the active page from pagination **/
    public function updatingPage($pageNumber)
    {
        $this->activePageNumber = $pageNumber;
    }
}
