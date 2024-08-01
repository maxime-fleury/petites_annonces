# Project Name: Petites Annonces

## Description
Petites Annonces is a simple PHP-based web application for managing classified ads. It allows users to browse, add, edit, delete, and search for advertisements. The application uses a `controllerManager` class to manage routes and handle various actions.

## Features
- User Registration and Login
- Adding, Editing, and Deleting Ads
- Viewing Ads in List and Detail Views
- Searching for Ads
- User-specific Ads Management
- Responsive Design using Bootstrap

## Requirements
- PHP 7.4 or higher
- MySQL or any compatible database
- Web server (e.g., Apache, Nginx)

## Installation
1. **Clone the Repository:**
   ```sh
   git clone https://github.com/yourusername/petites_annonces.git
   cd petites_annonces
   ```

2. **Configure Database:**
   - Create a database and import the schema from `data/config.sql`.
   - Update the `data/config.php` file with your database credentials.

3. **Set Up Server:**
   - Place the project in your web server's root directory.
   - Ensure the server is configured to handle PHP files.

4. **Start the Server:**
   - If using a local server, start it (e.g., `php -S localhost:8000`).

## File Structure
- `index.php`: The main entry point of the application.
- `data/`: Contains configuration and data files.
  - `config.php`: Database configuration file.
  - Other PHP files for data management.
- `templates/`: Contains template files for different views.
- `controllerManager.php`: Core class for handling routes and controller logic.

## Usage
1. **Homepage:**
   - Navigate to the homepage to view the list of ads.

2. **User Registration and Login:**
   - Go to `/inscription` to register a new user.
   - Go to `/connexion` to log in.

3. **Managing Ads:**
   - Go to `/add` to add a new ad (requires login).
   - Go to `/edit` to edit an ad (requires login and ad ownership).
   - Go to `/delete` to delete an ad (requires login and ad ownership).

4. **Viewing Ads:**
   - View the list of ads on the homepage.
   - Click on an ad title to view details.

5. **Searching Ads:**
   - Use the search bar on the homepage to find specific ads.

6. **User-specific Ads:**
   - Go to `/my` to view all ads posted by the logged-in user.

## Example Routes
- `/`: Homepage displaying ads.
- `/index`: Another route for the homepage.
- `/inscription`: User registration page.
- `/connexion`: User login page.
- `/a/{id}`: Detailed view of a specific ad.
- `/add`: Form to add a new ad.
- `/edit/{id}`: Form to edit an existing ad.
- `/delete/{id}`: Delete an ad.
- `/search`: Search ads.
- `/my`: View user's ads.

## License
This project is licensed under the MIT License. See the `LICENSE` file for details.
