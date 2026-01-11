# S4_B2_Blog_Management

A powerful and intuitive Blog Management System built with PHP. This project allows users to read, write, and manage blog posts with integrated role-based access control, comments, and likes.

## 🚀 Features

- **User Authentication**: Secure signup and login for all users.
- **Role-Based Access Control**:
  - **Admin**: Full control over categories and system settings.
  - **Author**: Create, edit, and delete their own articles.
  - **Reader**: View articles, leave comments, and like posts.
- **Article Management**: Full CRUD operations for authors.
- **Engagement Tools**:
  - **Comments**: Readers can engage with posts by leaving comments.
  - **Likes**: Interactive liking system to track popular posts.
- **Custom Router**: A lightweight, custom-built router for clean URI management.
- **Responsive Views**: Clean and modern UI for all dashboards (Admin, Author, Reader).

## 🛠️ Tech Stack

- **Backend**: PHP (MVC-inspired architecture)
- **Database**: MySQL
- **Routing**: Custom "Simple Router"
- **Styling**: Modern CSS



## ⚙️ Installation & Setup

1.  **Clone the repository**:
    ```bash
    git clone <repository-url>
    cd S4_B2_Blog_Management
    ```

2.  **Database Setup**:
    - Import the schema from [Sql/Schema.sql] into your MySQL database.
    - Create a `.env` file in the root directory and configure your database credentials:
      ```env
      DB_HOST=localhost
      DB_NAME=blog
      DB_USER=root
      DB_PASS=
      ```

3.  **Run with PHP Server**:
    If you have PHP installed, you can start a local development server from the `Public` directory:
    ```bash
    php -S localhost:8000 -t Public
    ```
    Alternatively, configure a virtual host (e.g., Apache/Nginx) pointing to the `Public` folder.

## 🛣️ Routing

The application uses a simple router that supports fixed URIs. Routes are defined in [Public/index.php].

Example Route Declaration:
```php
$router->get('/articles', "ArticleController@index");
```


