# CodeIgniter 3 Project - Admin Module

## Overview
This project is built using **CodeIgniter 3** and features an Admin Panel designed for managing a Doctor Appointment Application. The admin module provides functionality for administrators to effectively manage doctors, patients, appointments, pharmacies, payouts, staff, invoices, notifications, and support requests.

---

## Features


### 9. **Notifications**
- Send real-time notifications to doctors and patients.
- Notify users about appointments, updates, and payouts.

---

## Installation Instructions

### Prerequisites
- **PHP 7.2 or higher**
- **MySQL 5.6 or higher**
- **Apache/Nginx web server**

### Steps
1. Clone the repository:
   ```bash
   git clone <repository-url>
   ```
2. Navigate to the project directory:
   ```bash
   cd project-folder
   ```
3. Set up the database:
   - Import the provided SQL file into your MySQL database.
   - Update the `application/config/database.php` file with your database credentials.

4. Configure the base URL in `application/config/config.php`:
   ```php
   $config['base_url'] = 'http://your-domain.com';
   ```

5. Ensure the `uploads` directory is writable for file uploads.

6. Run the application on your local or production server.

---

## Folder Structure
- **application/controllers/Admin.php**: Handles admin module logic.
- **application/models/**: Contains models for doctors, patients, appointments, payouts, etc.
- **application/views/admin/**: Contains admin panel views.
- **assets/**: Contains CSS, JS, and image files for the admin panel UI.

---

## Usage
### Admin Panel
1. Log in using admin credentials.
2. Navigate through the dashboard to manage different modules.
3. Use the menu to:
   
   - Send notifications.

### Notifications
- Notifications can be sent to doctors and patients regarding appointments, updates, and other relevant information.



