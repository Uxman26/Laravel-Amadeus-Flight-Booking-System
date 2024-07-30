<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/weather-icons/2.0.12/css/weather-icons.min.css"
    integrity="sha512-r/Gan7PMSRovDus++vDS2Ayutc/cSdl268u047n4z+k7GYuR7Hiw71FsT3QQxdKJBVHYttOJ6IGLnlM9IoMToQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    @import url('https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300');
    $txtGrey: #CDD5C1;
    $dawn-1: #123352;
    $dawn-2: #1d5372;
    $dawn-3: #3885a2;
    $morning-1: #8dcdba;
    $morning-2: #eee07a;
    $morning-3: #f0eebc;
    $afternoon-1: #e6756f;
    $afternoon-2: #ee8049;
    $afternoon-3: #facf62;
    $evening-1: #291c6b;
    $evening-2: #4a257d;
    $evening-3: #884186;
    $night-1: #111642;
    $night-2: #011548;

    *,
    *:before,
    *:after {
        box-sizing: inherit;
    }

    html {
        font-family: 'Open Sans Condensed', sans-serif;
        color: #CDD5C1;
    }

    body {
        margin: 0;
    }

    h2 {
        text-transform: uppercase;
        font-weight: lighter;
        font-size: 40px;
        margin: 0;
    }

    p {
        margin: 0;
    }

    .panels {
        min-height: 30vh;
        overflow: hidden;
        display: flex;
        font-size: 20px;
    }

    .panel {
        flex: 1;
        text-align: center;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        background: linear-gradient(#123352, #1d5372, #3885a2);
        border-right: 1px solid rgba(205, 213, 193, .3);
        cursor: pointer;
        transition:
            font-size 0.7s cubic-bezier(0.61, -0.19, 0.7, -0.11),
            flex 0.7s cubic-bezier(0.61, -0.19, 0.7, -0.11),
            background 0.3s;
    }

    .panel.open {
        flex: 4;
        font-size: 30px;
    }

    .panel>* {
        flex: 1 0 auto;
        margin: 0;
        width: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        transition: transform 0.5s;
    }

    .panel>*:first-child {
        justify-content: flex-end;
    }

    .panel>*:last-child {
        justify-content: flex-start;
    }

    .dawn {
        background: linear-gradient(#123352, #1d5372, #3885a2);
        color: white !important;
    }

    .morning {
        background: linear-gradient(#8dcdba, #eee07a, #f0eebc);
        color: #363c80;
    }

    .afternoon-1 {
        background: linear-gradient(#f0eebc, #e6756f, #ee8049);
        color: #fff;
    }

    .afternoon-2 {
        background: linear-gradient(#ee8049, #facf62, #e6756f);
        color: #fff;
    }

    .evening-1 {
        background: linear-gradient(#facf62, #e6756f, #884186);
        color: #fff;
    }

    .evening-2 {
        background: linear-gradient(#291c6b, #4a257d, #884186);
        color: #9eaf81;
    }

    .night-1 {
        background: linear-gradient(#884186, #111642, #011548);
        color: white !important;
    }

    .night-2 {
        background: linear-gradient(#111642, #1d5372, #123352);
        color: white !important;
    }

    .weather-icon i {
        font-family: 'weathericons';
        font-style: normal;
        font-weight: normal;
        line-height: 1;
        font-size: 40px;
        padding: 20px 0;
    }

    .weather-icon .icon-01d:before {
        content: '\f00d' !important;
        font-weight: 900;
    }

    .weather-icon .icon-01n:before {
        content: '\f02e' !important;
        font-weight: 900;
    }

    .weather-icon .icon-02d:before {
        content: '\f002' !important;
        font-weight: 900;
    }

    .weather-icon .icon-02n:before {
        content: '\f086' !important;
        font-weight: 900;
    }

    .weather-icon .icon-03d:before,
    .weather-icon .icon-03n:before {
        content: '\f041' !important;
        font-weight: 900;
    }

    .weather-icon .icon-04d:before,
    .weather-icon .icon-04n:before {
        content: '\f013' !important;
        font-weight: 900;
    }

    .weather-icon .icon-09d:before,
    .weather-icon .icon-09n:before {
        content: '\f017' !important;
        font-weight: 900;
    }

    .weather-icon .icon-10d:before {
        content: '\f009' !important;
        font-weight: 900;
    }

    .weather-icon .icon-10n:before {
        content: '\f029' !important;
        font-weight: 900;
    }

    .weather-icon .icon-11d:before,
    .weather-icon .icon-11n:before {
        content: '\f01d' !important;
        font-weight: 900;
    }

    .weather-icon .icon-13d:before,
    .weather-icon .icon-13n:before {
        content: '\f01d' !important;
        font-weight: 900;
    }

    .weather-icon .icon-50d:before,
    .weather-icon .icon-50n:before {
        content: '\f01b' !important;
        font-weight: 900;
    }
</style>
<div id="app">
    <div class="panels"></div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.38/moment-timezone-with-data.min.js"></script>

<script>
    $(document).ready(function() {
        const cities = {
            'Paris': {
                weatherId: 2988507,
                timeZone: 'Europe/Paris'
            },
            'Lahore': {
                weatherId: 1172451, // Replace with actual weather ID for Lahore
                timeZone: 'Asia/Karachi' // Assuming Lahore is in Pakistan's time zone
            },
            'New Delhi': {
                weatherId: 1261481, // Replace with actual weather ID for New Delhi
                timeZone: 'Asia/Kolkata'
            },
            'Dhaka': {
                weatherId: 1273043, // Replace with actual weather ID for Dhaka
                timeZone: 'Asia/Dhaka'
            }
        };

        const appId = 'c5baa00af2bfbc51b5a8bff68a069bb0';

        function setGradient(currentHour, panel) {
            if (currentHour < 3) {
                panel.addClass('night-2');
            } else if (currentHour < 6) {
                panel.addClass('dawn');
            } else if (currentHour < 9) {
                panel.addClass('morning');
            } else if (currentHour < 12) {
                panel.addClass('afternoon-1');
            } else if (currentHour < 15) {
                panel.addClass('afternoon-2');
            } else if (currentHour < 18) {
                panel.addClass('evening-1');
            } else if (currentHour < 21) {
                panel.addClass('evening-2');
            } else if (currentHour < 24) {
                panel.addClass('night-1');
            }
        }

        function getWeatherInfo(id, panel) {
            return $.getJSON(
                    `https://api.openweathermap.org/data/2.5/weather?id=${id}&units=metric&appid=${appId}`)
                .then(res => {
                    const weatherInfo = {
                        temp: res.main.temp,
                        desc: res.weather[0].main,
                        icon: `icon-${res.weather[0].icon}`
                    };
                    panel.find('.weather-icon i').addClass(weatherInfo.icon);
                    panel.find('.weather-icon span').text(`${weatherInfo.desc} ${weatherInfo.temp}°C`);
                });
        }

        function updateCurrentTime(city, panel) {
            const currentTime = new Date().toLocaleString('en-US', {
                timeZone: city.timeZone
            });

            const options = {
                weekday: 'long',
                hour: 'numeric',
                minute: 'numeric'
            };
            const localTime = new Date(currentTime).toLocaleDateString('en-US', options);
            panel.find('p').text(localTime);
            setGradient(new Date(currentTime).getHours(), panel);
        }

        function renderCity(cityName) {
            const city = cities[cityName];
            const panel = $(`
      <div class="panel">
        <div>
          <h2>${cityName}</h2>
          <p></p>
        </div>
        <div class="weather-icon">
          <i></i>
          <span></span>
        </div>
      </div>
    `);
            panel.click(() => {
                panel.toggleClass('open');
            });
            $('.panels').append(panel);
            getWeatherInfo(city.weatherId, panel);
            updateCurrentTime(city, panel);
            setInterval(() => updateCurrentTime(city, panel), 5000);
        }

        Object.keys(cities).forEach(cityName => renderCity(cityName));
    });
</script>
