# 🚀 Grouping System

A web-based application for lecturers and students to manage academic and social groups, built as a capstone project for the Full-Stack Programming course.

---
## Tech Stack

This project was built from scratch, adhering to strict course guidelines that prohibit the use of frameworks.

![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/mysql-%2300f.svg?style=for-the-badge&logo=mysql&logoColor=white)
![jQuery](https://img.shields.io/badge/jquery-%230769AD.svg?style=for-the-badge&logo=jquery&logoColor=white)
![JavaScript](https://img.shields.io/badge/javascript-%23323330.svg?style=for-the-badge&logo=javascript&logoColor=%23F7DF1E)
![HTML5](https://img.shields.io/badge/html5-%23E34F26.svg?style=for-the-badge&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/css3-%231572B6.svg?style=for-the-badge&logo=css3&logoColor=white)

---
## Key Features

* **Secure User Authentication:** Full login/logout system with session management and hashed passwords.
* **Role-Based Access Control:** Distinct dashboards and permissions for **Admin**, **Lecturer**, and **Student** roles.
* **Comprehensive Admin Panel:** Full CRUD (Create, Read, Update, Delete) functionality for managing lecturers and students.
* **Server-Side Pagination:** Efficiently handles large lists of users in the admin panel.
* **Group Management:** Lecturers can create and manage groups.
* **Event Creation:** Lecturers can post events within their groups.
* **Dynamic Chat System:** Real-time chat threads within groups, powered by Ajax.
* **Fully Responsive Design:** The layout adapts to all screen sizes, from mobile phones to desktops, using modern CSS (Flexbox & Grid).

---
## Setup and Installation

To run this project locally, follow these steps:

1.  **Prerequisites:** Make sure you have a local server environment like [XAMPP](https://www.apachefriends.org/index.html) installed.

2.  **Clone the repository:**
    ```bash
    git clone https://your-repository-url/grouping-system.git
    ```

3.  **Database Setup:**
    * Start Apache and MySQL in your XAMPP control panel.
    * Open phpMyAdmin by navigating to `http://localhost/phpmyadmin`.
    * Create a new database named `fullstack`.
    * Import the provided SQL script (`database.sql`) to set up all the necessary tables.

4.  **Project Setup:**
    * Move the cloned `grouping-system` folder into your XAMPP `htdocs` directory.
    * Open your web browser and navigate to `http://localhost/grouping-system/`.

5.  **Admin Login:**
    * Username: `admin`
    * Password: `admin123`

---
## Contributor

* [Your Name](https://github.com/your-username)
