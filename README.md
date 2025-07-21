# Notes API

A simple Laravel-based RESTful API for managing notes. Built with Docker and Make for easy setup and local development.

---

## 🚀 Quick Start

1. Clone the repo
2. Run (First time only):

    ```bash
    make setup
    ```

   This will:

    - Start Docker containers
    - Install dependencies
    - Copy `.env.docker` → `.env`
    - Generate app key
    - Run migrations and seeders

---

## 🛠 Makefile Commands

| Command       | Description                                     |
|---------------|-------------------------------------------------|
| `make setup`  | Build/start containers, Initial Setup           |
| `make up`     | Start up the project                            |
| `make down`   | Stop containers and network                     |
| `make remove` | Stop and delete containers, volumes and network |
| `make fresh`  | Reset DB and reseed (`migrate:fresh --seed`)    |

---

## API Endpoints

**Base URL:** `http://localhost:8001/api`  
**GraphQL URL:** `http://localhost:8001/graphql`

## REST

### Auth

- `POST /register` – Register new user
- `POST /login` – Login and receive bearer token
- 
### Notes REST (**Auth required**)

- `GET /notes` – List all notes
- `POST /notes` – Create a new note
- `GET /notes/{id}` – Get a single note
- `PUT /notes/{id}` – Update a note
- `DELETE /notes/{id}` – Delete a note


## GraphQL

### Auth

- `register` – Register new user
- `login` – Login and receive bearer token

### Notes (**Auth required**)

- `myNotes` – List authenticated user notes
- `note` – fetch single note
- `createNote` – Create a new note
- `updateNote` – Update a note
- `deleteNote` – Delete a note

### Auth Header

Use the following header for protected routes:

```http
Authorization: Bearer <token>
