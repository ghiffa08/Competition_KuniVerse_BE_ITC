<?php

namespace App\Http\Controllers\Auth;

use App\Events\Frontend\UserRegistered;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProvider;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    /**
     * Redirects the user to the specified URL or the default home route.
     *
     * This function checks if the "redirectTo" parameter is present in the request and returns its value if true.
     * Otherwise, it returns the default home route.
     *
     * @return string The URL or route to redirect to.
     */
    public function redirectTo()
    {
        $redirectTo = request()->redirectTo;

        if ($redirectTo) {
            return $redirectTo;
        }

        return redirect()->route('home');
    }

    /**
     * Redirects the user to the specified provider for authentication.
     *
     * @param  string  $provider  The name of the provider to redirect to.
     * @return \Illuminate\Http\RedirectResponse The redirect response.
     */
    public function redirectToProvider($provider)
    {
        if (request()->has('role')) {
            $role = request('role');
            session(['social_login_role' => $role]);
            \Illuminate\Support\Facades\Log::info("[OAUTH CHECK] RedirectToProvider hit. Role param: " . $role . ". Session set.");
        } else {
            \Illuminate\Support\Facades\Log::info("[OAUTH CHECK] RedirectToProvider hit. No role param.");
        }
        
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Handles the callback from the provider.
     *
     * @param  string  $provider  The provider name.
     * @return \Illuminate\Http\RedirectResponse The redirect response.
     * @return RedirectResponse The redirect response.
     *
     * @throws Exception If an error occurs during the process.
     */
    public function handleProviderCallback($provider)
    {
        try {
            $user = Socialite::driver($provider)->stateless()->user();
            
            $role = session('social_login_role', 'user'); // Default to user if not set
            \Illuminate\Support\Facades\Log::info("[OAUTH CHECK] Callback hit. Role from session: " . $role);

            $authUser = $this->findOrCreateUser($user, $provider, $role);

            Auth::login($authUser, true);
            
            // Clear session
            session()->forget('social_login_role');
            
            if ($authUser->hasRole('merchant')) {
                \Illuminate\Support\Facades\Log::info("[OAUTH CHECK] Redirecting to Merchant Dashboard");
                return redirect()->route('merchant.dashboard');
            } else {
                \Illuminate\Support\Facades\Log::info("[OAUTH CHECK] Redirecting to Home. User Roles: " . $authUser->getRoleNames());
            }

        } catch (Exception $e) {
            Log::error("Social Login Error ($provider): " . $e->getMessage());
            return redirect('/login')->with('error', 'Login failed: ' . $e->getMessage());
        }

        return redirect()->intended(route('home', absolute: false));
    }

    /**
     * Splits a name into first and last name.
     *
     * @param  string  $name  The name to be split.
     * @return array An array containing the first name and last name.
     */
    public function split_name($name)
    {
        $name = trim($name);

        $last_name = strpos($name, ' ') === false ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
        $first_name = trim(preg_replace('#'.$last_name.'#', '', $name));

        return [$first_name, $last_name];
    }

    /**
     * Finds or creates a user based on the social user and provider.
     *
     * @param  object  $socialUser  The social user object.
     * @param  string  $provider  The provider name.
     * @return object The created or existing user object.
     */
    private function findOrCreateUser($socialUser, $provider, $role = 'user')
    {
        if ($authUser = UserProvider::where('provider_id', $socialUser->getId())->first()) {
            return User::findOrFail($authUser->user->id);
        }
        if ($authUser = User::where('email', $socialUser->getEmail())->first()) {
            UserProvider::create([
                'user_id' => $authUser->id,
                'provider_id' => $socialUser->getId(),
                'avatar' => $socialUser->getAvatar(),
                'provider' => $provider,
            ]);

            return $authUser;
        }
        $name = $socialUser->getName();

        $name_parts = $this->split_name($name);
        $first_name = $name_parts[0];
        $last_name = $name_parts[1];
        $email = $socialUser->getEmail();

        if ($email === '') {
            Log::error('Social Login does not have email!');

            flash('Email address is required!')->error()->important();

            return redirect()->intended(route('home', absolute: false));
        }

        $user = User::create([
            'first_name' => $first_name,
            'last_name' => $last_name,
            'name' => $name,
            'email' => $email,
            'password' => bcrypt(str()->random(20)),
        ]);

        // Generate Username
        $username = intval(config('app.initial_username', 10000)) + $user->id;
        $user->username = strval($username);
        $user->save();

        $media = $user->addMediaFromUrl($socialUser->getAvatar())->toMediaCollection('users');
        $user->avatar = $media->getUrl();
        $user->save();

        // Assign Role
        $user->assignRole($role);
        $user->refresh();

        event(new UserRegistered($user));

        UserProvider::create([
            'user_id' => $user->id,
            'provider_id' => $socialUser->getId(),
            'avatar' => $socialUser->getAvatar(),
            'provider' => $provider,
        ]);

        return $user;
    }
}
