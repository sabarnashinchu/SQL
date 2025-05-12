# Calculator with SQL Database Integration

A modern calculator web application with a beautiful UI and SQLite database backend to store calculation history.

![Calculator Screenshot](https://via.placeholder.com/800x450.png?text=Calculator+with+History)

## 🌟 Features

- ✅ **Modern UI** with smooth animations and gradient effects
- ✅ **Real-time calculations** with support for basic arithmetic operations
- ✅ **Keyboard support** for faster input (numbers, operators, Enter, Backspace, Escape)
- ✅ **History tracking** of all calculations stored in SQLite database
- ✅ **Clickable history items** to reuse previous calculations
- ✅ **Responsive design** that works on mobile devices
- ✅ **Error handling** with visual notifications
- ✅ **Data persistence** between sessions

## 🔧 Technologies Used

- **Frontend**: HTML5, CSS3, JavaScript (Vanilla)
- **Backend**: PHP with PDO
- **Database**: SQLite
- **Server**: PHP's built-in development server

## 📋 Requirements

- PHP 7.0 or higher with PDO SQLite extension
- Web server (Apache, Nginx, or PHP's built-in server)
- Modern web browser

## 🚀 Setup Instructions

### Option 1: Using PHP's built-in server

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/calculator-sql.git
   cd calculator-sql
   ```

2. **Ensure SQLite extension is enabled**
   - Create or edit php.ini file in your PHP installation directory
   - Uncomment the following lines:
     ```
     extension=pdo_sqlite
     extension=sqlite3
     ```
   - Or create a local php.ini in the project folder with these lines

3. **Create database directory** (should already exist)
   ```bash
   mkdir -p database
   chmod 777 database
   ```

4. **Start the PHP server**
   ```bash
   php -S localhost:8000
   ```

5. **Access the calculator**
   - Open your browser and navigate to: http://localhost:8000/index.php

### Option 2: Using XAMPP

1. **Install XAMPP** from [apachefriends.org](https://www.apachefriends.org/)

2. **Copy project files** to the htdocs directory:
   ```bash
   xcopy /E /I /Y calculator-sql C:\xampp\htdocs\calculator-sql
   ```

3. **Start Apache server** from XAMPP Control Panel

4. **Access the calculator**
   - Open your browser and navigate to: http://localhost/calculator-sql/index.php

## 🧩 Project Structure

```
calculator-sql/
├── api/                      # API endpoints for database operations
│   ├── db_config.php         # Database connection configuration
│   ├── save_calculation.php  # Endpoint to save calculations
│   ├── get_history.php       # Endpoint to retrieve history
│   └── clear_history.php     # Endpoint to clear history
├── database/                 # SQLite database storage
│   └── calculator.db         # SQLite database file (auto-created)
├── styles.css                # CSS styles for the calculator
├── script.js                 # JavaScript for calculator functionality
├── index.php                 # Main calculator interface with PHP
├── index.html                # Basic HTML version (optional)
├── setup_php.bat             # Windows batch file to set up PHP (optional)
├── php.ini                   # Local PHP configuration (optional)
└── README.md                 # Project documentation
```

## 💾 Database Schema

The SQLite database contains a single table:

### history
| Column      | Type      | Description                         |
|-------------|-----------|-------------------------------------|
| id          | INTEGER   | Primary key (auto-increment)        |
| expression  | TEXT      | The calculation expression          |
| result      | REAL      | The calculated result               |
| timestamp   | DATETIME  | When the calculation was performed  |

## 🎮 Usage

- **Basic arithmetic**: Enter numbers and use +, -, ×, ÷ operators
- **Calculate**: Press = or Enter key to calculate
- **Clear**: Press C or Escape key to clear input
- **Backspace**: Press ⌫ or Backspace key to delete last character
- **View history**: Scroll through calculation history below the calculator
- **Reuse calculation**: Click on any history item to load it into the calculator
- **Clear history**: Press the "Clear History" button to delete all history

## 🔄 Future Improvements

- Add more advanced operations (square root, percentages, etc.)
- Implement user accounts to track different users' calculations
- Add export functionality for history (CSV, PDF)
- Add themes with dark mode support
- Implement calculation categories/tags

## 📝 License

This project is licensed under the MIT License - see the LICENSE file for details.

## 👨‍💻 Author
[GitHub](https://github.com/sabarnashinchu)

## 🙏 Acknowledgements

- [SQLite](https://www.sqlite.org/) - Self-contained database engine
- [PHP](https://www.php.net/) - Server-side scripting language
- [FontAwesome](https://fontawesome.com/) - Icons (if used) 
