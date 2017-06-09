<?php
$wi = 0;
$count = 0;
foreach ($dailyCond as $cond) {

	if ($count++ == 0) continue;

	$wTime = $cond['time'];
	$wSummary = $cond['summary'];
	$wIcon = $cond['icon'];
	$wTempHigh = round($cond['temperatureMax']);
	$wTempLow = round($cond['temperatureMin']);
	$wPrecipProb = $cond['precipProbability']*100;
	if (isset($cond['precipType'])) {
		$wPrecipType = $cond['precipType'];
	}
	$wClouds = $cond['cloudCover']*100;
	$wHumidity = $cond['humidity']*100;
	$wWindSpeed = round($cond['windSpeed']);
	$wSunRise = $cond['sunriseTime'];
	$wSunSet = $cond['sunsetTime'];

	echo '<div class="col-lg-4 col-md-6 col-sm-6">';
	echo '<div class="panel panel-default">';
	echo '<div class="panel-heading"><div class="text-warning"><strong>'.date("l, M jS", $wTime).'</strong></div></div>';
	echo '<div class="panel-body">';

	echo '<canvas class="'.$wIcon.'" width="40" height="80"></canvas>';
	echo '<strong>'.$wSummary.'</strong>';
	echo '<br>';
	echo '<div class="text-primary inline fs20"><b>'.$wTempHigh.'</b><i class="wi wi-degrees"></i> </div> &nbsp; <div class="text-info inline fs20"><b>'.$wTempLow.'</b><i class="wi wi-degrees"></i> </div>';
	echo '&nbsp; <i class="wi wi-umbrella"></i> '.$wPrecipProb.'% &nbsp;&nbsp; <i class="wi wi-cloudy"></i>'.$wClouds.'%';
	echo '<br>';
	echo '<small><i class="wi wi-sunrise"></i> '.date("g:i", $wSunRise).' &nbsp; <i class="wi wi-sunset"></i>'.date("g:i", $wSunSet).'</small>';

	echo "</div>";
	echo "</div>";
	echo "</div>";

	$wi++;
	if ($wi%3 == 0) echo '</div><div class="row">';
}
?>