# To-Do List App
A full-stack To-Do List application built with PHP (Symfony) backend using Domain-Driven Design (DDD) principles, and a Svelte frontend. 
Users can add, edit, delete, and mark tasks as complete .


## Features
-Add new tasks
-Edit task titles
-Delete tasks
-Mark tasks as completed
-Real-time updates in the frontend
-Error handling and success messages
-Modal for editing tasks
-Responsive UI with TailwindCSS



## Tech Stack used
### Frontend:
- Svelte
- Tailwind
- FontAwesome Icons

### Backend:
-PHP(symfony)
- Doctrine ORM
## Software Development Approach
- Used Domain Driven Design for the design of this App.

## Installation/ Setup 
### Backend

-Clone the repository:
```
git clone <repo-url>
cd backend
```

-Install dependencies:
```
composer install

```
-Set up your .env file for database connection.

-Run migrations (if applicable):
```
php bin/console doctrine:migrations:migrate
```

-Start the server:
```
symfony server:start
```
### Frontend

-Navigate to the frontend folder:
```
cd frontend
```
-Install dependencies:
```
npm install
```

-Start the dev server:
```
npm run dev
```

Open the browser at http://localhost:5173.

## Usage 
- Add a task using the input field at the top.
- Edit a task by clicking the edit icon. When the icon is cliked, a modal will appear.
- Delete a task using the trashcan icon.
- Mark a task as completed by clicked on the check icon. If the check icon is cliked again, the task us mark as incomplete.
- Tasks update in real-time without needing to relaod the page.

## Project Structure

project-root
- ┣ backend
- ┃ ┣ src
- ┃ ┃ ┣ Domain
- ┃ ┃ ┣ Application
- ┃ ┃ ┃ ┗ UseCases
- ┃ ┃ ┣ Infrastructure
- ┃ ┃ ┃ ┗ Persistence
- ┃ ┃ ┗ Presentation
- ┃ ┃   ┗ Controller
- ┃ ┗ composer.json
- ┣ frontend
- ┃ ┣ src
- ┃ ┃ ┣ components
- ┃ ┃ ┣ lib
- ┃ ┃ ┗ App.svelte
- ┃ ┗ package.json
- ┗ README.md

## Notes

- Backend API is CORS-enabled for local dev.
- Editing a task only updates the title (PATCH request).
- Success and error messages are handled in the frontend.
- DDD structure separates domain logic from presentation.

## License 
MIT License



