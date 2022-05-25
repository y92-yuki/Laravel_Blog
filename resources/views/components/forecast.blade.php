<p class="weatherTime h5">{{ $forecast['date'] }}({{ $forecast['week'] }})現在:{{ $forecast['pref'] }}の天気</p>
<img src="weatherIcons/{{ $forecast['icon'] }}.svg" class="weatherIcon" style="width: 45px;">
<p class="description d-inline">{{ $forecast['description'] }}</p>
<img src="weatherIcons/thermometer.svg" class="tempIcon ml-3" style="width: 30px;">
<p class="tempMax d-inline h5 text-danger">{{ $forecast['temp_max'] }}</p>
<p class="tempMin d-inline h5 text-primary ml-3">{{ $forecast['temp_min'] }}</p>