@php
    // Get the max / min index
    $max = 0;
    $min = $model->values ? $model->values[0] : 0;
@endphp

@foreach($model->values as $dta)
    @if($dta > $max)
        @php($max = $dta)
    @elseif($dta < $min)
        @php($min = $dta)
    @endif
@endforeach

@endforeach<script type="text/javascript">
    $(function () {
        var chart = new Highcharts.Map({
            chart: {
                renderTo:  "{{ $model->id }}",
                @include('charts::_partials.dimension.js')
            },
            @if($model->title)
                title: {
                    text:  "{{ $model->title }}"
                },
            @endif
            mapNavigation: {
                enabled: true,
                enableDoubleClickZoomTo: true
            },
            colorAxis: {
                min: {{ $min }},
                @if($model->colors and count($model->colors) >= 2)
                    minColor: "{{ $model->colors[0] }}",
                @endif

                max: {{ $max }},
                @if($model->colors and count($model->colors) >= 2)
                    maxColor: "{{ $model->colors[1] }}",
                @endif
            },
            series : [{
                data : [
                    @for ($i = 0; $i < count($model->values); $i++)
                        {
                            'code':  "{{ $model->labels[$i] }}",
                            'value': "{{ $model->values[$i] }}"
                        },
                    @endforeach
                ],
                mapData: Highcharts.maps['custom/world'],
                joinBy: ['iso-a2', 'code'],
                name: "{{ $model->element_label }}",
                states: {
                    hover: {
                        color: '#BADA55'
                    }
                },
            }]
        })
    });
</script>

@if(!$model->customId)
    @include('charts::_partials.container.div')
@endif