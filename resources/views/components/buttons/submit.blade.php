@props(['label'])

<button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
    <span class="indicator-label">
        {{ $label }}
    </span>
    <span class="indicator-progress">
        Please wait...
        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
    </span>
</button>