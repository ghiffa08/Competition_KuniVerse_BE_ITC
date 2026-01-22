<?php

namespace Modules\Tourism\Livewire\Frontend;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Modules\Tourism\Models\Tourism;

#[Layout('components.layouts.frontend')]
class Show extends Component
{
    public Tourism $tourism;

    public $bookingDate;
    public $bookingQuantity = 1;

    public function mount($slug)
    {
        $this->tourism = Tourism::where('slug', $slug)
            ->where('status', 1)
            ->firstOrFail();
            
        $this->bookingDate = now()->format('Y-m-d');
    }

    public function bookNow()
    {
        // Store booking details in session for the checkout page
        session([
            'booking_date' => $this->bookingDate,
            'booking_quantity' => $this->bookingQuantity,
        ]);

        return redirect()->route('frontend.booking.checkout', [
            'tourism' => $this->tourism->slug,
        ]);
    }

    public function render()
    {
        return view('tourism::livewire.frontend.show')
            ->title($this->tourism->name);
    }
}
