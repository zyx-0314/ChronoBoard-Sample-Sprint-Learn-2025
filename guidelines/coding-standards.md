# Coding Standards and Best Practices

## Overview

This document defines coding standards for ChronoBoard. Following these standards ensures consistency, readability, and maintainability across the codebase.

## Core Principles

### KISS (Keep It Simple, Stupid)

Write simple, straightforward code that is easy to understand:

✅ **Do**:
```php
function calculateTotalPrice($price, $quantity) {
    return $price * $quantity;
}
```

❌ **Don't**:
```php
function calculateTotalPrice($price, $quantity) {
    $priceMultiplier = new PriceMultiplier();
    $calculator = new CalculatorFactory()->create('price');
    return $calculator->compute($price, $quantity, $priceMultiplier);
}
```

### YAGNI (You Aren't Gonna Need It)

Don't build functionality until it's actually needed:

✅ **Do**: Implement what's needed now
```php
class User {
    public $userId;
    public $username;
    public $email;
}
```

❌ **Don't**: Add speculative features
```php
class User {
    public $userId;
    public $username;
    public $email;
    public $futureFeatureFlag;  // Not needed yet
    public $potentialSetting;    // Might need later
}
```

### MVP Mindset

Focus on minimum viable implementation first:

1. Build core functionality
2. Make it work correctly
3. Ensure it's testable
4. Refactor only if needed

## Naming Conventions

### Use Clear, Descriptive Names

Names should clearly communicate purpose without abbreviations:

✅ **Good**:
```php
$userProfile
$authenticationToken
$emailNotificationService
$calculateTotalAmount()
```

❌ **Bad**:
```php
$u          // Too short
$tmp        // Vague
$data       // Generic
$mgr        // Abbreviation
$ctrl       // Abbreviation
$calc()     // Abbreviated
```

### Variable Names

- Use **camelCase** for variables
- Start with lowercase letter
- Use descriptive, full words
- Boolean variables should ask a question

```php
// Good examples
$userName = "John";
$userAge = 25;
$isUserActive = true;
$hasPermission = false;
$totalOrderAmount = 150.00;

// Bad examples
$n = "John";              // Too short
$usr_name = "John";       // Wrong format
$temp = "John";           // Vague
$x = 25;                  // Meaningless
```

### Function/Method Names

- Use **camelCase** for functions
- Start with verb
- Be descriptive about what function does

```php
// Good examples
function getUserProfile() { }
function calculateTotalPrice() { }
function sendEmailNotification() { }
function validateUserInput() { }
function isUserAuthenticated() { }

// Bad examples
function get() { }              // Too vague
function doStuff() { }          // Not descriptive
function process() { }          // What does it process?
function calc() { }             // Abbreviated
function usrMgmt() { }          // Abbreviations
```

### Class Names

- Use **PascalCase** for classes
- Use nouns
- Be specific about class responsibility

```php
// Good examples
class UserProfile { }
class EmailNotificationService { }
class PaymentProcessor { }
class OrderValidator { }

// Bad examples
class User { }                   // Too generic
class Data { }                   // Meaningless
class Manager { }                // Vague
class Utils { }                  // Generic utility dump
class Helper { }                 // Not descriptive
```

### Constants

- Use **UPPER_SNAKE_CASE** for constants
- Be descriptive

```php
// Good examples
const MAX_LOGIN_ATTEMPTS = 3;
const DEFAULT_TIMEOUT_SECONDS = 30;
const USER_STATUS_ACTIVE = 'active';

// Bad examples
const MAX = 3;                   // Too short
const T = 30;                    // Meaningless
const USR_STAT = 'active';      // Abbreviated
```

### File Names

- Use **kebab-case** for file names
- Match class name when applicable

```
user-profile.php
email-notification-service.php
payment-processor.php
order-validator.php
```

## Code Structure

### File Organization

Each file should have a clear purpose:

```php
<?php
// 1. Namespace declaration
namespace App\Services;

// 2. Use statements
use App\Models\User;
use App\Exceptions\ValidationException;

// 3. Class declaration with clear purpose
class UserAuthenticationService {
    // 4. Properties
    private $database;
    
    // 5. Constructor
    public function __construct($database) {
        $this->database = $database;
    }
    
    // 6. Public methods
    public function authenticateUser($username, $password) {
        // Implementation
    }
    
    // 7. Private methods
    private function validateCredentials($username, $password) {
        // Implementation
    }
}
```

### Function Length

Keep functions short and focused:

✅ **Good** (Single Responsibility):
```php
function validateUserEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function saveUser($user) {
    return $this->database->save($user);
}

function sendWelcomeEmail($email) {
    return $this->emailService->send($email, 'Welcome!');
}
```

❌ **Bad** (Doing Too Much):
```php
function registerUser($userData) {
    // Validate email
    if (!filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Invalid email');
    }
    
    // Hash password
    $hashedPassword = password_hash($userData['password'], PASSWORD_DEFAULT);
    
    // Save to database
    $this->database->insert('users', [
        'email' => $userData['email'],
        'password' => $hashedPassword
    ]);
    
    // Send welcome email
    $this->mailer->send($userData['email'], 'Welcome!');
    
    // Log activity
    $this->logger->log('New user registered: ' . $userData['email']);
    
    // Update analytics
    $this->analytics->track('user_registered');
}
```

### Class Responsibility

One class should have one clear responsibility:

✅ **Good**:
```php
class UserValidator {
    public function validateEmail($email) { }
    public function validatePassword($password) { }
}

class UserRepository {
    public function saveUser($user) { }
    public function findUserById($userId) { }
}

class EmailService {
    public function sendEmail($to, $subject, $body) { }
}
```

❌ **Bad**:
```php
class UserManager {
    public function validateEmail($email) { }
    public function saveUser($user) { }
    public function sendEmail($email) { }
    public function logActivity($message) { }
    public function updateAnalytics($event) { }
}
```

## Comments

### When to Comment

Only comment when code cannot be made clearer:

✅ **Good** (Complex Algorithm):
```php
// Binary search requires sorted array - using quicksort first
$sortedArray = quicksort($array);
$result = binarySearch($sortedArray, $target);
```

✅ **Good** (Business Rule):
```php
// Per business rule BR-2023-15: Users under 18 need parental consent
if ($userAge < 18 && !$hasParentalConsent) {
    throw new ValidationException('Parental consent required');
}
```

❌ **Bad** (Stating Obvious):
```php
// Increment counter
$counter++;

// Set user name
$userName = $data['name'];

// Loop through users
foreach ($users as $user) {
    // Process user
    processUser($user);
}
```

### Self-Documenting Code

Write code that explains itself:

✅ **Good**:
```php
function isUserEligibleForDiscount($user) {
    $hasActiveSubscription = $user->subscriptionStatus === 'active';
    $hasEnoughPurchases = $user->totalPurchases >= 10;
    $isInGoodStanding = !$user->hasOverduePayments;
    
    return $hasActiveSubscription 
        && $hasEnoughPurchases 
        && $isInGoodStanding;
}
```

❌ **Bad**:
```php
function check($u) {
    // Check if eligible
    if ($u->s === 'a' && $u->t >= 10 && !$u->p) {
        return true;
    }
    return false;
}
```

## Error Handling

### Be Specific with Errors

```php
// Good - Specific errors
if (!$userEmail) {
    throw new InvalidArgumentException('User email is required');
}

if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
    throw new ValidationException('Invalid email format: ' . $userEmail);
}

// Bad - Generic errors
if (!$userEmail) {
    throw new Exception('Error');
}
```

### Handle Errors Appropriately

```php
// Good - Proper error handling
try {
    $result = $this->externalApiService->fetchData();
    return $result;
} catch (ApiConnectionException $exception) {
    $this->logger->error('API connection failed', [
        'error' => $exception->getMessage()
    ]);
    throw new ServiceUnavailableException('Unable to fetch data');
}

// Bad - Swallowing errors
try {
    $result = $this->externalApiService->fetchData();
    return $result;
} catch (Exception $exception) {
    // Do nothing
}
```

## Avoiding Anti-Patterns

### No Premature Abstraction

❌ **Don't Create Abstract Classes "Just in Case"**:
```php
// Bad - Unnecessary abstraction
abstract class BaseController {
    abstract public function index();
    abstract public function show($id);
    abstract public function create();
    // ... more methods you might never need
}

class UserController extends BaseController {
    // Only need one method but forced to implement all
}
```

✅ **Do Create Abstractions When Actually Needed**:
```php
// Good - Simple, direct implementation
class UserController {
    public function listUsers() {
        return $this->userRepository->findAll();
    }
}

// When you actually need abstraction (3+ similar classes):
interface Repository {
    public function findAll();
    public function findById($id);
}

class UserRepository implements Repository { }
class ProductRepository implements Repository { }
class OrderRepository implements Repository { }
```

### No Speculative Features

❌ **Don't Add Features You Might Need**:
```php
class User {
    private $userId;
    private $username;
    
    // Bad - Not needed yet
    private $futureFeatureSettings = [];
    private $potentialFlags = [];
    
    public function setFutureFeature($key, $value) {
        // Might need this later?
        $this->futureFeatureSettings[$key] = $value;
    }
}
```

✅ **Do Add Features When Actually Needed**:
```php
class User {
    private $userId;
    private $username;
    
    // That's it - add more when requirements come
}
```

### No Generic Utilities Dump

❌ **Don't Create Generic "Utils" Classes**:
```php
class Utils {
    public static function formatDate($date) { }
    public static function sendEmail($to, $body) { }
    public static function calculatePrice($amount) { }
    public static function validateInput($input) { }
    // ... unrelated functions
}
```

✅ **Do Create Specific, Focused Classes**:
```php
class DateFormatter {
    public function format($date) { }
}

class EmailService {
    public function send($to, $body) { }
}

class PriceCalculator {
    public function calculate($amount) { }
}

class InputValidator {
    public function validate($input) { }
}
```

### No God Classes

❌ **Don't Put Everything in One Class**:
```php
class UserManager {
    public function createUser() { }
    public function updateUser() { }
    public function deleteUser() { }
    public function validateUser() { }
    public function authenticateUser() { }
    public function sendUserEmail() { }
    public function logUserActivity() { }
    public function exportUserData() { }
    public function importUserData() { }
    // ... 50+ more methods
}
```

✅ **Do Separate Responsibilities**:
```php
class UserRepository {
    public function create($user) { }
    public function update($user) { }
    public function delete($userId) { }
}

class UserValidator {
    public function validate($user) { }
}

class UserAuthenticationService {
    public function authenticate($credentials) { }
}
```

## Testing Standards

### Write Testable Code

```php
// Good - Easy to test
class PriceCalculator {
    public function calculate($price, $taxRate) {
        return $price * (1 + $taxRate);
    }
}

// Test
public function testPriceCalculation() {
    $calculator = new PriceCalculator();
    $result = $calculator->calculate(100, 0.1);
    $this->assertEquals(110, $result);
}
```

### Test Names Should Be Descriptive

```php
// Good test names
public function testUserCanLoginWithValidCredentials() { }
public function testLoginFailsWithInvalidPassword() { }
public function testEmailValidationRejectsInvalidFormat() { }

// Bad test names
public function test1() { }
public function testLogin() { }
public function testStuff() { }
```

## Code Formatting

### Indentation

- Use 4 spaces for indentation
- No tabs

### Line Length

- Keep lines under 80-100 characters
- Break long lines logically

```php
// Good
$result = $this->userAuthenticationService->authenticateUserWithCredentials(
    $username,
    $password
);

// Bad - Too long
$result = $this->userAuthenticationService->authenticateUserWithCredentials($username, $password, $rememberMe, $ipAddress);
```

### Spacing

```php
// Good spacing
function calculateTotal($price, $quantity) {
    $subtotal = $price * $quantity;
    $tax = $subtotal * 0.1;
    
    return $subtotal + $tax;
}

// Bad spacing
function calculateTotal($price,$quantity){
    $subtotal=$price*$quantity;
    $tax=$subtotal*0.1;
    return $subtotal+$tax;
}
```

## Security Standards

### Input Validation

```php
// Always validate user input
function createUser($userData) {
    if (!isset($userData['email'])) {
        throw new ValidationException('Email required');
    }
    
    if (!filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
        throw new ValidationException('Invalid email format');
    }
    
    // Continue with validated data
}
```

### SQL Injection Prevention

```php
// Good - Use prepared statements
$statement = $database->prepare('SELECT * FROM users WHERE email = ?');
$statement->execute([$email]);

// Bad - Direct concatenation
$query = "SELECT * FROM users WHERE email = '" . $email . "'";
```

### XSS Prevention

```php
// Good - Escape output
echo htmlspecialchars($userInput, ENT_QUOTES, 'UTF-8');

// Bad - Direct output
echo $userInput;
```

## Performance Considerations

### Only Optimize When Needed

1. Make it work correctly first
2. Measure performance
3. Optimize bottlenecks only

### Avoid Premature Optimization

❌ **Don't**:
```php
// Bad - Complex optimization for unclear benefit
$cachedResults = [];
function getUser($userId) {
    if (!isset($cachedResults[$userId])) {
        $cachedResults[$userId] = $this->database->find($userId);
    }
    return $cachedResults[$userId];
}
```

✅ **Do**:
```php
// Good - Simple, clear code
function getUser($userId) {
    return $this->database->find($userId);
}

// Add caching only when performance testing shows need
```

## Summary Checklist

When writing code, verify:

- [ ] Names are clear and descriptive (no abbreviations)
- [ ] Functions are short and focused (single responsibility)
- [ ] No unnecessary abstractions
- [ ] No speculative features
- [ ] Code is self-documenting
- [ ] Errors are handled appropriately
- [ ] Input is validated
- [ ] Security best practices followed
- [ ] Code is testable
- [ ] Follows KISS principle
- [ ] Follows YAGNI principle
- [ ] Maintains MVP mindset

## Related Documentation

- [Development Workflow](../workflows/development-workflow.md)
- [Naming Conventions Guide](./naming-conventions.md)
- [Testing Strategy](../testing/testing-strategy.md)
