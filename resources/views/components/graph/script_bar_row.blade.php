
<script>
    var options =
    {
        chart: {
            type: 'bar',
            events: {
                dataPointSelection: function (event, chartContext, config) {
                    console.log(config);
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
        colors: {!! $colors !!},

        series: [{
            name: 'Tickets',
            data: {!! $dataset !!}
        }],

        @if($type == 'bar')
        plotOptions: {
            bar: {
                horizontal: false,
                distributed: true,
            }
        },
        @elseif($type == 'row')
        plotOptions: {
            bar: {
                horizontal: true,
                distributed: true,
            }
        },
        @endif

        dataLabels: {
        enabled: true
        },
        title: {
            text: "{!! $title !!}"
        },
        subtitle: {
        text: '',
        align: ''
        },
        xaxis: {
            categories: {!! $labels !!},
            labels: {
                style: {
                    colors: {!! $colors !!},
                    fontSize: '12px'
                }
    },
        },

        grid: {"show":true},
        }

    function showModal{!! $id !!}(data)
    {
        $('#modal{!! $id !!}'+data).modal('show');
        {{--$('#modal{!! $id !!}button'+data).show();--}}

    }


        var chart = new ApexCharts(document.querySelector("#{!! $id !!}"), options);
        chart.render();

</script>
