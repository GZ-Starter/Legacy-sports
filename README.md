# Legacy Sports

Legacy Sports is a web-based online sports accessories shopping site designed to facilitate remote shopping. Users can browse, order, and pay for sports accessories from the comfort of their homes. The project aims to provide a fast, effective, and reliable online shopping platform with distinct modules for Admin, User, and Guest interactions.

## Table of Contents

- [Introduction](#introduction)
- [Features](#features)
- [System Architecture](#system-architecture)
- [Modules](#modules)
- [Software and Hardware Requirements](#software-and-hardware-requirements)
- [Installation](#installation)
- [Usage](#usage)
- [Screenshots](#screenshots)
- [Contributing](#contributing)
- [License](#license)

## Introduction

The Legacy Sports platform is a user-friendly web application designed to facilitate the online purchase of sports accessories. The system aims to reduce manual work and provide a computerized system for managing shopping, payments, and customer details.

## Features

- **Admin Module**: Manage products, view orders, update supplier details.
- **User Module**: Browse products, add products to cart, place orders, view order status.
- **Guest Module**: View products and register to access full features.

## System Architecture

The system architecture consists of a centralized database accessed by the Admin and User modules. The Admin can manage products and orders, while users can browse and order products. The system ensures secure login for both Admin and Users.

## Modules

### Admin
- Add, update, and delete products.
- View product and order details.
- Manage supplier information.

### User
- View product details.
- Add products to cart and place orders.
- View order status and contact admin for order cancellations.

### Guest
- View available products.
- Register to access full features of the platform.

## Software and Hardware Requirements

### Development Tools
- **Frontend**: HTML, CSS, JavaScript
- **Backend**: PHP, MySQL
- **Testing**: Manual testing with real-time data

### Hardware Requirements
- Standard Monitor, Keyboard, and Mouse
- 4 GB RAM or more
- Intel Core i3 or better CPU
- Hard Disk Storage

### Software Requirements
- Operating System: Windows 10 or above
- Browser: Any standard browser
- XAMPP MariaDB/MySQL Database

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/GZ-Starter/legacy-sports.git
   ```
2. Navigate to the project directory:
   ```bash
   cd legacy-sports
   ```
3. Set up the database using XAMPP or any preferred MySQL setup.
4. Import the database schema from `database/schema.sql`.
5. Configure the database connection in `config.php`.

## Usage

1. Start the XAMPP control panel and ensure Apache and MySQL are running.
2. Open a web browser and navigate to `http://localhost/legacy-sports`.
3. Register as a new user or log in as an admin to start managing the platform.

## Screenshots  
![image](https://github.com/GZ-Starter/Legacy-sports/assets/126936908/1c5be877-ec3e-405e-a598-1e1c7c7fe148)  
![image](https://github.com/GZ-Starter/Legacy-sports/assets/126936908/9a3ac318-1b8b-4292-a3fc-53badb2a2789)  
![image](https://github.com/GZ-Starter/Legacy-sports/assets/126936908/0aa3f6f0-2560-4186-95a8-e225645c202d)  
![image](https://github.com/GZ-Starter/Legacy-sports/assets/126936908/5b663c79-e0f8-40d5-9c79-65842fe48c3f)  
![image](https://github.com/GZ-Starter/Legacy-sports/assets/126936908/431d65fd-c357-4832-94ca-81667a244bee)  
![image](https://github.com/GZ-Starter/Legacy-sports/assets/126936908/7c0a1087-d28f-4e18-8e12-89feb2b9f371)  
![image](https://github.com/GZ-Starter/Legacy-sports/assets/126936908/ec6ff9f5-0fe6-4360-a9f6-ef31f4938607)  
![image](https://github.com/GZ-Starter/Legacy-sports/assets/126936908/d5a72a53-13ce-40b2-a43b-37655377f9cb)  
![image](https://github.com/GZ-Starter/Legacy-sports/assets/126936908/9a5e3b9f-481c-4aa4-88a8-bbaae14318ed)  
![image](https://github.com/GZ-Starter/Legacy-sports/assets/126936908/71954764-c52a-4eaa-af6b-e7f00e6d6f09)  
![image](https://github.com/GZ-Starter/Legacy-sports/assets/126936908/4f7c00ad-8bd9-4b7d-abaa-9214fc8dd636)  
![image](https://github.com/GZ-Starter/Legacy-sports/assets/126936908/83b9fddb-e01a-4d9b-b1d0-efc1aad05281)  
![image](https://github.com/GZ-Starter/Legacy-sports/assets/126936908/c206b45b-79f1-4583-bb3e-ac76571ace7b)

## Contributing

Contributions are welcome! Please fork the repository and create a pull request with your changes. Ensure that your code adheres to the project’s coding standards and includes relevant documentation.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for more details.
