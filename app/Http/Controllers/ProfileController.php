<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Atualizar as informações do perfil, exceto a imagem
        $user->fill($request->except('profile_image'));

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        // Lidar com a atualização da imagem
        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');

            // Validar novamente o tipo MIME e a extensão (por precaução)
            if ($file->isValid() && in_array($file->getClientOriginalExtension(), ['jpeg', 'png', 'jpg', 'gif', 'svg'])) {
                $path = $file->store('profile_images', 'public');

                if ($path !== false) {
                    // Excluir a imagem anterior, se existir
                    if ($user->profile_image) {
                        Storage::disk('public')->delete($user->profile_image);
                    }

                    $user->profile_image = $path;
                } else {
                    // Log ou tratamento de erro, se necessário
                    // ...
                }
            }
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
