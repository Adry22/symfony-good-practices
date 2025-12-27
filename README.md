# Symfony Good Practices

A Symfony 6.4 application demonstrating best practices in software architecture, including Hexagonal Architecture, Domain-Driven Design (DDD), CQRS, and comprehensive testing strategies.

[![CircleCI](https://img.shields.io/badge/CI-CircleCI-green.svg)](https://circleci.com)
[![PHP Version](https://img.shields.io/badge/PHP-8.2-blue.svg)](https://www.php.net/)
[![Symfony Version](https://img.shields.io/badge/Symfony-6.4-black.svg)](https://symfony.com/)

## 📋 Table of Contents

- [Features](#-features)
- [Architecture](#-architecture)
- [Tech Stack](#-tech-stack)
- [Prerequisites](#-prerequisites)
- [Installation](#-installation)
- [Usage](#-usage)
- [API Documentation](#-api-documentation)
- [Project Structure](#-project-structure)
- [Architecture Decision Records](#-architecture-decision-records)
- [Development](#-development)

## ✨ Features

### Core Functionality
- **User Management**: Registration with email validation, profile management with address
- **Planet Catalog**: List, filter, and search planets
- **Document Generation**: Export data to Excel (.xlsx) and Word (.docx) formats
- **JWT Authentication**: Stateless authentication for API endpoints

### Architecture Patterns
- **Hexagonal Architecture** (Ports & Adapters)
- **Domain-Driven Design** tactical patterns
- **CQRS** (Command Query Responsibility Segregation)
- **Event-Driven Architecture** with Domain Events
- **Repository Pattern** for data access
- **Specification Pattern** for complex queries
- **Value Objects** for domain primitives

### Quality Assurance
- **Unit Tests** with PHPUnit
- **Integration Tests** for repositories and services
- **Functional Tests** for API endpoints
- **BDD Tests** with Behat
- **Static Analysis** with PHPStan (Level 5)
- **Continuous Integration** with CircleCI

## 🏗 Architecture

This project follows **Hexagonal Architecture** principles with clear separation between:

```
┌─────────────────────────────────────────────────┐
│            Infrastructure Layer                  │
│  (Controllers, Repositories, External Services) │
└──────────────────┬──────────────────────────────┘
                   │
┌──────────────────▼──────────────────────────────┐
│            Application Layer                     │
│     (Use Cases: Commands & Queries)             │
└──────────────────┬──────────────────────────────┘
                   │
┌──────────────────▼──────────────────────────────┐
│              Domain Layer                        │
│    (Entities, Value Objects, Domain Logic)      │
└─────────────────────────────────────────────────┘
```

### Key Architectural Decisions

All architectural decisions are documented in [Architecture Decision Records](docs/adr/README.md):

- [ADR-0001](docs/adr/0001-use-hexagonal-architecture-with-ddd.md) - Hexagonal Architecture with DDD
- [ADR-0002](docs/adr/0002-implement-cqrs-pattern-with-tactician.md) - CQRS with Tactician
- [ADR-0003](docs/adr/0003-use-value-objects-for-domain-primitives.md) - Value Objects
- [ADR-0004](docs/adr/0004-implement-domain-events-with-event-bus.md) - Domain Events
- And [18 more ADRs](docs/adr/README.md)...

### Bounded Contexts

The application is organized into bounded contexts:

- **User Context**: User registration, authentication, and profile management
- **Planet Context**: Planet catalog and search functionality
- **Shared Context**: Cross-cutting concerns (ValueObjects, Bus interfaces, etc.)

## 🛠 Tech Stack

### Core
- **PHP 8.2+**
- **Symfony 6.4** (Framework Bundle, Console, Validator)
- **MySQL 8.0**
- **Nginx** (Web server)
- **Docker & Docker Compose**

### Domain & Application
- **Tactician** - Command/Query bus
- **Ramsey UUID** - UUID generation
- **Monolog** - Structured logging

### Infrastructure
- **Doctrine ORM** - Database persistence
- **Doctrine Migrations** - Schema versioning
- **Lexik JWT Authentication** - JWT tokens
- **FOS REST Bundle** - REST API utilities
- **JMS Serializer** - Object serialization

### Development & Testing
- **PHPUnit** - Unit & integration testing
- **Behat** - BDD acceptance testing
- **PHPStan** - Static analysis
- **Doctrine Fixtures** - Test data
- **Faker** - Fake data generation

### Documentation
- **Nelmio API Doc** - OpenAPI/Swagger documentation
- **PhpOffice (PhpSpreadsheet & PhpWord)** - Document generation

## 📦 Prerequisites

- **Docker** >= 20.10
- **Docker Compose** >= 1.29
- **Make** (optional, for shortcuts)
- **Git**

## 🚀 Installation

### 1. Clone the repository

```bash
git clone https://github.com/Adry22/symfony-good-practices.git
cd symfony-good-practices
```

### 2. Start Docker containers

```bash
make up
# OR
docker-compose up -d
```

This will start:
- **Nginx** on port `8080`
- **PHP-FPM** on port `9000`
- **MySQL** on port `4306`
- **Swagger UI** on port `9001`
- **Mailcatcher** on ports `1080` (web) and `1025` (SMTP)

### 3. Install dependencies

```bash
docker exec symfony_good_practices_app composer install
```

### 4. Generate JWT keys

```bash
docker exec symfony_good_practices_app bash -c "
    php bin/console lexik:jwt:generate-keypair
"
```

### 5. Create database and run migrations

```bash
docker exec symfony_good_practices_app bash -c "
    php bin/console doctrine:database:create --if-not-exists &&
    php bin/console doctrine:migrations:migrate --no-interaction
"
```

### 6. Load fixtures (optional)

```bash
docker exec symfony_good_practices_app php bin/console doctrine:fixtures:load --no-interaction
```

## 💻 Usage

### Access the application

- **API**: http://localhost:8080
- **Swagger UI**: http://localhost:9001
- **Mailcatcher**: http://localhost:1080

## 📚 API Documentation

### OpenAPI Specification

The API is documented using OpenAPI 3.0 specification.

#### Generate documentation

```bash
make build_doc
# OR
docker exec symfony_good_practices_app composer run docs
```

This generates `public/universe.yaml`

#### View documentation

1. **Swagger UI**: Visit http://localhost:9001
2. **YAML file**: Download from http://localhost:8080/universe.yaml

### API Documentation Features

- Request/response schemas
- Authentication requirements
- Parameter descriptions
- Response codes
- Example requests

## 📁 Project Structure

```
symfony-good-practices/
├── config/                 # Symfony configuration
│   ├── packages/          # Bundle configurations
│   └── routes.yaml        # Route definitions
├── docker/                # Docker configuration
│   ├── Dockerfile         # PHP-FPM image
│   └── php.ini           # PHP configuration
├── docs/                  # Documentation
│   └── adr/              # Architecture Decision Records
├── migrations/            # Doctrine migrations
├── nginx/                 # Nginx configuration
├── public/                # Public assets
│   ├── index.php         # Entry point
│   └── universe.yaml     # OpenAPI spec
├── src/                   # Source code
│   ├── App/              # Kernel
│   ├── Planet/           # Planet bounded context
│   │   ├── Application/  # Use cases (Commands/Queries)
│   │   ├── Domain/       # Business logic
│   │   └── Infrastructure/ # Adapters (Controllers, Repositories)
│   ├── User/             # User bounded context
│   │   ├── Application/
│   │   ├── Domain/
│   │   └── Infrastructure/
│   └── Shared/           # Shared kernel
│       ├── Domain/       # Domain interfaces
│       └── Infrastructure/ # Shared infrastructure
├── tests/                 # Test suite
│   ├── Behat/            # BDD contexts
│   ├── Common/           # Test utilities
│   │   ├── Builder/      # Test builders
│   │   └── Controller/   # Test base classes
│   ├── Planet/           # Planet tests
│   ├── User/             # User tests
│   └── features/         # Behat features
├── .circleci/            # CircleCI configuration
├── .env                  # Environment variables
├── composer.json         # PHP dependencies
├── docker-compose.yml    # Docker services
├── Makefile             # Development commands
├── phpstan.neon         # Static analysis config
├── phpunit.xml.dist     # PHPUnit configuration
└── README.md            # This file
```

### Context Structure

Each bounded context follows the same structure:

```
src/{Context}/
├── Application/           # Application layer
│   ├── Command/          # Write operations
│   │   └── {UseCase}/
│   │       ├── {UseCase}Command.php
│   │       ├── {UseCase}CommandHandler.php
│   │       └── {UseCase}Exception.php
│   ├── Query/            # Read operations
│   │   └── {UseCase}/
│   │       ├── {UseCase}Query.php
│   │       ├── {UseCase}QueryHandler.php
│   │       ├── {UseCase}Result.php
│   │       └── {UseCase}Resource.php
│   └── EventListener/    # Domain event subscribers
├── Domain/               # Domain layer
│   ├── Entity/          # Aggregates and entities
│   ├── Event/           # Domain events
│   ├── Repository/      # Repository interfaces (ports)
│   ├── Service/         # Domain services
│   └── ValueObject/     # Value objects
└── Infrastructure/       # Infrastructure layer
    ├── Controller/      # HTTP controllers
    ├── Repository/      # Repository implementations
    ├── Type/           # Doctrine custom types
    └── Writer/         # File writers
```

## 📖 Architecture Decision Records

All significant architectural decisions are documented in ADRs:

- **What**: Documents important architectural decisions
- **Why**: Provides context and reasoning
- **When**: Captures date and circumstances
- **Consequences**: Lists trade-offs and impacts

View all ADRs in [docs/adr/](docs/adr/README.md)

### Key ADRs

| ADR | Title | Status |
|-----|-------|--------|
| [0001](docs/adr/0001-use-hexagonal-architecture-with-ddd.md) | Hexagonal Architecture with DDD | Accepted |
| [0002](docs/adr/0002-implement-cqrs-pattern-with-tactician.md) | CQRS with Tactician | Accepted |
| [0003](docs/adr/0003-use-value-objects-for-domain-primitives.md) | Value Objects | Accepted |
| [0004](docs/adr/0004-implement-domain-events-with-event-bus.md) | Domain Events | Accepted |
| [0007](docs/adr/0007-use-jwt-for-stateless-authentication.md) | JWT Authentication | Accepted |
| [0008](docs/adr/0008-use-uuid-v4-for-entity-identifiers.md) | UUID Identifiers | Accepted |
| [0019](docs/adr/0019-organize-code-by-bounded-context.md) | Bounded Contexts | Accepted |

## 🔧 Development

### Code Quality

This project enforces high code quality standards:

- **PHPStan Level 5**: Static analysis catches potential bugs
- **Type Hints**: All methods use strict types
- **Value Objects**: Domain primitives are properly encapsulated
- **Immutability**: Value objects and events are immutable
- **SOLID Principles**: Applied throughout the codebase

### Testing Strategy

```
Unit Tests (Fast, Isolated)
    ├── Domain/Entity/
    ├── Domain/ValueObject/
    └── Application/Command|Query/

Integration Tests (Medium, With Infrastructure)
    ├── Infrastructure/Repository/
    └── Application/EventListener/

Functional Tests (Slow, Full Stack)
    └── Infrastructure/Controller/

Acceptance Tests (BDD, User Stories)
    └── features/
```

### Continuous Integration

CircleCI pipeline runs on every commit:

1. ✅ Install dependencies (with caching)
2. ✅ Run PHPStan static analysis
3. ✅ Run database migrations
4. ✅ Load fixtures
5. ✅ Run PHPUnit tests
6. ✅ Store test results