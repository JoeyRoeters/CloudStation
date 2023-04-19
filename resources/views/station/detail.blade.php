<x-auth-layout>
    @if($station !== null)
        <div class="row">
            <div class="col-lg-6">
                <div class="card mt-5 mt-xl-10">
                    <div class="card-header cursor-pointer">
                        <div class="card-title m-0">
                            <h3 class="fw-bold m-0">Station Details</h3>
                        </div>

                    </div>
                    <!--begin::Card header-->

                    <!--begin::Card body-->
                    <div class="card-body p-9">
                        <!--begin::Row-->
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
                        <!--end::Input group-->
                        @if($nearestLocation)
                            <!--begin::Input group-->
                            <div class="row mb-7">
                                <!--begin::Label-->
                                <label class="col-lg-4 fw-bold">Nearest location</label>
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
                        @if($geoLocation)
                            <!--begin::Input group-->
                            <div class="row mb-7">
                                <!--begin::Label-->
                                <label class="col-lg-4 fw-bold">Geo location</label>
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

                        @if(!$geoLocation && !$nearestLocation)
                            <div class="row mb-10">
                                <label class="col-lg-4 fw-bold">No data available</label>
                            </div>
                        @endif
                    </div>
                    <!--end::Card body-->
                </div>
            </div>

            <div class="col-lg-6 mt-10 pt-10 d-flex justify-content-center">
                <div class="" style="width: 400px; height: 400px;" id="chartdiv"></div>
            </div>

        </div>
        @push('footer')
            <script>
                let chart = am4core.create("chartdiv", am4maps.MapChart);
                chart.geodata = am4geodata_worldLow;
                chart.projection = new am4maps.projections.Orthographic();
                chart.panBehavior = "rotateLongLat";

                // Grid
                let graticuleSeries = chart.series.push(new am4maps.GraticuleSeries());
                graticuleSeries.fitExtent = false;

                // Create map polygon series
                let polygonSeries = chart.series.push(new am4maps.MapPolygonSeries());
                polygonSeries.useGeodata = true;
                polygonSeries.calculateVisualCenter = true;

                let polygonTemplate = polygonSeries.mapPolygons.template;
                polygonTemplate.fill = chart.colors.getIndex(17);

                chart.backgroundSeries.mapPolygons.template.polygon.fill = chart.colors.getIndex(1);
                chart.backgroundSeries.mapPolygons.template.polygon.fillOpacity = 0.2;

                // Create series for circles
                let circleSeries = chart.series.push(new am4maps.MapPolygonSeries())
                let circleTemplate = circleSeries.mapPolygons.template;
                circleTemplate.fill = am4core.color('#FF0000');
                circleTemplate.strokeOpacity = 1;
                circleTemplate.fillOpacity = 1;

                polygonSeries.events.on("inited", function () {
                    let polygon = circleSeries.mapPolygons.create();
                    polygon.multiPolygon = am4maps.getCircle({{ $station->longitude }}, {{ $station->latitude }}, 0.5);
                });


            </script>
        @endpush
    @endif;
</x-auth-layout>
