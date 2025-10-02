<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>


    <form method="POST" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('PUT')

        {{-- Username --}}
                        <div>
                            <x-input-label for="username" :value="__('Username')" />
                            <x-text-input id="username" name="username" type="text"
                                class="mt-1 block w-full"
                                :value="old('username', $user->username)" required autofocus autocomplete="username" />
                            <x-input-error class="mt-2" :messages="$errors->get('username')" />
                        </div>

                        {{-- Full Name --}}
                        <div>
                            <x-input-label for="full_name" :value="__('Full Name')" />
                            <x-text-input id="full_name" name="full_name" type="text"
                                class="mt-1 block w-full"
                                :value="old('full_name', $user->full_name)" required autocomplete="name" />
                            <x-input-error class="mt-2" :messages="$errors->get('full_name')" />
                        </div>


                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Save') }}</x-primary-button>
                        </div>
    </form>
</section>
