# Delivery System Backend (Laravel 12)

## Estimated time spent:

I have spent around 5-7 hours doing

### What took a lot of time:

- Troubleshooting: for some weird reason the Laravel Fortify was broken out of the box. It could not find it's own rate limiter (even creating a custom rate limiter did not help). I assume it has to do something with Laravel Sail and the backend running in the docker, but solutions online could not help, so I created the login and registration from scratch. **Took 1-1.5 hours** reading through the docs.
- Setting the initial environment: had to spend some time remembering how to set the initial environment to be compatible with the separate frontend (SPA). Set up the laravel session, csrf and cors as well the middleware to check the role of the user. **Took also around 1-1.5 hours**.
- The rest was actually creating the controllers, services and testing as well as making sure everything works properly. 


## Links

### Link to the video with the demonstration

- https://drive.proton.me/urls/PSSXX3DQYM#3GgyEL5NCnkm

### Link to the frontend

- https://github.com/MMatish/delivery-system-frontend

---

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

## The program workflow
- We log in or create a new account as the driver

### Admin
- If we log in as an admin, then we can update, create, remove and assign jobs
- Creating a job automatically adds an "unassigned" status and null id for the driver
- Giving the job to the driver changes the status to "assigned". Changing the driver sets the status back to "assigned"

### Driver
- If we register as a new driver, we still need to log in afterwards
- When logged in, we see our jobs and can freely change the status of the job (except we cannot set it to "unassigned")
- When setting status to Failed, the mail is logged in the laravel notifying the admin about the delivery failure

---

## Getting Started

### 1. Clone the repository
```bash
git clone <repository-url>
cd <project-folder> 
```

### 2. Installing dependencies and starting the backend in the docker via sail ('-d' is for detached mode)
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
Migrate:fresh --seed is also used for generating a database with test data from scratch.

Generating the key:
```bash
sail artisan key:generate
sail artisan migrate:fresh --seed
```

### 4. Running tests
```bash
sail artisan test
```

---

### Useful commands for the development

## A shortcut for clearing all the settings
```bash
sail artisan config:clear
sail artisan route:clear
sail artisan cache:clear
sail artisan clear-compiled
```

## Publishing settings
```bash
php artisan config:publish cors
```
