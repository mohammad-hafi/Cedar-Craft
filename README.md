# 🌲 Cedar Craft

Cedar Craft is a modern web application built with Laravel that showcases handcrafted cedar wood products and provides an intuitive platform for browsing, managing, and presenting products online.

## Features

* Product catalog management
* Responsive and modern user interface
* Laravel MVC architecture
* Database-driven content
* Secure authentication system
* Dynamic product pages
* Easy-to-maintain code structure

## Tech Stack

### Backend

* PHP
* Laravel

### Frontend

* Blade Templates
* HTML5
* CSS3
* JavaScript

### Database

* MySQL

## Installation

### Clone the Repository

```bash
git clone https://github.com/mohammad-hafi/Cedar-Craft.git
cd Cedar-Craft
```

### Install PHP Dependencies

```bash
composer install
```

### Install Frontend Dependencies

```bash
npm install
```

### Configure Environment

Copy the environment file:

```bash
cp .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

Configure your database settings in the `.env` file.

### Run Migrations

```bash
php artisan migrate
```

### Start the Development Server

```bash
php artisan serve
```

### Build Frontend Assets

```bash
npm run dev
```

The application will be available at:

```text
http://localhost:8000
```

## Project Structure

```text
Cedar-Craft/
│
├── app/
├── bootstrap/
├── config/
├── database/
├── public/
├── resources/
├── routes/
├── storage/
├── tests/
│
├── composer.json
├── package.json
└── README.md
```

## Objectives

This project was created to:

* Practice Laravel development
* Build a complete web application
* Learn database management
* Implement MVC architecture
* Improve frontend and backend integration skills

## Future Enhancements

* Product search and filtering
* Shopping cart functionality
* Order management
* Admin dashboard
* Product image gallery

## License

This project is open source and available under the MIT License.

## Author

Developed by Mohammad Hafi.
