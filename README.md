# Steadfast Collective Voting System

## Introduction

The Steadfast Voting System is a robust web application designed to facilitate secure and efficient online voting. This project leverages modern web technologies and best practices to deliver a seamless user experience and reliable backend services.

### Technologies Used

This project is built using Laravel, Vue.js, Tailwind CSS, and Docker, among other technologies. Key features include:

- **Geolocation Tracking**: Utilizes the `stevebauman/location` package to determine and store the geographical location of voters for analytical purposes.
- **Queue Service with Supervisor**: Ensures background jobs (like email sending) are processed efficiently.
- **Cronjob for Task Scheduling**: Handles periodic tasks like daily email summaries.
- **Docker Environment**: Recommended for easy setup, encapsulating services like Supervisor and Cronjobs, ensuring everything is pre-configured and ready to use.
- **Manual Configuration Option**: For users opting not to use Docker, manual setup of queue workers and cron jobs is necessary.

Using Docker, you won't need to manually configure services like Supervisor for queue management or set up cron jobs for task scheduling; everything is pre-packaged for convenience. For non-Docker users, manual setup instructions are provided.

## Project Requirements

- Composer >= 2.6.6
- PHP >= 8.2
- Node >= 20.11.0
- Npm >= 10.2.4
- Laravel >= 10.10
- Mailtrap Account

## Configure Mailtrap for Email Service

Mailtrap is used in this project to simulate an email inbox for testing and development purposes. To configure Mailtrap, follow these steps:

1. **Create a Mailtrap Account:**
   - If you don't already have a Mailtrap account, visit [Mailtrap's website](https://mailtrap.io/) and sign up for a free account.

2. **Find Your Mailtrap Credentials:**
   - Once logged in, go to your inbox and click on the 'SMTP Settings' tab. 
   - Select 'Laravel 9+' from the dropdown to get the configuration details tailored for Laravel.

3. **Update Environment Variables:**
   - Open your project's `.env.example` file. 
   - Locate the SMTP settings section and update it with your Mailtrap credentials. It should look something like this:

     ```
     MAIL_MAILER=smtp
     MAIL_HOST=sandbox.smtp.mailtrap.io
     MAIL_PORT=2525
     MAIL_USERNAME=your_mailtrap_username
     MAIL_PASSWORD=your_mailtrap_password
     MAIL_ENCRYPTION=tls
     MAIL_FROM_ADDRESS=from@example.com
     MAIL_FROM_NAME="${APP_NAME}"
     ```

   - Replace `your_mailtrap_username` and `your_mailtrap_password` with the actual username and password provided by Mailtrap.
   - The `MAIL_FROM_ADDRESS` and `MAIL_FROM_NAME` can be set to your preferences or left as default for testing.

## Installation Steps Using Docker

1. **Clone the Repository**:
    ```bash
    git clone https://github.com/akashmanujaya/steadfast-voting-system.git
    ```

2. **Navigate to the Project Directory**:
    ```bash
    cd steadfast-voting-system
    ```

3. **Build and Start Docker Containers**:
    ```bash
    docker-compose up -d --build
    ```
    - **After run this code, your container will be built. Please wait few secods until the container run all the commands inside the temainal. please check your conatainer terminal for logs. after success installaion all the packages, the application will be run on `http://0.0.0.0:8000`**

4. **Access the Application**: Open your web browser and visit `http://0.0.0.0:8000`.

## Installation Steps Without Docker

1. **Clone the Repository**:
    ```bash
    git clone https://github.com/akashmanujaya/steadfast-voting-system.git
    ```

2. **Navigate to the Project Directory**:
    ```bash
    cd steadfast-voting-system
    ```

3. **Install Composer Dependencies**:
    ```bash
    composer install
    ```

4. **Install NPM Packages**:
    ```bash
    npm install
    ```

5. **Set Up Environment**:
    - Copy the example environment file:
        ```bash
        cp .env.example .env
        ```
    - Generate an application key:
        ```bash
        php artisan key:generate
        ```

6. **Build Assets**:
    ```bash
    npm run build
    ```

7. **Serve the Application**:
    ```bash
    php artisan serve
    ```
   Then, access the application at `http://127.0.0.1:8000/`.

8. **Run the Queue Worker**:
    To process jobs on your queue, you need to start a queue worker. In a production environment, consider using a process monitor like Supervisor to ensure the queue worker does not stop running. For development, you can start a worker with:
    ```bash
    php artisan queue:work
    ```
9. **Setting Up Cronjobs**
    The Laravel scheduler relies on a single cron entry in your server to call the `schedule:run` command every minute. Add the following Cron entry to your server:
    ```cron
    * * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
    ```
    Replace `/path-to-your-project` with the absolute path to your Laravel project. This Cron job ensures that Laravel's task scheduler runs every minute to execute any scheduled tasks.

## Technologies and Libraries

This project makes use of several key technologies and libraries, including:

- **Laravel**: A robust PHP framework for web and API development, providing a rich set of functionalities for modern web applications.
- **Vue.js**: A progressive JavaScript framework used for building user interfaces, particularly single-page applications.
- **Tailwind CSS**: A utility-first CSS framework for rapidly building custom designs.
- **stevebauman/location**: A Laravel package used for retrieving user location information based on IP addresses, enhancing the application's functionality by allowing geographical analysis of user activities.
- **Docker**: A platform for developing, shipping, and running applications with containerization.
- **PHPUnit**: A popular testing framework for PHP, used for writing and running unit tests.
- **Supervisor**: A process control system that ensures the Laravel queue workers are continuously running.
- **Cronjobs**: Used for scheduling periodic tasks such as sending out daily email summaries.

## Running Tests

### Using Docker Environment

1. **Access the Container's Shell**:
    ```bash
    docker exec -it aml-steadfast-collective-voting-system /bin/sh
    ```

2. **Run the Tests**:
    ```bash
    php artisan test
    ```

### In Non-Docker Environment

Simply run the tests with the following command in your project root:

```bash
php artisan test
```