# SIAKAD APPLICATION - LARAVEL 10

## Screenshots

![preview img](/preview.png)

## Run Locally

Clone the project

```bash
  git clone https://github.com/nama_project
```

```bash
  cd nama_project
```

-   Copy .env.example file to .env and edit database credentials there

```bash
    composer install
```

```bash
    php artisan key:generate
```

```bash
    php artisan migrate:fresh --seed
```

```bash
    php artisan storage:link
```

#### Login

-   email = admin@admin.com
-   password = 123
