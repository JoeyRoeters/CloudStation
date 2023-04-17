<x-guest-layout>
    <div class="text-center mb-11">
        <h1 class="text-dark fw-bolder mb-3">{{ __('Forgot password') }}</h1>
    </div>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <x-auth-session-status status="{{ session('status') }}"/>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="fv-row mb-8">
            <input type="text" placeholder="{{ __('Email') }}" name="email" autocomplete="off" value="{{  old('email') }}" class="form-control bg-transparent" />
            <div class="fv-plugins-message-container invalid-feedback">{{ $errors->first('email') }}</div>
        </div>
        <div class="d-grid mb-10">
            <x-buttons.submit label="{{ __('Email Password Reset Link') }}"/>
        </div>
    </form>
</x-guest-layout>
