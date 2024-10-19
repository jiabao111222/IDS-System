#Description

Intrusion Detection System (IDS)
This project is a QR code-based Intrusion Detection System (IDS). It allows users to log in by uploading a QR code and implements multi-layered security filtering. The system also logs login attempts and notifies the administrator via email when necessary.

Features
QR Code Login: Users can log in by uploading a QR code, which is then verified for authenticity.
Three-Layer Security Filtering:
File Type Check: Ensures the uploaded file is in an image format.
CAPTCHA Verification: Uses reCAPTCHA to ensure the request is from a legitimate user.
QR Code Content Validation: Validates that the content of the QR code starts with the prefix "Encryp".
Login Attempt Logging: Records each login attempt, including:
Client IP address
Event logs (e.g., "wrong file type", "wrong QR code")
Timestamp
Status of the attempt (successful or failed)
Email Notifications: After three consecutive failed login attempts from the same IP, an email alert is sent to the administrator.
Installation
Clone the repository to your local machine:

git clone https://github.com/jiabao111222/IDS-System.git
cd IDS-System
Install the necessary dependencies (e.g., PHPMailer for email notifications):

composer install
Configure the config.php file with your database and SMTP server details.

Set up the database:

Create a MySQL database named logs.
Import the logs.sql file provided in the repository to create the necessary tables.
Configure your web server to serve the project files (e.g., Apache or Nginx).

Usage
Logging in: Users upload a QR code to the system. The QR code is processed through multiple layers of validation before allowing access.
Error Logging: If there are issues with the uploaded QR code or CAPTCHA validation, an error will be logged in the database and reflected in the system's admin interface.
Admin Interface: The admin can view all login attempts, including successful and failed attempts, and details about the events in the system logs.
Configuration
Database: The system uses a MySQL database to store logs of login attempts and system events.
Email Alerts: PHPMailer is used to send email alerts after consecutive failed login attempts. Configure the SMTP settings in the config.php file.
reCAPTCHA: reCAPTCHA v2 is used for user verification. Obtain a site key and secret key from Google and update them in the config.php.
Contributing
Feel free to submit issues or pull requests to improve the system.
