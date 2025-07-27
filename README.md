# Whisper Secret Sharing

Whisper is a simple PHP web application for sharing secrets securely, one time only. Each secret can be viewed only once—after it's accessed, it's deleted from the database forever.

## Features

- **One-time secret viewing:** Secrets are destroyed after being viewed.
- **Simple, clean UI:** Modern design with clear feedback messages.
- **XSS protection:** Secrets are safely displayed using HTML escaping.
- **Easy setup:** Minimal configuration required.

## How It Works

1. A user submits a secret.
2. The app generates a unique URL containing a secret ID.
3. The recipient visits the URL to view the secret.
4. The secret is displayed once and then deleted from the database.

## Getting Started

### Prerequisites

- PHP 7.x or newer
- MySQL server
- Web server (e.g., Apache or PHP's builtin)

### Setup

1. **Clone the repository:**
   ```bash
   git clone https://github.com/Geetansh01/whisper-prj.git
   ```
2. **Import the database:**
   - Create a MySQL database named `whisper`.
   - Create a table named `secret`:
     ```sql
     CREATE TABLE secret (
         id INT AUTO_INCREMENT PRIMARY KEY,
         secret Varchar(200)
     );
     ```
3. **Configure database credentials:**
   - Edit `viewSecret.php` and update the `$username`, `$password`, and `$host` variables if needed.

4. **Deploy to your web server:**
   - Place the files in your web root directory.

5. **Access the app:**
   - Visit `http://<yourserver-URL>/viewSecret.php?secret_msg_id=YOUR_ID` to view a secret.

## Security Notes

- **SQL Injection:** The current implementation is for demonstration and is vulnerable to SQL injection. Use prepared statements for production.
- **No authentication:** Anyone with the secret URL can access the secret once.
- **No HTTPS:** Always use HTTPS in production to protect secrets in transit.

**Whisper** &copy;
