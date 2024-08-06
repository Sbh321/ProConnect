# ProConnect

ProConnect is a social media application with job listing features, built with Laravel. The platform allows users to connect with each other, share updates, and discover job opportunities.

## Table of Contents

-   [Features](#features)
-   [Installation](#installation)
-   [Usage](#usage)
-   [Contributing](#contributing)

## Features

-   User authentication and profiles
-   Post updates and share media
-   Comment, like and save posts
-   Browse job listings
-   Follow other users

## Installation

To get a local copy up and running, follow these simple steps:

1. **Clone the repository:**

    ```bash
    git clone https://github.com/Sbh321/social-media-job-app.git
    cd social-media-job-app
    ```

2. **Install dependencies:**

    ```
    composer install
    npm install
    ```

3. **Set up your environment variables:**

-   Duplicate the .env.example file and rename it to .env.
-   Update the .env file with your database and mail configurations.

    ```
    cp .env.example .env
    php artisan key:generate
    ```

4. **Run migrations and seed the database:**

    ```
    php artisan migrate --seed
    ```

5. **Compile assets:**

    ```
    npm run dev
    ```

6. **Run the application:**

    ```
    php artisan serve
    ```

7. **Access the application:**

-   Open your web browser and go to url displayed on your terminal when application is serving.

## Usage

-   Register a new account or log in with an existing one.
-   Create and manage posts within your profile.
-   View and manage user profile/
-   Comment, like and save posts
-   Browse job listings.
-   Add jobs.
-   Manage user's job listings.
-   Connect with other users by following them.

## Contributing

Contributions are welcome! Please follow these steps to contribute:

1. **Fork the repository.**

2. **Clone your fork:**

    ```bash
    git clone https://github.com/Sbh321/social-media-job-app.git
    cd social-media-job-app
    ```

3. **Install dependencies:**

    ```
    composer install
    npm install
    ```

4. **Create a new branch:**

    ```
    git checkout -b feature/YourFeature
    ```

5. **Commit your changes:**

    ```
    git commit -m 'Add some feature'
    ```

6. **Push to the branch:**

    ```
    git push origin feature/YourFeature

    ```

7. **Open a pull request.**
