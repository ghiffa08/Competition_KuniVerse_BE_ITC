<?php

namespace Modules\Tourism\Livewire\Frontend;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Tourism\Models\Tourism;

#[Layout('components.layouts.frontend')]
class Index extends Component
{
    use WithPagination;

    public $search = '';

    public $category = '';

    public $location = '';

    #[Title('Wisata - Kuniverse')]
    public function render()
    {
        $tourisms = Tourism::where('status', 1)
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('intro', 'like', '%'.$this->search.'%');
            })
            ->latest()
            ->paginate(9);

        return view('tourism::livewire.frontend.index', [
            'tourisms' => $tourisms,
        ]);
    }
}
