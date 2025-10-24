# Contractor Connector - Final Project for CS4750

A database-backed application originally developed for CS 4750 (Database Systems) at the University of Virginia. ContractorConnector connects customers to contractors of all specialties to bring their home improvement ideas to life. This version includes Docker support for easy setup and testing with dummy seed data.

---

## Table of Contents

- [Features](#features)
- [Tech Stack](#tech-stack)
- [Getting Started](#getting-started)
- [Acknowledgments](#acknowledgments)

---

## Features

- Apache web server with synced PHP code
- Dockerized MySQL database
- Preloaded dummy data for testing and exploration
- Relational Schema for database models
- Permission based access control

---

## Tech Stack

| Component     | Description                        |
|---------------|------------------------------------|
| MySQL         | Relational database                |
| Apache + PHP  | Web server and backend scripting   |
| Docker        | Containerized deployment           |
| SQL           | Schema and data scripts            |
| CSS           | Custom page styling                |

---

## Getting Started

### Prerequisites

- [Docker](https://www.docker.com/get-started) installed on your machine

### Clone the Repository

```bash
git clone https://github.com/jad7qt/ContractorConnector.git
cd ContractorConnector
```

### Run with Docker

```bash
docker-compose up --build
```

This will:
- Build and start the Apache web server (exposed on port 8080)
- Start the MySQL database with schema and seed data loaded
- Sync the local code into the container for live edits

### Access the Web App

Open your browser and visit:
[http://localhost:8080](http://localhost:8080)

---

## Acknowledgments

This project was completed as a group assignment for **CS 4750: Database Systems** at the **University of Virginia**. Created by Jared Dutt, Martin Crow, Danny Pellei, and Walker Pollard. 

