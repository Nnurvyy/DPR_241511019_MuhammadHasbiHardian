<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $user = $request->user();
        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        // Cek role untuk redirect
        if ($user->role === 'admin') {
            return redirect()->route('dashboard.admin')->with('status', 'password-updated');
        } elseif ($user->role === 'public') {
            return redirect()->route('dashboard.user')->with('status', 'password-updated');
        }

        return redirect()->route('dashboard')->with('status', 'password-updated');
    }

}
