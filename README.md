# E-Canteen Project Documentation

## Introduction

The E-Canteen project is a web application developed using Laravel and Inertia.js with Svelte. It aims to provide a convenient and efficient way for users to order food from a canteen online.

## Features

-   User Registration and Authentication: Users can create an account and log in to access the application.
-   Menu Display: The application displays the available food items and their prices.
-   Cart Management: Users can add items to their cart, view the cart, and proceed to checkout.
-   Order Placement: Users can place an order and receive a confirmation.
-   Order History: Users can view their past orders.
-   Admin Panel: Administrators have access to an admin panel to manage food items, user accounts, and orders.

## Technologies Used

-   Laravel: A PHP framework used for backend development.
-   Inertia.js: A library that allows you to build single-page applications using server-side routing and controllers.
-   Svelte: A JavaScript framework for building user interfaces.

## Installation

1. Clone the repository: `git clone https://github.com/your-repo.git`
2. Install dependencies: `composer install && npm install`
3. Configure the environment variables: Copy the `.env.example` file to `.env` and update the necessary variables.
4. Generate the application key: `php artisan key:generate`
5. Run database migrations: `php artisan migrate`
6. Start the development server: `php artisan serve`

## Usage

1. Access the application in your web browser at `http://localhost:8000`.
2. Register a new user account or log in with an existing account.
3. Browse the menu, add items to your cart, and proceed to checkout.
4. Place an order and receive a confirmation.
5. View your order history.

## Contributing

If you would like to contribute to the project, please follow these steps:

1. Fork the repository.
2. Create a new branch: `git checkout -b feature/your-feature-name`
3. Make your changes and commit them: `git commit -m 'Add some feature'`
4. Push to the branch: `git push origin feature/your-feature-name`
5. Submit a pull request.

## License

This project is licensed under the [MIT License](LICENSE).

## Contributors

-   [Galur Arasy Lumintang (Programmer)](mailto:adamhenderson3x3@gmail.com)
-   [M. Ariesta Naeva Arya Dhuta (QA Tester)](mailto:mochamadmunif71@gmail.com)
-   [Ibnu Tsalis Assalam (System Analyst)](mailto:ibnutsalisassalam@gmail.com)
-   [Rini Novitasari (UI/UX Designer)](mailto:rininovitasarin27@gmail.com)
-   [Anas Wirayudha (UI/UX Designer)](mailto:anaswirayudha01@gmail.com)
-   [M. Helmi Permana Agung (Project Manager)](mailto:helmiagung2468@gmail.com)

## Dev Note

### Upcoming Feature

-   Generate report
    -   Filter transaction each day

### User Interface

### Security

#### Frontend

#### Backend

-   Fix 429 errors that happened after 1 wrong credential supplied
-   Implement register and authentication with google
-   Implement verify email, forgot password
-   Move logout function somewhere else

### Data Management

-   Supplier
    -   Reject Validation check if phone number starts from 0
    -   Automatically append 62 when entering supplier phone number

### Business Process

-   Listen when product stock changes
    -   Calculate stock with the restock threshold
    -   Example: `restock && stock <= min_stock`
-   Notify user
    -   Send a page which contain message to supplier
    -   or better, use whatsapp api to automate processes

### Deployment

-   Fix image pathing bug
