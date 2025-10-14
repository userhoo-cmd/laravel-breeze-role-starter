@php
use Illuminate\Support\Facades\Auth;
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg p-6">

            <!-- Success message -->
            @if (session('status') === 'profile-updated')
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ __('Profile updated successfully.') }}
                </div>
            @endif

            <!-- Profile Update Form -->
            <form method="POST"
                  action="{{ isset($user->id) && Auth::user()->hasRole('admin') ? route('profile.update.user', $user->id) : route('profile.update') }}"
                  enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <!-- First Name -->
                <div>
                    <x-input-label for="first_name" :value="__('First Name')" />
                    <x-text-input id="first_name" class="block mt-1 w-full" type="text"
                        name="first_name" :value="old('first_name', $user->first_name)" required autofocus />
                    <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                </div>

                <!-- Last Name -->
                <div class="mt-4">
                    <x-input-label for="last_name" :value="__('Last Name')" />
                    <x-text-input id="last_name" class="block mt-1 w-full" type="text"
                        name="last_name" :value="old('last_name', $user->last_name)" required />
                    <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                </div>

                <!-- Email -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email"
                        name="email" :value="old('email', $user->email)" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password (optional) -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('New Password')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password"
                        name="password" autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    <p class="text-sm text-gray-500 mt-1">Leave blank to keep current password.</p>
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirm New Password')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                        name="password_confirmation" autocomplete="new-password" />
                </div>

                <!-- Avatar Upload with Live Preview -->
                <div class="mt-6">
                    <x-input-label :value="__('Avatar')" />
                    <div class="mb-2">
                        <img id="avatarPreview"
                             src="{{ $user->avatar ? asset('storage/avatars/' . $user->avatar) : asset('images/default-avatar.png') }}"
                             alt="Avatar"
                             class="w-24 h-24 rounded-full object-cover border">
                    </div>

                    <input id="avatarInput" type="file" name="avatar" accept="image/*"
                           class="block w-full text-sm text-gray-500
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-full file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-blue-50 file:text-blue-700
                                  hover:file:bg-blue-100" />
                    <x-input-error :messages="$errors->get('avatar')" class="mt-2" />
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-end mt-6">
                    <x-primary-button class="ml-4">
                        {{ __('Save Changes') }}
                    </x-primary-button>
                </div>
            </form>

            <!-- Account Deletion (self only) -->
            @if(Auth::id() === $user->id)
                <hr class="my-6">
                <form method="POST" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('DELETE')

                    <div>
                        <x-input-label for="password" :value="__('Confirm Password to Delete Account')" />
                        <x-text-input id="password" class="block mt-1 w-full" type="password"
                            name="password" required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-danger-button class="ml-4"
                            onclick="return confirm('Are you sure? This action cannot be undone.')">
                            {{ __('Delete Account') }}
                        </x-danger-button>
                    </div>
                </form>
            @endif

        </div>
    </div>

    <!-- Live Avatar Preview Script -->
    <script>
        const avatarInput = document.getElementById('avatarInput');
        const avatarPreview = document.getElementById('avatarPreview');
        const navbarAvatar = document.getElementById('navbarAvatar'); // for navbar sync

        if (avatarInput) {
            avatarInput.addEventListener('change', (event) => {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = e => {
                        avatarPreview.src = e.target.result;
                        if (navbarAvatar) navbarAvatar.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    </script>
</x-app-layout>
