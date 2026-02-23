# Salary Management System

## 📌 Project Overview

The **Salary Management System** is a web-based application developed to automate and streamline payroll operations within an organization. It enables efficient management of employee records, salary calculations, and payroll processing.

The system allows administrators to manage employee details, while the accountant handles salary processing, leave management, and fund allocation. Employees can view their personal details and salary information. By reducing manual work, the system minimizes errors and improves overall efficiency in payroll management.

---

## 🎯 Objectives

* Automate employee salary management  
* Maintain organized employee records  
* Calculate salaries with allowances and deductions  
* Manage employee leave and payments  
* Reduce manual errors in payroll processing  
* Improve efficiency and accuracy  

---

## 🗂 System Description

The system maintains and processes the following data:

* Employee ID  
* Employee Name  
* Role / Designation  
* Salary Details  
* Leave Records  
* Payment Information  

---

## 🧹 Functional Modules

### 1. Admin Module

* Add new employees  
* Update employee details  
* Remove employees  
* View employee records  

### 2. Accountant Module

* Add funds for salary processing  
* Manage employee leave  
* Process salary payments  

### 3. Employee Module

* View personal details  
* Check salary information  

### 4. Common Module

* User authentication (login/logout)  
* Database connectivity  

---

## 📊 Features

* Role-based access (Admin, Accountant, Employee)  
* Efficient employee management  
* Accurate salary processing  
* Leave management system  
* Secure login and authentication  
* Organized data storage  

---

## 📈 System Workflow

1. Admin adds and manages employee details  
2. Accountant updates leave and funds  
3. Accountant processes salary payments  
4. Employee views salary and personal details  
5. Data is stored and managed in the database  

---

## 🧠 Key Benefits

* Reduces manual work  
* Improves accuracy in payroll  
* Easy management of employee data  
* Faster salary processing  
* Secure and structured system  

---

## 🛠 Tech Stack

* **Frontend:** HTML, CSS  
* **Backend:** PHP  
* **Database:** MySQL  
* **Tools:** XAMPP / VS Code  

---

## 📁 Project Structure

Salary-Management-System/
│
├── accountant/                     # Accountant Module (salary processing)
│   ├── add_fund.php                # Add funds / salary allocation
│   ├── add_leave.php               # Manage employee leave
│   └── pay_salary.php              # Process salary payments
│
├── admin/                          # Admin Module (manage employees)
│   ├── add_employees.php           # Add new employees
│   ├── change_post.php             # Update employee roles/positions
│   ├── ter_empolyees.php           # Terminate employees
│   └── view_employees.php          # View employee details
│
├── employee/                       # Employee Module
│   └── view_details.php            # View personal and salary details
│
├── includes/                       # Common utilities
│   ├── auth.php                    # Authentication logic
│   └── db.php                      # Database connection
│
├── ER_SMS.png                      # ER diagram of the system
├── background.php                  # UI / background configuration
├── sal_mgmt_sys.sql                # Database schema
│
├── index.php                       # Entry point / homepage
├── login.php                       # Login page
├── logout.php                      # Logout functionality
│
└── README.md                       # Project documentation



▶️ How to Run the Project
1. Clone the repository
git clone https://github.com/chaitu4206/Salary-Management-System.git
cd Salary-Management-System

3. Setup environment

Install XAMPP or any local server

Start Apache and MySQL

3. Configure database

Open phpMyAdmin

Import sal_mgmt_sys.sql

4. Run the project

Place project folder in htdocs

Open browser and go to:

http://localhost/Salary-Management-System
