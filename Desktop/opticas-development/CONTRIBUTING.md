# Contributing to Opticas-Development

Thank you for your interest in contributing to Opticas-Development! This document provides guidelines and instructions for contributing to the project.

---

## Table of Contents

- [Getting Started](#getting-started)
- [Development Workflow](#development-workflow)
- [Coding Standards](#coding-standards)
- [Commit Guidelines](#commit-guidelines)
- [Pull Request Process](#pull-request-process)
- [Testing Guidelines](#testing-guidelines)
- [Code Review Process](#code-review-process)
- [Documentation](#documentation)
- [Reporting Issues](#reporting-issues)
- [Asking Questions](#asking-questions)

---

## Getting Started

### Prerequisites

Before contributing, ensure you have:

- **PHP 8.1+** installed
- **Composer** installed
- **Docker** and **Docker Compose** (recommended) or local MySQL
- **Git** configured
- **Code editor/IDE** (VSCode, PHPStorm, etc.)

### Setup Development Environment

#### 1. Fork the Repository

```bash
# Fork the repository on GitHub
git clone https://github.com/YOUR_USERNAME/opticas-development.git
cd opticas-development
```

#### 2. Add Upstream Remote

```bash
git remote add upstream https://github.com/ORIGINAL_OWNER/opticas-development.git
```

#### 3. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node dependencies (if applicable)
npm install
```

#### 4. Configure Environment

```bash
cp .env.example .env
nano .env  # Configure your local settings
```

#### 5. Start Development Server

**Using Docker:**

```bash
docker-compose up -d
```

**Using Local Server:**

```bash
# Start PHP built-in server
php spark serve

# Or use FrankenPHP
php -S localhost:8080 -t public
```

Access the application at `http://localhost:8080`

---

## Development Workflow

### 1. Create Feature Branch

```bash
# Sync with upstream
git fetch upstream
git checkout main
git merge upstream/main

# Create feature branch
git checkout -b feature/your-feature-name
# Or
git checkout -b fix/your-bug-fix
```

### 2. Make Changes

- Write clean, documented code
- Follow coding standards (see below)
- Write tests for new functionality
- Update documentation as needed

### 3. Test Locally

```bash
# Run linter
composer lint

# Run tests
composer test

# Check code style
composer cs:check
```

### 4. Commit Changes

Follow commit guidelines (see below)

### 5. Push to Fork

```bash
git push origin feature/your-feature-name
```

### 6. Create Pull Request

Open a PR from your fork to the upstream repository.

---

## Coding Standards

### PHP Standards

We follow **PSR-12** coding standards for PHP.

#### Naming Conventions

| Type | Convention | Example |
|------|-------------|----------|
| Classes | PascalCase | `SaleController`, `SaleService` |
| Methods | camelCase | `createSale()`, `getPatient()` |
| Variables | camelCase | `$totalPrice`, `$customerId` |
| Constants | UPPER_SNAKE_CASE | `MAX_STOCK`, `DEFAULT_TAX` |
| Database Tables | snake_case | `sale_items`, `patient_phones` |

#### Example Code Structure

```php
<?php

namespace App\Services;

use CodeIgniter\Database\BaseBuilder;

/**
 * Sale Service
 * 
 * Handles business logic for sales operations.
 * 
 * @package App\Services
 * @author Your Name <email@example.com>
 * @since 1.0.0
 */
class SaleService
{
    protected SaleModel $saleModel;
    protected SaleItemService $saleItemService;
    
    /**
     * Constructor
     * 
     * @param SaleModel $saleModel Sale model
     * @param SaleItemService $saleItemService Sale item service
     */
    public function __construct(SaleModel $saleModel, SaleItemService $saleItemService)
    {
        $this->saleModel = $saleModel;
        $this->saleItemService = $saleItemService;
    }
    
    /**
     * Create a new sale
     * 
     * @param array $data Sale data
     * @return Sale|false Created sale or false on failure
     */
    public function create(array $data): Sale|false
    {
        try {
            // Start transaction
            $this->saleModel->db->transStart();
            
            // Create sale record
            $sale = new Sale($data);
            $this->saleModel->save($sale);
            
            // Process items
            $itemsProcessed = $this->saleItemService->setSaleItems($sale, $data['cart']);
            
            if (!$itemsProcessed) {
                throw new \RuntimeException('Failed to process sale items');
            }
            
            // Complete transaction
            $this->saleModel->db->transComplete();
            
            if ($this->saleModel->db->transStatus() === false) {
                throw new \RuntimeException('Transaction failed');
            }
            
            return $sale;
        } catch (\Exception $e) {
            log_message('error', 'Sale creation failed: ' . $e->getMessage());
            return false;
        }
    }
}
```

#### Code Style Rules

1. **Indentation:** 4 spaces (no tabs)
2. **Line Length:** Maximum 120 characters
3. **Opening Braces:** On new line for classes/methods
4. **Whitespace:** Around operators, after commas
5. **Comments:** PHPDoc for all public methods
6. **Type Hints:** Always use type hints for parameters and return values
7. **Null Safety:** Use `?int` for nullable, prefer `?string` over empty string

### JavaScript Standards

We follow **ESLint** with standard configuration.

#### Example Code

```javascript
/**
 * Calculate sale total
 * 
 * @param {Array} cart Cart items
 * @param {Object} discount Applied discount
 * @returns {number} Total amount
 */
function calculateTotal(cart, discount = null) {
    const subtotal = cart.reduce((sum, item) => {
        return sum + (item.price * item.quantity);
    }, 0);
    
    if (discount && discount.valid) {
        return subtotal - discount.amount;
    }
    
    return subtotal;
}
```

### CSS Standards

Use **BEM** methodology for CSS naming.

```css
/* Block */
.sale-form { }

/* Element */
.sale-form__input { }
.sale-form__button { }

/* Modifier */
.sale-form--loading { }
.sale-form__button--disabled { }
```

### Database Standards

#### Table Naming

- Use lowercase, plural table names
- Use underscores for multi-word tables
- Example: `sale_items`, `patient_phones`

#### Column Naming

- Use snake_case for column names
- Use descriptive names
- Example: `created_at`, `is_active`, `customer_id`

#### Foreign Keys

- Format: `{table_name}_id`
- Always create indexes on foreign keys
- Example: `customer_id`, `store_id`

---

## Commit Guidelines

### Commit Message Format

We use **Conventional Commits** specification.

#### Format

```
<type>(<scope>): <subject>

<body>

<footer>
```

#### Types

| Type | Description |
|-------|-------------|
| `feat` | New feature |
| `fix` | Bug fix |
| `docs` | Documentation changes |
| `style` | Code style changes (formatting) |
| `refactor` | Code refactoring |
| `perf` | Performance improvements |
| `test` | Adding or updating tests |
| `chore` | Maintenance tasks |
| `ci` | CI/CD changes |

#### Examples

**Feature:**

```
feat(sales): add support for multiple payment methods

- Add payment type selection in POS
- Implement credit card payment processing
- Add payment method tracking in database

Closes #123
```

**Bug Fix:**

```
fix(inventory): correct stock calculation on sale cancellation

Fixed bug where inventory was not properly restored when
a sale was cancelled, causing stock discrepancies.

Fixes #456
```

**Documentation:**

```
docs(api): update authentication endpoint documentation

Updated examples and added error response codes
for the authentication API endpoints.
```

#### Commit Best Practices

1. **Subject line:** Max 50 characters, no period
2. **Body:** Wrap at 72 characters, explain "why" not "what"
3. **Use imperative mood:** "Add" not "Added" or "Adding"
4. **Reference issues:** Use `Closes #123` or `Fixes #456`
5. **One commit per feature:** Atomic changes

---

## Pull Request Process

### Before Creating PR

- [ ] Sync with upstream main branch
- [ ] Ensure all tests pass
- [ ] Update documentation
- [ ] Add tests for new functionality
- [ ] Run linter and fix issues
- [ ] Write clear PR description

### PR Title Format

Same as commit message format:

```
feat(sales): add support for promotions
fix(inventory): resolve stock calculation error
docs(readme): update installation instructions
```

### PR Description Template

```markdown
## Description
<!-- Brief description of changes -->

## Type of Change
- [ ] Bug fix
- [ ] New feature
- [ ] Breaking change
- [ ] Documentation update

## Motivation and Context
<!-- Why is this change needed? -->
<!-- Provide links to related issues -->

## How Has This Been Tested?
<!-- Describe testing performed -->

## Screenshots (if applicable)
<!-- Add screenshots for UI changes -->

## Checklist
- [ ] Code follows style guidelines
- [ ] Self-review performed
- [ ] Commented complex code
- [ ] Updated documentation
- [ ] Added/updated tests
- [ ] All tests passing
- [ ] No new warnings generated
```

### PR Review Process

1. **Automated Checks:** CI/CD runs tests and linters
2. **Code Review:** At least one maintainer reviews
3. **Feedback Address:** Respond to review comments
4. **Approval:** PR must be approved before merge
5. **Merge:** Maintainer merges with squashing commits

---

## Testing Guidelines

### Unit Tests

Write unit tests for all business logic.

**Example PHPUnit Test:**

```php
<?php

namespace Tests\Services;

use App\Services\SaleService;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;

/**
 * Sale Service Test
 */
class SaleServiceTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    
    protected $migrate     = true;
    protected $migrateOnce = false;
    protected $refresh     = true;
    
    protected SaleService $saleService;
    
    protected function setUp(): void
    {
        parent::setUp();
        $this->saleService = new SaleService();
    }
    
    /**
     * Test sale creation with valid data
     */
    public function testCreateSaleWithValidData()
    {
        // Arrange
        $data = [
            'type' => 'cash',
            'customer' => 1,
            'cart' => [
                ['id' => 1, 'qty' => 2, 'price' => 100.00]
            ],
            'payments' => [
                ['type' => 'cash', 'amount' => 200.00]
            ]
        ];
        
        // Act
        $sale = $this->saleService->create($data);
        
        // Assert
        $this->assertIsObject($sale);
        $this->assertEquals('cash', $sale->type);
        $this->assertEquals(200.00, $sale->total);
    }
    
    /**
     * Test sale creation with insufficient inventory
     */
    public function testCreateSaleWithInsufficientInventory()
    {
        // Arrange
        $data = [
            'type' => 'cash',
            'customer' => 1,
            'cart' => [
                ['id' => 1, 'qty' => 999, 'price' => 100.00]
            ],
            'payments' => [
                ['type' => 'cash', 'amount' => 99900.00]
            ]
        ];
        
        // Act
        $sale = $this->saleService->create($data);
        
        // Assert
        $this->assertFalse($sale);
    }
}
```

### Integration Tests

Test interactions between components.

```php
public function testSaleWithInventoryDecrement()
{
    // Create sale
    $sale = $this->createSale();
    
    // Verify inventory decreased
    $inventory = $this->inventoryModel->find(1);
    $this->assertEquals(98, $inventory->stock);
}
```

### Running Tests

```bash
# Run all tests
vendor/bin/phpunit

# Run specific test file
vendor/bin/phpunit tests/Services/SaleServiceTest.php

# Run with coverage
vendor/bin/phpunit --coverage-html coverage
```

### Test Coverage

Maintain **minimum 85%** code coverage for production code.

---

## Code Review Process

### What Reviewers Look For

1. **Correctness:** Does the code work as intended?
2. **Style:** Does it follow coding standards?
3. **Performance:** Are there performance concerns?
4. **Security:** Are there security vulnerabilities?
5. **Testing:** Are tests adequate?
6. **Documentation:** Is code documented?
7. **Maintainability:** Is code easy to understand and maintain?

### Review Best Practices

1. **Be constructive:** Provide specific, actionable feedback
2. **Be respectful:** Assume good intentions
3. **Be thorough:** Review carefully but efficiently
4. **Ask questions:** Clarify unclear code

---

## Documentation

### Code Documentation

- Use PHPDoc for all public methods
- Explain "why" not "what"
- Document edge cases and exceptions

### API Documentation

- Update `/docs/api/README.md` for API changes
- Include request/response examples
- Document all parameters

### README Updates

- Update `README.md` for major features
- Add installation instructions if needed
- Include screenshots for UI changes

---

## Reporting Issues

### Before Reporting

1. Search existing issues
2. Check if issue is already resolved
3. Try to reproduce in clean environment

### Issue Template

```markdown
## Issue Type
- [ ] Bug
- [ ] Feature Request
- [ ] Documentation
- [ ] Other

## Description
<!-- Clear description of the issue -->

## Steps to Reproduce
<!-- Steps to reproduce bug -->
1. 
2. 
3. 

## Expected Behavior
<!-- What you expected to happen -->

## Actual Behavior
<!-- What actually happened -->

## Environment
- OS: [e.g., Ubuntu 22.04]
- PHP Version: [e.g., 8.1.15]
- MySQL Version: [e.g., 8.0.32]
- Browser: [e.g., Chrome 120]

## Screenshots
<!-- Add screenshots if applicable -->

## Additional Context
<!-- Any additional context -->
```

---

## Asking Questions

### Where to Ask

- **GitHub Discussions:** For general questions
- **GitHub Issues:** For bugs and feature requests
- **Email:** soporte@opticas-development.local

### Guidelines

1. Be specific about your question
2. Provide context and code examples
3. Search before asking
4. Follow up on responses

---

## Recognition

Contributors will be recognized in:
- `README.md` Contributors section
- Release notes
- Annual contributors report

---

## License

By contributing, you agree that your contributions will be licensed under the project's MIT License.

---

## Contact

For questions about contributing, contact: **soporte@opticas-development.local**

---

**Thank you for contributing to Opticas-Development!** 🚀
