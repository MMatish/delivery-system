# Delivery System Backend (Laravel 12)

## Project Overview
This is a **backend delivery management system** built with **Laravel 12**. 

The system allows:

- Admins to create, modify, and assign delivery jobs to drivers.  
- Drivers to view their assigned jobs and update their status.  
- Authentication and API token management using **Laravel Sanctum**.  

The frontend is **separate (using Angular)**.

---

## Technologies & Packages
- **Laravel 12** – backend framework  
- **Laravel Sail** – local development environment using Docker  
- **MySQL** – database (default via Sail)  
- **Laravel Sanctum** – API token authentication  

Some of the backend settings:  
- **Cache**: file-based (`CACHE_STORE=file`)  
- **Sessions**: file-based (`SESSION_DRIVER=file`)  
- **Queue**: synchronous (`QUEUE_CONNECTION=database`)  

---

## Getting Started

### 1. Clone the repository
```bash
git clone <repository-url>
cd <project-folder> 
```

### 2. Installing dependencies and starting the backend in the docker via sail
```bash
composer install
./vendor/bin/sail up -d
```

### 2.1. Optionally we can also set the alias for the Laravel Sail, for more info I recommend checking the Laravel Sail docs

```bash
alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'
```


### 3. Setting up the environment
Sail by default using sail and password for the local development, not recommended to change this setting.
The env.example contains the working settings without the API keys.

Generating the key:
```bash
sail artisan key:generate
```

###

## Useful commands for the development
Just a shortcut for clearing all the settings
```bash
sail artisan config:clear
sail artisan route:clear
sail artisan cache:clear
sail artisan clear-compiled
```
