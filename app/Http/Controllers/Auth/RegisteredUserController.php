<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Storage;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
{
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'description' => ['nullable', 'string', 'max:255'],
        'profile_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:5000'],
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'description' => $request->description,
    ]);

    // Lidando com o upload da imagem
    if ($request->hasFile('profile_image')) {
        $file = $request->file('profile_image');

        // Validar novamente o tipo MIME e a extensão (por precaução)
        if ($file->isValid() && in_array($file->getClientOriginalExtension(), ['jpeg', 'png', 'jpg', 'gif', 'svg'])) {
            $path = $file->store('profile_images', 'public');

            if ($path !== false) {
                $user->profile_image = $path;
                $user->save();
            } else {
                // Log ou tratamento de erro, se necessário
                // ...
            }
        }
    } else {
        // Se nenhum arquivo for enviado, atribua um caminho padrão para a imagem de perfil
        $defaultImageName = 'default-profile-image.png'; // Nome do arquivo da imagem padrão
        $defaultImagePath = public_path('img/' . $defaultImageName); // Caminho completo à pasta public

if (file_exists($defaultImagePath)) {
    $user->profile_image = 'img/' . $defaultImageName; // Caminho relativo à pasta public
    $user->save();
} else {
    // Adicione esta linha para depurar
    dd('Imagem padrão não encontrada:', $defaultImagePath);
    // Ou defina um caminho alternativo ou lide com o erro conforme necessário
    // ...
}

    }

    // Autentique o usuário
    Auth::login($user);

    event(new Registered($user));

    return redirect(RouteServiceProvider::HOME);
}
public function update(Request $request): RedirectResponse
{
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
        'description' => ['nullable', 'string', 'max:255'],
        'profile_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:5000'],
    ]);

    $user = auth()->user();

    // Atualizar outros campos
    $user->name = $request->name;
    $user->email = $request->email;
    $user->description = $request->description;

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

    return redirect(RouteServiceProvider::HOME)->with('status', 'profile-updated');
}



}
