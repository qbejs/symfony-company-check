# Symfony-Company-Check 🌍

![PHPUnit](https://img.shields.io/badge/PHPUnit-Tests-green.svg)
![PHP-CS-Fixer](https://img.shields.io/badge/PHP--CS--Fixer-Coding%20Standards-blue.svg)

Welcome to `Symfony-Company-Check`! This is a simple app built in Symfony using DDD and CQRS.

## 🐳 Docker Deployment

Docker makes it easy to wrap your applications and services in containers so you can run them anywhere. Our project is already Docker-ready for you!

1. **Navigate to the Docker Directory**

    ```bash
    cd .docker
    ```

2. **Build and Start the Containers**

   Note: Ensure Docker is running on your system.

    ```bash
    docker-compose up -d
    ```

   This command will build the containers based on the services defined in `docker-compose.yml` and the respective `Dockerfile`s located in the service directories.

3. **Check the Running Containers**

    ```bash
    docker ps
    ```

   You should see your services running. If you face any issues, logs can be checked using:

    ```bash
    docker-compose logs -f [service-name]
    ```

4. **Stopping the Containers**

   Once you're done, you can stop the containers by running:

    ```bash
    docker-compose down
    ```

With Docker, you can ensure the application runs in the same environment regardless of where Docker is running. It simplifies deployment, scaling, and testing.



## 🛠 Setup & Installation

1. **Clone the Repository**

2. **Navigate into the Directory**
    ```bash
    cd symfony-company-check
    ```

3. **Install Dependencies**
    ```bash
    composer install
    ```

4. **Run the Service**
    ```bash
    symfony server:start
    ```

That's it! Your translation microservice should now be running on `http://127.0.0.1:8000`.

