# php-ecommerce-website
A simple and functional E-Commerce Website built using PHP, MySQL, HTML, and CSS. This project includes essential shopping features such as user login, product browsing, add-to-cart system, and an admin dashboard for managing products.

⭐ Features
👤 User Features
User Registration & Login
Browse Products with Images
Add to Cart
View & Update Cart Quantities
Responsive product layout
Secure session handling
User Logout

🛠️ Admin Features
Admin Login
Add New Products
Edit / Delete Products

🧩 Tech Stack
| Layer              | Technology                  |
| ------------------ | --------------------------- |
| **Frontend**       | HTML, CSS                   |
| **Backend**        | PHP                         |
| **Database**       | MySQL                       |
| **Authentication** | PHP Sessions                |
| **Deployment**     | Localhost (XAMPP)           |

📁 Project Structure
/index.php            -> Home page / product display
/login.php            -> User login
/register.php         -> User sign-up
/cart.php             -> Shopping cart logic
/logout.php           -> User logout
/adminlogin.php       -> Admin authentication
/add_product.php      -> Add products (Admin)
/manage_products.php  -> View, edit, delete products
/db.php               -> Database connection file
/styles.css           -> Website styling
/uploads/             -> Uploaded product images

⚙️ How to Run the Project
1️⃣ Prerequisites
XAMPP installed
Apache enable
MySQL enabled
2️⃣ Setup Steps
1. Clone or download the project:
  git clone <your-repository-link>
2. Move the folder to:
htdocs/ ( using XAMPP)
3. Import the database:
Open phpMyAdmin
Create a database (example: ecommerce_db)
Import your .sql file (if included)
4. Configure DB credentials in db.php:
    $conn = new mysqli("localhost", "root", "", "ecommerce_db");
5. Run in the browser:
http://localhost/<your-project-folder>/
📸 Screenshots

<img width="1682" height="948" alt="image" src="https://github.com/user-attachments/assets/297b60e4-3690-4095-978a-2acca3ced1d1" />
















