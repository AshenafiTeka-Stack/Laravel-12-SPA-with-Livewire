<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;


class PostForm extends Component
{
    use WithFileUploads;

    #[Title('Add Post ')]
    public $post = null;
    public $isView = false;

    #[Validate('required', message: 'The post title is required.')]
    #[Validate('max:255', message: 'The post title must be a maximum length of 255 characters.')]
    public $title;

    #[Validate('required', message: 'The post content is required.')]
    #[Validate('min:10', message: 'The post content must be a minimum length of 10 characters.')]
    public $content;


    public $featuredImage;

    public function mount(Post $post)
    {
        $this->isView = request()->routeIs('posts.view');
        if ($post->id) {
            $this->post = $post;
            $this->title = $post->title;
            $this->content = $post->content;
        }
    }
    public function savePost()
    {

        $this->validate();

        $rules = [
            'featuredImage' => $this->post && $this->post->featured_image ? 'nullable|image|mimes:jpg,jpeg,png,svg,bmp,webp,gif|max:2048' : 'required|image|mimes:jpg,jpeg,png,svg,bmp,webp,gif|max:2048',
        ];

        $messages = [
            'featuredImage.required' => 'Featured Image is required.',
            'featuredImage.image' => 'Featured Image must be a valid image.',
            'featuredImage.mimes' => 'Featured Image must be jpg, jpeg, png, svg, bmp, webp, gif.',
            'featuredImage.max' => 'Featured Image must not be larger than 2MB.',
        ];

        $this->validate($rules, $messages);

        $imagePath = null;

        if ($this->featuredImage) {
            $imageName = time() . '.' . $this->featuredImage->extension();
            $imagePath = $this->featuredImage->storeAs('public/uploads', $imageName);
        }

        if ($this->post) {
            $this->post->title = $this->title;
            $this->post->content = $this->content;

            if ($imagePath) {
                $this->post->featured_image = $imagePath;
            }


            #update functionality
            $updatePost = $this->post->save();

            if ($updatePost) {
                session()->flash('success', 'Post Updated successfully!');
            } else {
                session()->flash('error', 'Failed to Update post. Please try again');
            }
        } else {
            $post = Post::create([
                'title' => $this->title,
                'content' => $this->content,
                'featured_image' => $imagePath,
            ]);

            if ($post) {
                session()->flash('success', 'Post created successfully!');
            } else {
                session()->flash('error', 'Failed to create post. Please try again');
            }

        }




        return $this->redirect('/posts', navigate: true);
    }

    public function render()
    {
        return view('livewire.post-form');
    }
}
