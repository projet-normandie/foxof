# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a personal game collection website for the player Foxof. The application displays a list of completed games with platform information, completion dates, and images. It's built with Symfony 8 and PHP 8.4.

**Important: The entire site is in French.** All user-facing content, labels, messages, and templates must be in French.

## Common Commands

### Development
```bash
make help           # Display all available commands
make serve          # Start Symfony dev server (background)
make serve-stop     # Stop dev server
make serve-log      # View server logs
```

### Database
```bash
make db-create      # Create database
make db-migrate     # Run migrations
make db-reset       # Full reset: drop, create, migrate, load fixtures
make db-rollback    # Revert last migration
```

### Code Quality
```bash
make qa             # Run all quality checks (phpcs + phpstan)
make phpcs          # Check code with PHP CodeSniffer (PSR-12)
make phpcs-fix      # Auto-fix coding standards
make phpstan        # Static analysis (level 8)
```

### Testing
```bash
make test                    # Run PHPUnit tests
make test-coverage           # Generate HTML coverage report (requires Xdebug)
php bin/phpunit --filter=TestName  # Run specific test
```

### Console Commands
```bash
php bin/console app:create-user     # Create a new user (interactive)
php bin/console doctrine:migrations:generate  # Generate new migration
php bin/console debug:router        # List all routes
php bin/console cache:clear         # Clear cache
```

## Architecture

### Entity Relationships

**Game → Platform (Many-to-One)**
- Each Game belongs to one Platform (required)
- Platform represents gaming platforms (PS5, Xbox, Nintendo, PC, etc.)

**Key Entity Fields:**
- `Game`: name, picture (URL), cover (URL), finishedAt (date), finishedTimes (int), isSearched (bool), platform
- `Platform`: name
- `User`: email, username, password, roles

All entities use Gedmo's TimestampableEntity trait for automatic `createdAt`/`updatedAt` management.

### Controller Structure

**Public Routes:**
- `/` - HomeController displays games where `finishedTimes > 0`, sorted by completion date DESC

**Admin Routes (require ROLE_ADMIN):**
- `/admin/platform` - CRUD for platforms with pagination (20 items/page)
- `/admin/game` - CRUD for games with pagination (20 items/page)

**Security Routes:**
- `/login` - Form-based authentication with CSRF protection
- `/logout` - Handled by security firewall

### Security Configuration

**Authentication:**
- Custom UserProvider (`App\Security\UserProvider`)
- Form login with CSRF protection
- Password hashing with auto algorithm (bcrypt/argon2)

**Access Control:**
- `/login` → PUBLIC_ACCESS
- `/admin` → ROLE_ADMIN
- Role hierarchy: ROLE_ADMIN includes ROLE_LOG_READER

### Database Configuration

Default: PostgreSQL (configured in `.env`)
```
DATABASE_URL="postgresql://app:!ChangeMe!@127.0.0.1:5432/app?serverVersion=16&charset=utf8"
```

Uses Doctrine ORM with:
- Attribute-based mapping
- Doctrine Migrations for schema management
- Underscore naming strategy

### Code Style Requirements

**All PHP files must:**
- Start with `declare(strict_types=1);`
- Follow PSR-12 coding standard
- Pass PHPStan level 8 analysis
- Use type hints for parameters and return values
- Use PHP 8 attributes (not annotations)

**Example entity/controller structure:**
```php
<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ExampleController extends AbstractController
{
    #[Route('/path', name: 'route_name')]
    public function index(): Response
    {
        // Implementation
    }
}
```

### Forms and Validation

Forms are built using FormType classes:
- `PlatformType`: Simple form with name field
- `GameType`: Complex form with platform selector, images, dates, completion counter

Validation uses Symfony's Assert attributes on entity properties.

### Pagination

Admin lists use KnpPaginatorBundle:
```php
$pagination = $paginator->paginate(
    $queryBuilder,
    $request->query->getInt('page', 1),
    20 // items per page
);
```

### Flash Messages

Controllers use flash messages for user feedback:
```php
$this->addFlash('success', 'Platform créée avec succès.');
```

### Frontend

**Template Structure:**
- `templates/base.html.twig` - Root layout
- `templates/admin/base.html.twig` - Admin layout (extends base)
- Public pages extend `base.html.twig`
- Admin pages extend `admin/base.html.twig`

**Assets:**
- Stimulus.js for JavaScript interactivity
- Turbo (Hotwire) for SPA-like navigation
- Tailwind CSS for styling
- Asset Mapper (no build step required)

### Development Workflow

1. **Adding a new entity:**
   - Create in `src/Entity/` with Doctrine attributes
   - Generate migration: `php bin/console doctrine:migrations:generate`
   - Run migration: `make db-migrate`

2. **Adding a CRUD controller:**
   - Create controller in `src/Controller/` or `src/Controller/Admin/`
   - Use `#[Route]` attributes for routing
   - Create corresponding form type in `src/Form/`
   - Create Twig templates in `templates/`

3. **Creating a console command:**
   - Extend `Command` class in `src/Command/`
   - Use `#[AsCommand]` attribute
   - Implement `execute()` method

## Important Notes

- This is a personal project for tracking Foxof's completed games
- The home page displays only finished games (`finishedTimes > 0`)
- Admin area requires authentication with ROLE_ADMIN
- All code must pass `make qa` before committing
- Game images are stored as URLs (external hosting)
- French locale used for Doctrine extensions (`fr_FR`)
