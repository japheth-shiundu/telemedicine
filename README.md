# telemedicine


## 📌 Project Overview
This is a **Telemedicine Admin Panel**, a web-based application that allows administrators to **manage appointments, doctors, and patient interactions** efficiently. The system provides CRUD (Create, Read, Update, Delete) operations for **appointments and doctors**, ensuring a smooth telemedicine experience.

## 🚀 Features
- **Admin Authentication** (Login/Logout)
- **Manage Appointments** (Add, Edit, Delete, View)
- **Manage Doctors** (Add, Edit, Delete, View)
- **Patient-Doctor Appointment Booking**
- **Message Management System**
- **User-friendly Interface** with Sidebar Navigation
- **Responsive Design with Poppins Font**
- ![Screenshot (12)](https://github.com/user-attachments/assets/896f5a5a-3fcd-4c1e-bb8b-d8a005d0d8de)
- ![Screenshot (8)](https://github.com/user-attachments/assets/30482723-822b-4497-9ed3-3d3e5495dea7)
- ![Screenshot (10)](https://github.com/user-attachments/assets/c084517c-e9a2-4b24-abd1-6b4a712ae757)




## 🛠️ Technologies Used
- **Front-end:** HTML, CSS
- **Back-end:** PHP, MySQL
- **Database:** MySQL
- **Styling:** Google Fonts (Poppins)

## 📂 Folder Structure
```
project-root/
│── admin-panel/
│   ├── auth.php
│   ├── dashboard.php
│   ├── database.php
│   ├── index.php
│   ├── login.php
│   ├── logout.php
│   ├── manage_appointments.php
│   ├── manage_doctors.php
│   ├── manage_messages.php
│   ├── profile.php
│── assets/
│   ├── css/
│   ├── js/
│   ├── images/
│── book_appointment.php
│── doctors.php
│── contact.php
│── README.md
│── database.sql
```

## 🔧 Installation & Setup
1. **Clone the Repository**
   ```sh
   git clone https://github.com/your-repo/telemedicine.git
   cd telemedicine
   ```

2. **Set Up Database**
   - Create a MySQL database named `telemedicine`
   - Import `database.sql` into your MySQL server

3. **Configure Database Connection**
   Edit `admin-panel/database.php` and update:
   ```php
   $host = "localhost";
   $dbname = "telemedicine";
   $username = "root";
   $password = "";
   ```

4. **Run the Project**
   - Start a local server using **XAMPP** or **WAMP**
   - Access the project at:
     ```
     http://localhost/telemedicine/index.php
     ```
     ```
     http://localhost/telemedicine/admin-panel/login.php
     ```

## 👤 Admin Login Credentials
Use the following default credentials:
```
Email: admin@example.com
Password: admin123
```
*(You can update the admin credentials in the database.)*

## 📌 Usage
- **Login** as an Admin
- **Navigate** using the sidebar
- **Manage Appointments** (Add, Edit, Delete, View)
- **Manage Doctors** (Add, Edit, Delete, View)
- **Handle Messages** from Patients

## 📜 License
This project is open-source and free to use for personal use. Modify as needed!


