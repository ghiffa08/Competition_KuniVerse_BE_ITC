<?php

namespace App\Livewire\Frontend\Booking;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Modules\Booking\Models\Booking;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.frontend')]
class MyTickets extends Component
{
    #[Title('Tiket Saya')]
    public function render()
    {
        $bookings = Booking::with('tourism')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('livewire.frontend.booking.my-tickets', [
            'bookings' => $bookings
        ]);
    }
}
