# Weather Alert Notification System

This is a Laravel project that notifies users about severe weather conditions, such as **high precipitation** and **high UV index**. The system retrieves weather data, stores alerts in the database, and sends notifications to users when necessary.

## 🚀 Getting Started

### 1️⃣ Clone the Repository
```sh
 git clone https://github.com/arman424/weather-notifier.git
 cd weather-notifier
```

### 2️⃣ Setup the Project
```sh
 make setup
```

### 3️⃣ Configure API Key
Sign up at [Weatherbit](https://www.weatherbit.io/) and obtain an API key. Then, add it to your `.env` file:
```ini
WEATHERBIT_KEY=your_api_key_here
```

### Testing Weather Alerts

If you want to test weather alerts, you should modify the threshold values in the `config/weather.php` file. Change the parameters as follows to ensure that the system always detects high precipitation and UV index, triggering notifications:

```php
return [
    'max_precipitation' => -10, // mm
    'max_uv_index' => -10
];
```

## ⚡ Usage

### Fetch and Store Weather Data
```sh
php artisan app:check-weather
```
This command retrieves weather data and stores alerts in the `weather_alerts` table.

### Send Weather Notifications
```sh
php artisan app:send-weather-alert
```
This command processes stored weather alerts.

### Process the Queue (Required for Notifications)
```sh
php artisan queue:work
```
This command ensures queued notifications are sent, updates their `notified` status.

## 🛠 Running Tests
```sh
make test
```

## ⚠️ Important Notes
- Check the **TODOs** in the code for pending improvements and additional functionality.
- Make sure to run the queue worker (`php artisan queue:work`) to send notifications.

Happy Coding! 🚀

