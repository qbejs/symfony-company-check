# Symfony-Translation-Microservice 🌍

![PHPUnit](https://img.shields.io/badge/PHPUnit-Tests-green.svg)
![PHP-CS-Fixer](https://img.shields.io/badge/PHP--CS--Fixer-Coding%20Standards-blue.svg)
![Code Coverage](https://img.shields.io/badge/Code%20Coverage-Enabled-brightgreen.svg)

Welcome to `Symfony-Translation-Microservice`! This is a simple translation microservice built with Symfony implementing DDD architecture.

## 🖥️ Technologies Used

- **PHP 8.1**: One of the latest version of PHP, ensuring the best performance and security.
- **Symfony**: Built on top of Symfony, one of the most efficient PHP frameworks, ensuring robust performance and modular codebase.
- **MySQL**: A reliable relational database system, ensuring data integrity and efficient retrieval.
- **Doctrine**: An ORM for PHP that provides database abstraction, ensuring seamless data manipulation and persistence.
- **RabbitMQ**: A message broker that implements the Advanced Message Queuing Protocol (AMQP), ensuring reliable message delivery.
- **Redis**: An in-memory data structure store used as a caching layer to speed up data access.
- **PHPUnit**: A popular PHP testing framework that ensures our code runs as expected and is free from regressions.
- **Docker**: An OS-level virtualization tool that packages our app and its dependencies into containers for consistent and easy deployment.
- **Composer**: A dependency manager for PHP, ensuring the project has all the necessary libraries and manages them with ease.
- **Nginx**: A high-performance web server that serves static and dynamic content on the web.

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
    ```bash
    git clone https://github.com/your-username/Symfony-Translation-Microservice.git
    ```

2. **Navigate into the Directory**
    ```bash
    cd Symfony-Translation-Microservice
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

## 📝 Usage

Send a POST request to `/translate` endpoint with source and target language codes and the text you want to translate.

Example:
```bash
curl -X POST -H "Content-Type: application/json" \
     -d '{"source": "en", "target": "fr", "text": "Hello World!"}' \
     http://127.0.0.1:8000/translate
