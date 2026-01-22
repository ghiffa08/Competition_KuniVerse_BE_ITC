<?php

namespace App\Livewire\Frontend\Artikel;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Post\Models\Post;

#[Layout('components.layouts.frontend')]
#[Title('Artikel')]
class Index extends Component
{
    use WithPagination;

    public function render()
    {
        $posts = Post::with(['category', 'tags'])
            ->where('status', '1') // Assuming 1 is published
            ->latest()
            ->paginate(9);

        // Get the latest post for the Hero section, distinct from the list if desired,
        // or just use the first item of the paginated list in the view.
        // For now, let's just pass the posts.

        return view('livewire.frontend.artikel.index', [
            'posts' => $posts,
        ]);
    }
}
