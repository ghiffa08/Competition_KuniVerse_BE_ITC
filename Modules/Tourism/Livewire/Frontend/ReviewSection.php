<?php

namespace Modules\Tourism\Livewire\Frontend;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Tourism\Models\Tourism;
use Modules\Tourism\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewSection extends Component
{
    use WithPagination;

    public $tourismId;
    public $rating = 5;
    public $review = '';
    
    protected $rules = [
        'rating' => 'required|integer|min:1|max:5',
        'review' => 'required|string|min:5|max:500',
    ];

    public function mount(Tourism $tourism)
    {
        $this->tourismId = $tourism->id;
    }

    public function submit()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $this->validate();

        // Optional: Check if user already reviewed
        // if (Review::where('tourism_id', $this->tourismId)->where('user_id', Auth::id())->exists()) {
        //     $this->addError('check', 'You have already reviewed this place.');
        //     return;
        // }

        Review::create([
            'tourism_id' => $this->tourismId,
            'user_id' => Auth::id(),
            'rating' => $this->rating,
            'review' => $this->review,
        ]);

        $this->updateAvgRating();

        $this->reset(['rating', 'review']);
        session()->flash('success', 'Review submitted successfully!');
    }

    protected function updateAvgRating()
    {
        $tourism = Tourism::find($this->tourismId);
        $avg = $tourism->reviews()->avg('rating');
        $tourism->update(['rating' => round($avg, 1)]);
    }

    public function render()
    {
        $reviews = Review::where('tourism_id', $this->tourismId)
            ->with('user')
            ->latest()
            ->paginate(5);

        return view('tourism::livewire.frontend.review-section', [
            'reviews' => $reviews
        ]);
    }
}
