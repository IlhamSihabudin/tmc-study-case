<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# TMC Study Case

## Installation

1. **Start Docker Compose**  
   Run the following command to start the Docker containers:
   ```bash
   docker compose up -d
2. **Run Migrations**  
   Execute the database migrations:
    ```bash
   php artisan migrate
   php artisan migrate:fresh --database=mysql_query --path=database/migrations/query
   ```
3. **Start the Queue Worker**  
   Launch the Laravel development server:
   ```bash
   php artisan serve
   ```
4. **Start the Development Server**  
   Start the queue worker for RabbitMQ:
   ```bash
   php artisan queue:work rabbitmq
   ```

