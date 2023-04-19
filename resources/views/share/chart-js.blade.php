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