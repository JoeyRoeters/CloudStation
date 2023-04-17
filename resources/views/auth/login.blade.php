<x-guest-layout>
    <div class="text-center mb-11">
        <h1 class="text-dark fw-bolder mb-3">Log in</h1>
    </div>
    <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" method="post" action="{{ route('login') }}">
        @csrf
        <div class="fv-row mb-3">
            <input type="text" placeholder="{{ __('Email') }}" name="email" autocomplete="off" value="{{ old('email') }}" class="form-control bg-transparent" />
            <div class="fv-plugins-message-container invalid-feedback">{{ $errors->first('email') }}</div>
        </div>
        <div class="fv-row mb-3">
            <input type="password" placeholder="{{ __('Password') }}" name="password" autocomplete="off" class="form-control bg-transparent" />
            <div class="fv-plugins-message-container invalid-feedback">{{ $errors->first('password') }}</div>
        </div>
        <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
            <div></div>
            <a href="{{ route('password.email') }}" class="link-primary">Forgot your password?</a>
        </div>
        <div class="d-grid mb-10">
            <x-buttons.submit label="{{ __('Sign In') }}"/>
        </div>
    </form>
    <div class="text-gray-500 text-center fw-semibold fs-6">Don't have a account?
        <a href="" class="link-primary">Please contact us</a>
    </div>
</x-guest-layout>
