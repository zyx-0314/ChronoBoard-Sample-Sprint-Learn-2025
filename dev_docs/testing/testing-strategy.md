# Testing Strategy

## Overview

This document outlines the testing strategy for ChronoBoard. Testing ensures code quality, prevents regressions, and builds confidence in changes.

## Testing Philosophy

### Core Principles

1. **Test Behavior, Not Implementation**
   - Test what code does, not how it does it
   - Tests should survive refactoring

2. **Keep Tests Simple**
   - Follow KISS principle in tests too
   - Clear test names
   - Easy to understand

3. **Test What Matters**
   - Focus on critical functionality
   - Don't test framework code
   - Test business logic thoroughly

4. **MVP Testing**
   - Write tests for what exists
   - Don't test speculative features
   - Add tests as features are added

## Types of Tests

### Unit Tests

Test individual functions/methods in isolation.

**When to Use**:
- Testing business logic
- Testing calculations
- Testing validations
- Testing utility functions

**Example**:
```php
class PriceCalculatorTest extends TestCase {
    public function testCalculateTotalWithTax() {
        $calculator = new PriceCalculator();
        $result = $calculator->calculateTotal(100, 0.1);
        
        $this->assertEquals(110, $result);
    }
    
    public function testCalculateTotalWithZeroTax() {
        $calculator = new PriceCalculator();
        $result = $calculator->calculateTotal(100, 0);
        
        $this->assertEquals(100, $result);
    }
}
```

### Integration Tests

Test how components work together.

**When to Use**:
- Testing database interactions
- Testing API endpoints
- Testing service integrations
- Testing workflows

**Example**:
```php
class UserAuthenticationTest extends TestCase {
    public function testUserCanLoginWithValidCredentials() {
        $user = User::factory()->create([
            'email' => 'user@example.com',
            'password' => Hash::make('password123')
        ]);
        
        $response = $this->post('/login', [
            'email' => 'user@example.com',
            'password' => 'password123'
        ]);
        
        $response->assertSuccessful();
        $this->assertAuthenticated();
    }
}
```

### Feature Tests

Test complete user workflows end-to-end.

**When to Use**:
- Testing complete user journeys
- Testing critical business processes
- Testing system behavior

**Example**:
```php
class OrderPlacementTest extends TestCase {
    public function testUserCanPlaceOrder() {
        // Create user and login
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Add items to cart
        $product = Product::factory()->create(['price' => 100]);
        $this->post('/cart/add', ['product_id' => $product->id]);
        
        // Place order
        $response = $this->post('/orders/place', [
            'payment_method' => 'credit_card'
        ]);
        
        // Verify order created
        $response->assertSuccessful();
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'total' => 100
        ]);
    }
}
```

## Writing Good Tests

### Test Naming

Use descriptive names that explain what is being tested:

✅ **Good**:
```php
public function testUserCannotLoginWithInvalidPassword() { }
public function testEmailValidationRejectsInvalidFormat() { }
public function testOrderTotalIncludesTax() { }
public function testUserMustBeAuthenticatedToAccessProfile() { }
```

❌ **Bad**:
```php
public function test1() { }
public function testLogin() { }
public function testValidation() { }
public function testIt() { }
```

### Arrange-Act-Assert Pattern

Structure tests clearly:

```php
public function testUserCanUpdateProfile() {
    // Arrange - Set up test data
    $user = User::factory()->create();
    $this->actingAs($user);
    
    // Act - Perform the action
    $response = $this->put('/profile', [
        'name' => 'New Name',
        'email' => 'newemail@example.com'
    ]);
    
    // Assert - Check the results
    $response->assertSuccessful();
    $this->assertEquals('New Name', $user->fresh()->name);
    $this->assertEquals('newemail@example.com', $user->fresh()->email);
}
```

### Test One Thing at a Time

Each test should verify one specific behavior:

✅ **Good**:
```php
public function testValidEmailPassesValidation() {
    $validator = new EmailValidator();
    $isValid = $validator->validate('user@example.com');
    
    $this->assertTrue($isValid);
}

public function testInvalidEmailFailsValidation() {
    $validator = new EmailValidator();
    $isValid = $validator->validate('invalid-email');
    
    $this->assertFalse($isValid);
}
```

❌ **Bad**:
```php
public function testEmailValidation() {
    $validator = new EmailValidator();
    
    // Testing multiple things in one test
    $this->assertTrue($validator->validate('user@example.com'));
    $this->assertFalse($validator->validate('invalid'));
    $this->assertTrue($validator->validate('another@test.com'));
    $this->assertFalse($validator->validate(''));
}
```

### Use Clear Assertions

Be explicit about what you're testing:

✅ **Good**:
```php
$this->assertEquals(200, $response->status());
$this->assertTrue($user->isActive());
$this->assertCount(3, $orders);
$this->assertDatabaseHas('users', ['email' => 'test@example.com']);
```

❌ **Bad**:
```php
$this->assertTrue($response->status() == 200);  // Use assertEquals
$this->assertFalse(!$user->isActive());         // Double negative
```

## Test Data

### Using Factories

Create test data with factories for consistency:

```php
// Define factory
class UserFactory extends Factory {
    public function definition() {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->email(),
            'password' => Hash::make('password')
        ];
    }
    
    public function admin() {
        return $this->state([
            'role' => 'admin'
        ]);
    }
}

// Use in tests
$user = User::factory()->create();
$admin = User::factory()->admin()->create();
$users = User::factory()->count(5)->create();
```

### Test Database

Use separate test database:

```php
// In phpunit.xml
<env name="DB_CONNECTION" value="sqlite"/>
<env name="DB_DATABASE" value=":memory:"/>
```

### Clean Up After Tests

```php
class UserTest extends TestCase {
    use RefreshDatabase;  // Resets database after each test
    
    public function testSomething() {
        // Test runs with clean database
    }
}
```

## Running Tests

### Run All Tests

```bash
# Using Composer
composer test

# Using PHPUnit directly
vendor/bin/phpunit

# With Docker
docker-compose exec app composer test
```

### Run Specific Test File

```bash
vendor/bin/phpunit tests/Unit/UserTest.php
```

### Run Specific Test Method

```bash
vendor/bin/phpunit --filter testUserCanLogin
```

### Run with Coverage

```bash
vendor/bin/phpunit --coverage-html coverage/
```

## Test Coverage

### What to Test

✅ **Must Test**:
- Business logic
- Calculations and algorithms
- Validation rules
- Authentication and authorization
- Data transformations
- Critical user workflows

✅ **Should Test**:
- API endpoints
- Database operations
- Service integrations
- Error handling

⚠️ **Consider Testing**:
- Simple getters/setters (usually not needed)
- Framework features (already tested)
- Third-party libraries (already tested)

❌ **Don't Test**:
- Framework code
- External APIs (use mocks)
- Obvious code with no logic

### Coverage Goals

- Aim for 70-80% coverage minimum
- 100% coverage is not always necessary
- Focus on critical paths
- Quality over quantity

## Mocking and Stubbing

### When to Mock

Mock external dependencies to isolate unit tests:

```php
public function testEmailIsSentAfterRegistration() {
    // Mock email service
    $emailService = $this->createMock(EmailService::class);
    $emailService->expects($this->once())
        ->method('send')
        ->with($this->equalTo('welcome@example.com'));
    
    $registrationService = new RegistrationService($emailService);
    $registrationService->register($userData);
}
```

### Don't Over-Mock

❌ **Bad** (Too much mocking):
```php
public function testCalculateTotal() {
    $price = $this->createMock(Price::class);
    $quantity = $this->createMock(Quantity::class);
    $calculator = $this->createMock(Calculator::class);
    
    // Testing mocks, not real behavior
}
```

✅ **Good** (Test real behavior):
```php
public function testCalculateTotal() {
    $calculator = new PriceCalculator();
    $total = $calculator->calculate(100, 2);
    
    $this->assertEquals(200, $total);
}
```

## Test Organization

### Directory Structure

```
tests/
├── Unit/              # Unit tests
│   ├── Services/
│   │   └── UserAuthenticationServiceTest.php
│   └── Validators/
│       └── EmailValidatorTest.php
├── Integration/       # Integration tests
│   ├── Database/
│   │   └── UserRepositoryTest.php
│   └── Api/
│       └── AuthenticationApiTest.php
└── Feature/           # Feature tests
    └── UserRegistrationTest.php
```

### File Naming

- Match class being tested: `UserService.php` → `UserServiceTest.php`
- Place in corresponding directory structure
- Use `Test` suffix

## Test-Driven Development (TDD)

### Optional but Recommended

1. **Write failing test first**
   ```php
   public function testUserCanLogin() {
       $response = $this->post('/login', [
           'email' => 'user@example.com',
           'password' => 'password'
       ]);
       
       $response->assertSuccessful();
   }
   ```

2. **Write minimum code to pass**
   ```php
   public function login(Request $request) {
       return response()->json(['status' => 'success']);
   }
   ```

3. **Refactor while keeping tests green**
   ```php
   public function login(Request $request) {
       $credentials = $request->only('email', 'password');
       
       if (Auth::attempt($credentials)) {
           return response()->json(['status' => 'success']);
       }
       
       return response()->json(['status' => 'error'], 401);
   }
   ```

## Common Testing Patterns

### Testing Validation

```php
public function testRegistrationFailsWithInvalidEmail() {
    $response = $this->post('/register', [
        'email' => 'invalid-email',
        'password' => 'password123'
    ]);
    
    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['email']);
}
```

### Testing Authentication

```php
public function testGuestCannotAccessDashboard() {
    $response = $this->get('/dashboard');
    
    $response->assertRedirect('/login');
}

public function testAuthenticatedUserCanAccessDashboard() {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->get('/dashboard');
    
    $response->assertSuccessful();
}
```

### Testing Authorization

```php
public function testUserCannotDeleteOtherUsersPost() {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $otherUser->id]);
    
    $response = $this->actingAs($user)->delete("/posts/{$post->id}");
    
    $response->assertForbidden();
}
```

### Testing Database

```php
public function testUserIsStoredInDatabase() {
    $response = $this->post('/register', [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'password123'
    ]);
    
    $this->assertDatabaseHas('users', [
        'name' => 'John Doe',
        'email' => 'john@example.com'
    ]);
}
```

## Continuous Integration

### Run Tests Automatically

In GitHub Actions (`.github/workflows/tests.yml`):

```yaml
name: Tests

on: [push, pull_request]

jobs:
  test:
    runs-on: ubuntu-latest
    
    steps:
      - uses: actions/checkout@v2
      
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: 8.1
          
      - name: Install Dependencies
        run: composer install
        
      - name: Run Tests
        run: composer test
```

## Debugging Tests

### Run Single Test

```bash
vendor/bin/phpunit --filter testSpecificTest
```

### Use Debugging Tools

```php
public function testSomething() {
    $result = $this->someMethod();
    
    // Debug output
    dump($result);
    dd($result);  // Dump and die
    
    $this->assertTrue(true);
}
```

### Check Test Output

```bash
# Verbose output
vendor/bin/phpunit --verbose

# With debug information
vendor/bin/phpunit --debug
```

## Best Practices

### Do's ✅

- Write descriptive test names
- Test one thing per test
- Use factories for test data
- Keep tests independent
- Clean up after tests
- Run tests before committing
- Test edge cases
- Test error conditions

### Don'ts ❌

- Don't test framework code
- Don't depend on test order
- Don't use production database
- Don't skip failing tests
- Don't write tests for tests
- Don't make tests too complex
- Don't hard-code test data unnecessarily

## Troubleshooting

### Tests Failing Randomly

- Check for test interdependencies
- Verify database is being reset
- Look for time-dependent code
- Check for external dependencies

### Tests Running Slowly

- Use in-memory database
- Mock external services
- Reduce test data creation
- Parallelize test execution

### Tests Passing Locally but Failing in CI

- Check environment differences
- Verify all dependencies installed
- Check database configuration
- Review CI logs carefully

## Testing Checklist

Before committing:

- [ ] All tests pass locally
- [ ] New features have tests
- [ ] Bug fixes have regression tests
- [ ] Tests are well-named
- [ ] Tests are independent
- [ ] No skipped tests without reason
- [ ] Coverage is adequate for changes

## Related Documentation

- [Development Workflow](../workflows/development-workflow.md)
- [Coding Standards](../../guidelines/coding-standards.md)
- [Deployment Process](../deployment/deployment-process.md)
