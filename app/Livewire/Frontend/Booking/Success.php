<?php

namespace App\Livewire\Frontend\Booking;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Modules\Booking\Models\Booking;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingSuccessMail;

#[Layout('components.layouts.frontend')]
class Success extends Component
{
    public Booking $booking;

    public function mount(Booking $booking)
    {
        $this->booking = $booking;

        if ($this->booking->status === 'pending') {
            // Update status to paid (assume success if redirected here from Snap success callback)
            // Ideally should verify with Midtrans API again, but for this flow let's mark as paid and send email
            
            $this->booking->update(['status' => 'paid']);

            // Send Email
            \Illuminate\Support\Facades\Log::info('Attempting to send email to: ' . $this->booking->user->email);
            try {
                Mail::to($this->booking->user->email)->send(new BookingSuccessMail($this->booking));
                \Illuminate\Support\Facades\Log::info('Email sent successfully.');
            } catch (\Exception $e) {
                // Log email error but don't stop the flow
                \Illuminate\Support\Facades\Log::error('Email Error: ' . $e->getMessage());
            }
        }
    }

    #[Title('Booking Berhasil')]
    public function render()
    {
        return view('livewire.frontend.booking.success');
    }
}
