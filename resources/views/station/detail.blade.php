<x-auth-layout>
    <div class="d-flex flex-col gap-8">
        <div class="card card-flush">
            <div class="card-header cursor-pointer">
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">Station details</h3>
                </div>

            </div>
            <!--begin::Card header-->

            <!--begin::Card body-->
            <div class="card-body d-flex">
                <!--begin::Row-->
                <div class="flex-1">
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="fw-bold">Station</label>
                        <!--end::Label-->

                    </div>
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Name</label>
                        <!--end::Label-->

                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800">{{ $station->name }}</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->

                    <!--begin::Input group-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Longitude</label>
                        <!--end::Label-->

                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <span class="fw-semibold text-gray-800 fs-6">{{ $station->longitude }}</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="row mb-10">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Latitude</label>
                        <!--end::Label-->

                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-semibold text-gray-800 fs-6">{{ $station->latitude }}</span>
                        </div>
                        <!--end::Col-->
                    </div>
                </div>
                <div class="flex-1">
                    @if($geoLocation)
                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="fw-bold">Geo location</label>
                            <!--end::Label-->

                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-semibold text-muted">Country code</label>
                            <!--end::Label-->

                            <!--begin::Col-->
                            <div class="col-lg-8">
                            <span
                                class="fw-semibold text-gray-800 fs-6">{!! $geoLocation->country_code !== '' ? $geoLocation->country_code : '<span class="text-muted">Unavailable</span>' !!}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-semibold text-muted">State</label>
                            <!--end::Label-->

                            <!--begin::Col-->
                            <div class="col-lg-8">
                            <span
                                class="fw-semibold text-gray-800 fs-6">{!! $geoLocation->state !== '' ? $geoLocation->state : '<span class="text-muted">Unavailable</span>' !!}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-semibold text-muted">Municipality</label>
                            <!--end::Label-->

                            <!--begin::Col-->
                            <div class="col-lg-8">
                            <span
                                class="fw-semibold text-gray-800 fs-6">{!! $geoLocation->municipality !== '' ? $geoLocation->municipality : '<span class="text-muted">Unavailable</span>' !!}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-10">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-semibold text-muted">City / town</label>
                            <!--end::Label-->

                            <!--begin::Col-->
                            <div class="col-lg-8">
                            <span
                                class="fw-semibold text-gray-800 fs-6">{!! $geoLocation->hamlet !== '' ? $geoLocation->hamlet : '<span class="text-muted">Unavailable</span>' !!}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->
                    @endif
                </div>
                <div class="flex-1">
                    <!--end::Input group-->
                    @if($nearestLocation)
                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="fw-bold">Nearest location</label>
                            <!--end::Label-->

                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-semibold text-muted">Country code</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                            <span
                                class="fw-semibold text-gray-800 fs-6">{!! $nearestLocation->country_code !== '' ? $nearestLocation->country_code : '<span class="text-muted">Unavailable</span>' !!}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-semibold text-muted">State</label>
                            <!--end::Label-->

                            <!--begin::Col-->
                            <div class="col-lg-8">
                            <span
                                class="fw-semibold text-gray-800 fs-6">{!! $nearestLocation->administrative_region1 !== '' ? $nearestLocation->administrative_region1 : '<span class="text-muted">Unavailable</span>' !!}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-semibold text-muted">Municipality</label>
                            <!--end::Label-->

                            <!--begin::Col-->
                            <div class="col-lg-8">
                            <span
                                class="fw-semibold text-gray-800 fs-6">{!! $nearestLocation->administrative_region2 !== '' ? $nearestLocation->administrative_region2 : '<span class="text-muted">Unavailable</span>' !!}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-10">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-semibold text-muted">City / town</label>
                            <!--end::Label-->

                            <!--begin::Col-->
                            <div class="col-lg-8">
                            <span
                                class="fw-semibold text-gray-800 fs-6">{!! $nearestLocation->name !== '' ? $nearestLocation->name : '<span class="text-muted">Unavailable</span>' !!}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->
                    @endif
                </div>

            </div>
            <!--end::Card body-->
        </div>
        <div class="card card-flush">
            <div class="card-header cursor-pointer">
                <div class="card-title m-0">
                    <h3 class="fw-bold my-10">{{ __('Measurements') }}</h3>
                </div>

            </div>
            <!--begin::Card header-->

            <!--begin::Card body-->
            <div class="card-body d-flex">
                <div class="d-flex flex-column flex-row-fluid gap-3">
                    <form class="d-flex flex-row gap-3" method="post" action="{{ route('station.store', $station->id) }}">
                        @csrf
                        <div class="w-300px">
                            <label class="form-label">{{  __('Date Range') }}</label>
                            <input class="form-control form-control-solid" name="range" placeholder="Pick date rage"
                                   id="date-range-picker"/>
                            <div class="fv-plugins-message-container invalid-feedback">{{ $errors->first('range') }}</div>
                        </div>
                        <div class="mt-[27px]">
                            <x-buttons.submit label="search"/>
                        </div>
                    </form>
                    @foreach($labels as $id => $label)
                        <div class="card card-flush text-bg-light">
                            <div class="card-header">
                                <h3 class="card-title">{{ $label }}</h3>
                            </div>
                            <div class="card-body pt-0">
                                <div id="{{ $id }}" style="height: 400px;"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @include('share.chart-js')
</x-auth-layout>
