<?php

namespace App\Livewire\Auth;

use App\Events\Frontend\UserRegistered;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Register')]
#[Layout('components.layouts.auth.kuniverse')]
class Register extends Component
{
    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    #[Livewire\Attributes\Url] 
    public string $role = 'user';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:user,merchant'],
        ]);

        $validated['password'] = $validated['password'];

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        $username = intval(config('app.initial_username')) + $user->id;
        $user->username = strval($username);
        $user->last_ip = optional(request())->getClientIp();
        $user->save();

        // Assign Role
        \Illuminate\Support\Facades\Log::info('[MANUAL CHECK] Registering Role requested: ' . $this->role);
        
        $user->assignRole($this->role);
        
        // Verify
        $user->refresh();
        \Illuminate\Support\Facades\Log::info('[MANUAL CHECK] User roles after assignment: ' . $user->getRoleNames());

        // event(new Registered($user));
        event(new UserRegistered($user));

        Auth::login($user);
        
        // Refresh permissions cache/user roles
        $user->refresh();

        if ($user->hasRole('merchant')) {
            $this->redirect(route('backend.dashboard', absolute: false), navigate: true);
        } else {
            $this->redirect(route('home', absolute: false), navigate: true);
        }
    }
}
