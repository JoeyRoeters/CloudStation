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
    @push('footer')
        <script>
            const end = moment('{{ old('end', $end) }}')
            const start = moment('{{ old('start', $start) }}')
            const $element = $("#date-range-picker")

            function cb(start, end) {
                $element.html(start.format("yyyy-MM-DD") + " - " + end.format("yyyy-MM-DD"));
            }

            $element.daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    "Today": [moment(), moment()],
                    "Yesterday": [moment().subtract(1, "days"), moment().subtract(1, "days")],
                    "Last 7 Days": [moment().subtract(6, "days"), moment()],
                    "Last 30 Days": [moment().subtract(29, "days"), moment()],
                    "This Month": [moment().startOf("month"), moment().endOf("month")],
                    "Last Month": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")]
                },
                locale: {
                    format: 'yyyy-MM-DD'
                }
            }, cb);

            cb(start, end);

            am5.ready(function () {
                let roots = {}

                Object.keys({!! Js::from($labels) !!}).forEach((id) => {
                    roots[id] = am5.Root.new(id);
                })

                Object.entries(roots).forEach(([category, root]) => {
                    root.setThemes([
                        am5themes_Animated.new(root)
                    ]);

                    const chart = root.container.children.push(
                        am5xy.XYChart.new(root, {
                            paddingTop: 0,
                            wheelX: "panX",
                            wheelY: "zoomX",
                            layout: root.verticalLayout
                        })
                    );
                    const legend = chart.children.push(am5.Legend.new(root, {}));
                    const cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
                    const xAxis = chart.xAxes.push(
                        am5xy.DateAxis.new(root, {
                            baseInterval: {!! Js::from($interval) !!},
                            renderer: am5xy.AxisRendererX.new(root, {}),
                            tooltip: am5.Tooltip.new(root, {}),
                            tooltipDateFormat: "{{ $format }}",
                        })
                    );
                    const yAxis = chart.yAxes.push(
                        am5xy.ValueAxis.new(root, {
                            extraMax: 0.2,
                            extraMin: 0.2,
                            maxDeviation: 1,
                            renderer: am5xy.AxisRendererY.new(root, {}),
                        })
                    );
                    const scrollbar = chart.set("scrollbarX", am5xy.XYChartScrollbar.new(root, {
                        height: 60,
                        orientation: "horizontal",
                    }));

                    Object.entries({!! $values !!}).forEach(([name, station]) => {
                        const series = chart.series.push(
                            am5xy.LineSeries.new(root, {
                                name: name,
                                xAxis: xAxis,
                                yAxis: yAxis,
                                connect: false,
                                valueXField: "date",
                                valueYField: "value",
                                legendLabelText: "{name}: {valueY}",
                                legendRangeLabelText: "{name}",
                                tooltip: am5.Tooltip.new(root, {
                                    labelText: "{valueY}"
                                })
                            })
                        )

                        series.appear(1000)
                        series.data.setAll(station[category])
                        series.bullets.push(function() {
                            return am5.Bullet.new(root, {
                                sprite: am5.Circle.new(root, {
                                    radius: 5,
                                    fill: series.get("fill")
                                })
                            });
                        });
                    })

                    chart.appear(1000, 100);
                    cursor.lineY.set("visible", false);
                    legend.data.setAll(chart.series.values);
                    scrollbar.get("background").setAll({
                        fill: am5.color(0x000000),
                        fillOpacity: 0.1,
                        cornerRadiusTR: 5,
                        cornerRadiusBR: 5,
                        cornerRadiusTL: 5,
                        cornerRadiusBL: 5
                    });
                })
            });
        </script>
    @endpush
</x-auth-layout>