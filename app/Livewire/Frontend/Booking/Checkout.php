<?php

namespace App\Livewire\Frontend\Booking;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Modules\Tourism\Models\Tourism;
use Modules\Booking\Models\Booking;
use Modules\Booking\Services\MidtransService;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.frontend')]
class Checkout extends Component
{
    public Tourism $tourism;
    public $date;
    public $quantity = 1;
    public $total_price;
    public $snapToken;
    public $bookingId;
    public $paymentUrl;

    public function mount(Tourism $tourism)
    {
        $this->tourism = $tourism;
        
        // Retrieve booking details from session or use defaults
        $this->date = session('booking_date', now()->format('Y-m-d'));
        $this->quantity = session('booking_quantity', 1);

        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        $this->total_price = $this->tourism->price * $this->quantity;
    }

    public function checkout()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Create Booking
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'tourism_id' => $this->tourism->id,
            'booking_date' => $this->date,
            'quantity' => $this->quantity,
            'total_price' => $this->total_price,
            'status' => 'pending',
            'created_by' => Auth::id(),
        ]);
        
        $this->bookingId = $booking->id;

        // Config Midtrans
        $midtrans = new MidtransService();
        
        $params = [
            'transaction_details' => [
                'order_id' => $booking->id . '-' . time(), // Unique Order ID
                'gross_amount' => (int) $booking->total_price,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->first_name,
                'last_name' => Auth::user()->last_name,
                'email' => Auth::user()->email,
            ],
            'item_details' => [
                [
                    'id' => $this->tourism->id,
                    'price' => (int) $this->tourism->price,
                    'quantity' => $this->quantity,
                    'name' => substr($this->tourism->name, 0, 50),
                ]
            ],
        ];

        try {
            // Use createTransaction to get both token and redirect_url
            $transaction = $midtrans->createTransaction($params);
            
            $this->snapToken = $transaction->token;
            $paymentUrl = $transaction->redirect_url;
            
            $booking->update([
                'snap_token' => $this->snapToken,
                'payment_url' => $paymentUrl,
                'status' => 'pending'
            ]);
            
            $this->paymentUrl = $paymentUrl;
            
            $this->dispatch('trigger-payment', 
                token: $this->snapToken, 
                bookingId: $this->bookingId, 
                paymentUrl: $paymentUrl
            );

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Midtrans Error: ' . $e->getMessage());
            $this->addError('midtrans', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }
    }

    #[Title('Checkout')]
    public function render()
    {
        return view('livewire.frontend.booking.checkout');
    }
}
