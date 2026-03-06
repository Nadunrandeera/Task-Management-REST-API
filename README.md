## API Endpoints

The project includes simple JSON API endpoints using Vanilla PHP + PDO.

### Endpoints
- `GET /api/tasks.php`
- `POST /api/tasks.php`
- `GET /api/task.php?id=1`
- `PUT /api/task.php?id=1`
- `DELETE /api/task.php?id=1`

### Notes
- API authentication uses PHP session-based login
- Users must be logged in before accessing API endpoints
- Responses are returned in JSON format
