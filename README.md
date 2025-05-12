# Calculator with SQL Database Integration

A simple calculator web application with the ability to store calculation history in an SQLite database.

## Features

- Basic arithmetic operations (addition, subtraction, multiplication, division)
- History of calculations stored in an SQLite database
- View and clear calculation history

## Requirements

- PHP 7.0 or higher with PDO SQLite extension
- Web server (Apache, Nginx, or PHP's built-in server)

## Setup Instructions

1. Clone or download this repository to your web server directory.

2. Make sure the `database` directory is writable by the web server:
   ```
   chmod -R 777 database
   ```

3. To run using PHP's built-in web server for development:
   ```
   path\to\php -S localhost:8000
   ```

4. Open your web browser and navigate to:
   ```
   http://localhost:8000/index.php
   ```

## Troubleshooting

If you encounter issues with the database functionality:

1. Ensure PHP has the SQLite PDO extension enabled
2. Check PHP error logs for specific error messages
3. Make sure the `database` directory has proper write permissions
4. Try accessing the app through `index.php` instead of `index.html`
5. If using Apache, ensure that the `.htaccess` file is being read

## Project Structure

- `index.php`: Main calculator interface with PHP error handling
- `index.html`: Basic HTML version (use index.php instead for better error handling)
- `styles.css`: Stylesheet for the calculator
- `script.js`: JavaScript code for calculator functionality
- `api/`: Directory containing PHP scripts for database operations
  - `db_config.php`: Database connection and configuration
  - `save_calculation.php`: API endpoint to save calculations
  - `get_history.php`: API endpoint to retrieve calculation history
  - `clear_history.php`: API endpoint to clear calculation history
- `database/`: Directory containing the SQLite database file
- `.htaccess`: Apache configuration for proper handling of PHP scripts

## How it Works

1. The calculator UI is built using HTML, CSS, and JavaScript.
2. When calculations are performed, they are sent to the server using fetch API.
3. PHP scripts process these requests and interact with the SQLite database.
4. Calculation history is retrieved from the database and displayed below the calculator.

## Database Schema

The SQLite database contains a single table:

### history
- `id`: INTEGER PRIMARY KEY AUTOINCREMENT
- `expression`: TEXT - The calculation expression
- `result`: REAL - The calculated result
- `timestamp`: DATETIME - When the calculation was performed

## Technologies Used

- HTML5
- CSS3
- JavaScript (fetch API)
- PHP with PDO
- SQLite 