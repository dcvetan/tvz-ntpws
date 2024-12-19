<?php
$api_key = "8c14803971b5088b5c5c6470951736ee";
$city = "Zagreb";
$country = "HR";

$url = "http://api.openweathermap.org/data/2.5/weather?q={$city},{$country}&appid={$api_key}&units=metric";
$weather_data = @file_get_contents($url);
$weather = json_decode($weather_data, true);

print '
<main>
        <h1>Weather Forecast</h1>
        <h2>Stay Updated with the Latest Weather News</h2>
        <p>Welcome to our weather forecast page. Here you will find the latest updates on weather conditions in your area.</p>
        <p>Our team of meteorologists provides accurate and timely weather information to help you plan your day.</p>';

if ($weather) {
    print '
        <div class="weather-widget">
            <h3>Current Weather in ' . htmlspecialchars($city) . ' (OpenWeatherAPI)</h3>
            <div class="weather-info">
                <img src="http://openweathermap.org/img/w/' . $weather['weather'][0]['icon'] . '.png" 
                     alt="' . htmlspecialchars($weather['weather'][0]['description']) . '">
                <div class="weather-details">
                    <p class="temp">' . round($weather['main']['temp']) . '°C</p>
                    <p class="desc">' . ucfirst($weather['weather'][0]['description']) . '</p>
                    <p class="extra">Humidity: ' . $weather['main']['humidity'] . '%</p>
                    <p class="extra">Wind: ' . round($weather['wind']['speed']) . ' m/s</p>
                </div>
            </div>
        </div>';
}

print '
        <p>Stay safe and informed with our comprehensive weather reports and alerts.</p>
        <figure>
            <img src="img/sun_and_clouds.jpg" alt="Weather Image">
            <figcaption>A beautiful weather scene</figcaption>
        </figure>
</main>';
?>