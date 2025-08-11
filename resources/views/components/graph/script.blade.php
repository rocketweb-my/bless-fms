
<script>
    var options =
    {
        chart: {
            type: '{!! $type !!}',
            height: {!! $heigh !!}
        },
        colors: {!! $colors !!},

        series: [{
            data: {!! $dataset !!}
        }],
        dataLabels: {
        enabled: false
        },
        labels: {!! $labels !!},
        title: {
        text: "{!! $title !!}"
        },
        subtitle: {
        text: '',
        align: ''
        },
        xaxis: {
        categories: []
        },
        grid: {"show":false},
        }

        var chart = new ApexCharts(document.querySelector("#{!! $id !!}"), options);
        chart.render();

</script>
