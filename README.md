# Notes API

A simple Laravel-based RESTful API for managing notes. Built with Docker and Make for easy setup and local development.

---

## 🚀 Quick Start

1. Clone the repo  
    ```bash
    git clone git@github.com:hashemelgendy/notes-api.git
    ```  
3. Run (First time only):

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

## 📫 API Collection

You can import this collection into **any API client** such as [Postman](https://www.postman.com/) or [Insomnia](https://insomnia.rest/) to explore and test all endpoints easily.

🔗 [Download Notes API Collection](./docs/Notes-API.json)
