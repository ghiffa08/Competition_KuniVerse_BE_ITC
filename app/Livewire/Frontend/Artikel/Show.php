<?php

namespace App\Livewire\Frontend\Artikel;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Modules\Post\Models\Post;

#[Layout('components.layouts.frontend')]
class Show extends Component
{
    public Post $post;

    public function mount($slug)
    {
        $this->post = Post::where('slug', $slug)
            ->where('status', '1') // Published
            ->firstOrFail();
    }

    #[Title]
    public function title()
    {
        return $this->post->name;
    }

    public function render()
    {
        $relatedPosts = Post::where('status', '1')
            ->where('id', '!=', $this->post->id)
            ->where('category_id', $this->post->category_id)
            ->latest()
            ->take(3)
            ->get();

        return view('livewire.frontend.artikel.show', [
            'relatedPosts' => $relatedPosts,
        ]);
    }
}
