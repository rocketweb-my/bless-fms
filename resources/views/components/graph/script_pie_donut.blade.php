
<script>
    var options =
    {
        chart: {
            type: '{!! $type !!}',
            height: '600',
            events: {
                dataPointSelection: function (event, chartContext, config) {
                    showModal{!! $id !!}(config.dataPointIndex);
                }
            },
            toolbar: {
                show: true,
                offsetX: 0,
                offsetY: 0,
                tools: {
                    download: true,
                    selection: true,
                    zoom: true,
                    zoomin: true,
                    zoomout: true,
                    pan: true,
                    reset: true | '<img src="/static/icons/reset.png" width="20">',
                    customIcons: []
                },
                export: {
                    csv: {
                        filename: undefined,
                        columnDelimiter: ',',
                        headerCategory: 'category',
                        headerValue: 'value',
                        dateFormatter(timestamp) {
                            return new Date(timestamp).toDateString()
                        }
                    }
                },
                autoSelected: 'zoom'
            },
            zoom: {
                enabled: true,
                type: 'x',
                autoScaleYaxis: false,
                zoomedArea: {
                    fill: {
                        color: '#90CAF9',
                        opacity: 0.4
                    },
                    stroke: {
                        color: '#0D47A1',
                        opacity: 0.4,
                        width: 1
                    }
                }
            },
        },
        series: {!! $dataset !!},
        dataLabels: {
            enabled: true
        },
        legend: {
            formatter: function(val, opts) {
                return val + " - " + opts.w.globals.series[opts.seriesIndex]
            },
            width: '170',
            height: '100%',
            fontSize: '11px',

        },
        labels: {!! $labels !!},
        title: {
        text: "{!! $title !!}"
        },
        subtitle: {
            text: '',
            align: ''
        },
        grid: {"show":false},
        }

        function showModal{!! $id !!}(data)
        {
            $('#modal{!! $id !!}'+data).modal('show');
            {{--$('#modal{!! $id !!}button'+data).show();--}}
        }

        var chart = new ApexCharts(document.querySelector("#{!! $id !!}"), options);
        chart.render();


</script>

