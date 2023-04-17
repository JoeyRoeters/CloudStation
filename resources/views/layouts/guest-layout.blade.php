<x-app-layout>
    <style>body { background-image: url('{{ asset("assets/media/auth/bg9.jpg") }}'); } [data-theme="dark"] body { background-image: url('assets/media/auth/bg4-dark.jpg'); }</style>
    <div class="d-flex flex-column flex-column-fluid flex-lg-row">
        <div class="d-flex flex-center w-lg-50 pt-15 pt-lg-0 px-10">
            <div class="d-flex flex-center flex-lg-start flex-column">
                <h1 class="text-white fw-bolder fs-3x">
                    CloudStation
                </h1>
                <h2 class="text-white fw-normal m-0">Connecting you to the worlds weather</h2>
            </div>
        </div>
        <div class="d-flex flex-center w-lg-50 p-10">
            <div class="card rounded-3 w-md-550px">
                <div class="card-body p-10 p-lg-20">
                   {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
