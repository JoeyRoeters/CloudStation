<x-auth-layout>
    <div class="d-flex flex-column flex-row-fluid gap-3">
        <form class="d-flex flex-row gap-3" method="post" action="{{ route('analyse') }}">
            @csrf
            <div class="w-full">
                <label class="form-label">{{ __('Stations') }}</label>
                <select class="form-select" data-control="select2" name="station_ids[]" data-placeholder="Select an option" data-allow-clear="true" multiple="multiple" data-maximum-selection-length="5" data-close-on-select="false">
                    <option></option>
                    @foreach($locations as $location => $stations)
                        <optgroup label="{{ $location }}">
                            @foreach($stations as $station)
                                <option value="{{ $station->station_name }}" @selected(in_array($station->station_name, old('station_ids', $stationIds)))>
                                    {{ $station->name }} ({{ $station->station_name }})
                                </option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
                <div class="fv-plugins-message-container invalid-feedback">{{ $errors->first('station_ids*') }}</div>
            </div>
            <div class="w-300px">
                <label class="form-label">{{  __('Date Range') }}</label>
                <input class="form-control form-control-solid" name="range" placeholder="Pick date rage" id="date-range-picker"/>
                <div class="fv-plugins-message-container invalid-feedback">{{ $errors->first('range') }}</div>
            </div>
            <div class="mt-8">
                <x-buttons.submit label="search"/>
            </div>
        </form>
        @if($hasSelection)
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
        @else
            <p class="text-center py-12">{{ __('please select a station to view the weather data') }}</p>
        @endif
    </div>
    @include('share.chart-js')
</x-auth-layout>