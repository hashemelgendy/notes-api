# Notes API

A simple Laravel-based RESTful API for managing notes. Built with Docker and Make for easy setup and local development.

---

## 🚀 Quick Start

1. Clone the repo
2. Run:

    ```bash
    make up
    ```

   This will:

    - Start Docker containers
    - Install dependencies
    - Copy `.env.docker` → `.env`
    - Generate app key
    - Run migrations and seeders

---

## 🛠 Makefile Commands

| Command      | Description                                      |
|--------------|--------------------------------------------------|
| `make up`    | Build/start containers, setup Laravel project    |
| `make down`  | Stop containers and network                      |
| `make fresh` | Reset DB and reseed (`migrate:fresh --seed`)     |

---

## API Endpoints

**Base URL:** `http://localhost:8001/api`

### Auth

- `POST /register` – Register new user
- `POST /login` – Login and receive bearer token

### Notes

- `GET /notes` – List all notes (**auth required**)
- `POST /notes` – Create a new note
- `GET /notes/{id}` – Get a single note
- `PUT /notes/{id}` – Update a note
- `DELETE /notes/{id}` – Delete a note

### Auth Header

Use the following header for protected routes:

```http
Authorization: Bearer <token>
