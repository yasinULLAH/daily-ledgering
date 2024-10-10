# Khata Roznamcha

Khata Roznamcha is a web-based ledger management software designed to facilitate easy and efficient handling of financial transactions. The system allows users to manage credits, debits, account details, generate detailed financial reports, and maintain records over time. It is particularly suitable for small businesses or individuals looking to maintain a clear record of their financial activities.

## Table of Contents

- [Features](#features)
- [Technologies Used](#technologies-used)
- [Installation](#installation)
- [Database Setup](#database-setup)
- [Project Structure](#project-structure)
- [Backup Roznamcha DataBase Cleaned 12-30-2022.sql](#backup-roznamcha-database-cleaned-12-30-2022sql)
- [Security Considerations](#security-considerations)
- [Future Enhancements](#future-enhancements)

## Features

### User Authentication and Session Management
- **Login and Logout**: Secure login system using username and password, with session management to keep track of logged-in users.
- **Session Handling**: PHP sessions are used to manage user login states and restrict access to specific features.

### Account Management
- **Add New Record**: Users can add new financial transactions (e.g., sales, expenses).
- **View All Accounts**: Displays a list of all accounts with summaries for easy management.
- **Detailed Client Information**: Users can view detailed information about each client, including transaction history.
- **Delete Records**: Allows users to delete specific records, maintaining up-to-date account data.

### Financial Transactions
- **Credit Accounts Management**: Add and manage records for all credit transactions.
- **Debit Accounts Management**: Add and manage records for all debit transactions.
- **Money Transfers**: A feature that allows users to transfer money between different accounts.
- **Amount Management**: Adjust the amounts associated with various accounts through the `amounts.php` page.

### Reporting and Data Analysis
- **Daily Reports**: Generate daily reports that provide insights into financial activities for specific dates.
- **Total Reports**: Summarize all transactions across different accounts, providing a complete view of the ledger.
- **Export to PDF**: Generate detailed PDF reports of account summaries and financial activities using the `fpdf` library.
- **Date-Specific Reports**: View reports for transactions on specific dates, useful for tracking daily activities.

### Data Backup and Maintenance
- **Database Backup and Restoration**: Includes SQL scripts for backing up and restoring the database, ensuring data integrity.
- **Backup Script**: A script to create backups of the database data, allowing for easy data recovery in case of issues.

### Data Export
- **PDF Generation**: Create customized PDFs of reports and records through `generate-pdf.php`.
- **Export Data**: Allows users to export records for offline access or sharing with stakeholders.

### User Interface and Navigation
- **Intuitive Navigation**: A simple and clean user interface with a top navigation bar and sidebar for easy access to all features.
- **Dynamic Forms and Tables**: Includes form handling for user inputs and tables for displaying account information dynamically.

## Technologies Used

- **Server-Side**: PHP (version 5.x or higher recommended)
- **Database**: MySQL for managing data and transactions
- **Front-End**: HTML, CSS, JavaScript (jQuery, jQuery UI)
- **PDF Generation**: `fpdf` PHP library for creating PDF reports
- **Data Backup**: SQL scripts for database backup and restoration

## Installation

To set up Khata Roznamcha on your local machine, follow these steps:

1. **Clone the repository**:
   ```bash
   git clone https://github.com/your-username/khata-roznamcha.git
   cd khata-roznamcha
   ```
2. **Set up the web server**:
   - Ensure you have a web server like **XAMPP** or **WAMP** installed.
   - Place the project files in the web server's root directory (e.g., `htdocs` for XAMPP).
3. **Configure Database Connection**:
   - Update the `Connections/myconn.php` file with your MySQL database credentials:
     ```php
     $hostname_myconn = "localhost";
     $database_myconn = "khata_database";
     $username_myconn = "your_db_username";
     $password_myconn = "your_db_password";
     ```
4. **Start the Web Server**:
   - Start Apache and MySQL from your web server control panel.
   - Access the application in your browser at `http://localhost/khata-roznamcha`.

## Database Setup

1. **Create a MySQL Database**:
   ```sql
   CREATE DATABASE khata_database;
   ```
2. **Import SQL File**:
   ```bash
   mysql -u your_db_username -p khata_database < path/to/Backup Roznamcha DataBase Cleaned 12-30-2022.sql
   ```
3. **Verify Database Structure**:
   - Ensure that tables and records have been imported successfully.

## Project Structure

```
khata-roznamcha/
├── Connections/
│   └── myconn.php             # Database connection file
├── index.php                  # Main entry point for the application
├── insert-record.php          # Handles new record insertion
├── all_account.php            # Displays all accounts
├── client-detail.php          # Shows detailed information for a client
├── credits.php                # Manages credit transactions
├── debits.php                 # Manages debit transactions
├── trans.php                  # Manages fund transfers between accounts
├── date.php                   # Generates date-specific reports
├── total.php                  # Generates a summary of total transactions
├── exporter/                  # Contains PDF generation scripts
│   ├── generate-pdf.php       # Creates PDFs using fpdf
│   └── fpdf.php               # fpdf library for generating PDFs
├── style/
│   └── style.css              # Main stylesheet for the application
├── js/
│   └── jquery-1.9.1.js        # jQuery library
├── Backup Roznamcha DataBase Cleaned 12-30-2022.sql # Database backup file
└── README.md                  # Documentation
```

## Backup Roznamcha DataBase Cleaned 12-30-2022.sql

This SQL file contains the structure and initial data required to set up the Khata Roznamcha database. It includes:

- **Tables**: Definitions for storing user information, account details, transactions, and other related data.
- **Sample Data**: Initial data entries for demonstration or testing purposes.
- **Structure**: Relationships between tables, indexes for faster queries, and constraints to ensure data integrity.

To import this SQL file, follow the instructions provided in the [Database Setup](#database-setup) section. This will prepare your database to work seamlessly with the Khata Roznamcha application.

## Security Considerations

- **Input Validation**: Ensure that user inputs are properly validated to prevent SQL injection.
- **Password Hashing**: Use secure methods like `bcrypt` for password storage.
- **Session Management**: Implement session timeout and regenerate session IDs after login for enhanced security.
- **HTTPS**: Enable HTTPS to secure data transmission between the server and client.

## Future Enhancements

- **Upgrade to PHP 7.x or 8.x**: Improve performance and security by upgrading to a newer PHP version.
- **Responsive Design**: Make the UI mobile-friendly by enhancing the CSS.
- **Role-Based Access Control**: Implement roles for users (e.g., admin, manager) for more granular access control.
- **Enhanced Reporting**: Add options to export reports in other formats like CSV or Excel.
- **Code Refactoring**: Consider using an MVC framework like Laravel for better code organization.
