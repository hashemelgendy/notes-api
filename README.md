# Notes API

A simple Laravel-based RESTful & GraphQL APIs for managing notes. Built with Docker and Make for easy setup and local development.

---

## 📦 Requirements
- [Docker](https://www.docker.com/) installed and running
---

## 🚀 Quick Start

1. Clone the repo
    ```bash
    git clone git@github.com:hashemelgendy/notes-api.git
    ```  
2. Run the setup from your terminal/cmd (first time only):

**MacOS**
```bash
./setup.sh
```

**Linux**
```bash
make setup
```

**Windows**
```bat
setup.bat
```

This will:

- Start Docker containers
- Install dependencies
- Copy `.env.docker` → `.env`
- Generate app key
- Run migrations and seeders  

After the initial setup, only run **up** command to start the containers and **down** command to shut them down.

---

## 🛠 MacOS Commands

| Command      | Description                                     |
|--------------|-------------------------------------------------|
| `bin/setup`  | Build/start containers, Initial Setup           |
| `bin/up`     | Start up the project                            |
| `bin/down`   | Stop containers and network                     |
| `bin/remove` | Stop and delete containers, volumes and network |
| `bin/fresh`  | Reset DB and reseed (`migrate:fresh --seed`)    |

---

## 🛠 Linux Commands

| Command        | Description                                     |
|----------------|-------------------------------------------------|
| `make setup`   | Build/start containers, Initial Setup           |
| `make up`      | Start up the project                            |
| `make down`    | Stop containers and network                     |
| `make remove`  | Stop and delete containers, volumes and network |
| `make fresh`   | Reset DB and reseed (`migrate:fresh --seed`)    |

---

## 🛠 Windows Commands

| Command          | Description                                     |
|------------------|-------------------------------------------------|
| `bin\setup.bat`  | Build/start containers, Initial Setup           |
| `bin\up.bat`     | Start up the project                            |
| `bin\down.bat`   | Stop containers and network                     |
| `bin\remove.bat` | Stop and delete containers, volumes and network |
| `bin\fresh.bat`  | Reset DB and reseed (`migrate:fresh --seed`)    |

---

## ✅ Features

- User registration & authentication (via REST and GraphQL)
- Secure token-based access (Bearer token)
- Create, view, update, and delete notes (CRUD)
- RESTful API endpoints
- GraphQL endpoints using Lighthouse
- Dockerized setup for local development
- Supports MacOS, Linux, and Windows environments

## 📫 API Collection

You can import this collection into **any API client** such as [Postman](https://www.postman.com/) or [Insomnia](https://insomnia.rest/) to explore and test all endpoints easily.

🔗 [Download Notes API Collection](./docs/Notes-API.json)
