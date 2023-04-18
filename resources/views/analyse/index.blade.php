<x-auth-layout>
    <div class="mb-0">
        <label class="form-label">Basic example</label>
        <input class="form-control form-control-solid" placeholder="Pick date rage" id="kt_daterangepicker_1"/>
    </div>
    @push('footer')
        <script>
            $("#kt_daterangepicker_1").daterangepicker();
        </script>
    @endpush
</x-auth-layout>