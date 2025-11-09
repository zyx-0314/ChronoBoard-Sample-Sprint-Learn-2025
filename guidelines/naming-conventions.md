# Naming Conventions Guide

## Overview

Clear, descriptive naming is fundamental to readable and maintainable code. This guide provides specific rules and examples for naming in ChronoBoard.

## Core Principle

**Names should clearly communicate purpose without requiring comments or external documentation.**

## Variable Naming

### Format: camelCase

Start with lowercase letter, capitalize subsequent words.

### Rules

1. **Use full words, not abbreviations**
2. **Be specific about what the variable holds**
3. **Use meaningful context**
4. **Boolean variables should ask a question**

### Examples

#### Good Variable Names

```php
// Descriptive and clear
$userName = 'John Doe';
$userEmailAddress = 'john@example.com';
$totalOrderAmount = 150.50;
$activeUserCount = 42;
$maximumLoginAttempts = 3;

// Boolean variables
$isUserAuthenticated = true;
$hasAdminPrivileges = false;
$canEditProfile = true;
$shouldSendNotification = false;
$isEmailVerified = true;

// Arrays/Collections
$userList = [];
$activeOrders = [];
$errorMessages = [];
$configurationSettings = [];

// Dates/Times
$userCreatedAt = '2024-01-15';
$orderDeliveryDate = '2024-02-01';
$sessionExpirationTime = '14:30:00';
```

#### Bad Variable Names

```php
// Too short or vague
$u = 'John';          // What kind of 'u'?
$n = 42;              // What number?
$d = '2024-01-15';    // What date?
$t = true;            // What is true?

// Abbreviated
$usrNm = 'John';      // Use userNumber
$cnt = 42;            // Use count
$amt = 150;           // Use amount
$tmp = 'value';       // Use temporaryValue
$msg = 'Error';       // Use message

// Generic/Vague
$data = [];           // Data about what?
$value = 'test';      // What value?
$item = {};           // What item?
$thing = 'stuff';     // Meaningless
$result = null;       // Result of what?

// Using underscores (wrong style)
$user_name = 'John';        // Use camelCase
$is_active = true;          // Use isActive
$order_total = 150;         // Use orderTotal

// Single letters (unless clear context)
$x = 10;              // Avoid except in math contexts
$i = 0;               // Only in short loops
```

### Special Cases

#### Loop Variables

For short, obvious loops, single letters are acceptable:

```php
// Acceptable in clear contexts
for ($i = 0; $i < 10; $i++) {
    echo $i;
}

// Better for complex loops
for ($userIndex = 0; $userIndex < count($users); $userIndex++) {
    processUser($users[$userIndex]);
}

// Best - use descriptive iteration
foreach ($users as $user) {
    processUser($user);
}
```

#### Mathematical Variables

In mathematical contexts, standard conventions apply:

```php
// Acceptable for math
$x = 10;
$y = 20;
$radius = 5;
$angle = 45;

// But still be clear when possible
$xCoordinate = 10;
$yCoordinate = 20;
$circleRadius = 5;
$rotationAngle = 45;
```

## Function/Method Naming

### Format: camelCase

Start with lowercase letter, capitalize subsequent words.

### Rules

1. **Start with a verb** (action word)
2. **Be specific about what the function does**
3. **Use full words**
4. **Name should indicate return type when applicable**

### Common Verb Patterns

```php
// Getting/Retrieving data
function getUserProfile() { }
function findUserById() { }
function fetchOrderDetails() { }
function retrievePaymentHistory() { }
function getActiveUsers() { }

// Setting/Storing data
function setUserPassword() { }
function saveOrderData() { }
function updateUserProfile() { }
function storePaymentInformation() { }

// Creating/Deleting
function createNewUser() { }
function deleteOrder() { }
function removeExpiredSessions() { }
function generateAuthenticationToken() { }

// Validating/Checking
function validateEmailFormat() { }
function checkUserPermissions() { }
function verifyPasswordStrength() { }
function confirmOrderDetails() { }

// Boolean returns (is/has/can/should)
function isUserActive() { }
function hasAdminAccess() { }
function canEditPost() { }
function shouldSendEmail() { }

// Processing/Calculating
function calculateOrderTotal() { }
function processPayment() { }
function formatUserName() { }
function convertCurrency() { }

// Sending/Notifying
function sendWelcomeEmail() { }
function notifyAdministrator() { }
function dispatchOrderConfirmation() { }
```

### Good Function Names

```php
function authenticateUser($credentials) { }
function calculateTaxAmount($subtotal, $taxRate) { }
function sendPasswordResetEmail($userEmail) { }
function validateOrderItems($items) { }
function isEmailAddressAvailable($email) { }
function formatPhoneNumber($phoneNumber) { }
function convertTemperatureCelsiusToFahrenheit($celsius) { }
```

### Bad Function Names

```php
function process() { }              // Process what?
function handle() { }               // Handle what?
function doStuff() { }             // What stuff?
function manage() { }              // Too vague
function get() { }                 // Get what?

function usr() { }                 // Abbreviated
function calc() { }                // Abbreviated
function chk() { }                 // Abbreviated
function proc() { }                // Abbreviated

function data($x) { }              // Meaningless
function temp() { }                // Vague
function run() { }                 // Run what?
```

## Class Naming

### Format: PascalCase

Capitalize first letter of each word, no underscores.

### Rules

1. **Use nouns** (things, not actions)
2. **Be specific about class responsibility**
3. **Use singular form** (except for collections)
4. **Avoid generic names like Manager, Handler, Helper**

### Good Class Names

```php
// Entity/Model classes
class User { }
class Order { }
class Product { }
class PaymentTransaction { }
class EmailNotification { }

// Service classes (specific purpose)
class UserAuthenticationService { }
class EmailDeliveryService { }
class PaymentProcessingService { }
class OrderFulfillmentService { }

// Repository classes (data access)
class UserRepository { }
class OrderRepository { }
class ProductRepository { }

// Validator classes
class EmailValidator { }
class PasswordStrengthValidator { }
class OrderItemValidator { }

// Controller classes
class UserProfileController { }
class OrderManagementController { }
class ProductCatalogController { }

// Exception classes
class InvalidEmailException { }
class PaymentFailedException { }
class UserNotFoundException { }
```

### Bad Class Names

```php
// Too generic
class Manager { }              // Manages what?
class Handler { }              // Handles what?
class Helper { }               // Helps with what?
class Utility { }              // Which utilities?
class Service { }              // Too vague

// Abbreviated
class UsrMgr { }               // Use UserManager (or better, specific name)
class PrdCtrl { }              // Use ProductController
class OrdSvc { }               // Use OrderService

// Wrong plurality
class Users { }                // Use User (unless collection)
class Orders { }               // Use Order

// Using underscores
class User_Manager { }         // Use PascalCase
class Product_Service { }      // Use ProductService
```

## Constant Naming

### Format: UPPER_SNAKE_CASE

All uppercase with underscores between words.

### Rules

1. **Use full words**
2. **Be descriptive**
3. **Group related constants with prefix**

### Good Constant Names

```php
// Status constants
const USER_STATUS_ACTIVE = 'active';
const USER_STATUS_INACTIVE = 'inactive';
const USER_STATUS_SUSPENDED = 'suspended';

// Limits
const MAX_LOGIN_ATTEMPTS = 3;
const MAX_FILE_SIZE_BYTES = 5242880;  // 5MB
const MAX_PASSWORD_LENGTH = 128;
const MIN_PASSWORD_LENGTH = 8;

// Timeouts
const SESSION_TIMEOUT_SECONDS = 3600;
const API_REQUEST_TIMEOUT_SECONDS = 30;
const CACHE_EXPIRATION_HOURS = 24;

// Roles/Permissions
const ROLE_ADMINISTRATOR = 'administrator';
const ROLE_MODERATOR = 'moderator';
const ROLE_USER = 'user';

// Configuration
const DEFAULT_PAGE_SIZE = 20;
const DEFAULT_LANGUAGE = 'en';
const DEFAULT_TIMEZONE = 'UTC';
```

### Bad Constant Names

```php
// Too short
const MAX = 3;                 // Max what?
const T = 30;                  // What is T?
const D = 'default';           // What is D?

// Abbreviated
const MAX_LOG_ATT = 3;         // Use MAX_LOGIN_ATTEMPTS
const SESS_TO = 3600;          // Use SESSION_TIMEOUT_SECONDS
const USR_STAT_ACT = 'active'; // Use USER_STATUS_ACTIVE

// Wrong case
const maxLoginAttempts = 3;    // Use UPPER_SNAKE_CASE
const MaxLoginAttempts = 3;    // Use UPPER_SNAKE_CASE
```

## File Naming

### Format: kebab-case

All lowercase with hyphens between words.

### Rules

1. **Match class name when applicable**
2. **Use descriptive names**
3. **Include purpose in name**

### Good File Names

```
// Class files
user-authentication-service.php
email-delivery-service.php
order-repository.php
payment-processor.php

// Configuration files
database-config.php
email-settings.php
application-constants.php

// View files
user-profile-page.php
order-confirmation-email.php
product-list-template.php

// Test files
user-authentication-test.php
email-validator-test.php
```

### Bad File Names

```
// Too vague
service.php                    // Which service?
utils.php                      // Which utilities?
helpers.php                    // Which helpers?

// Abbreviated
usr-svc.php                    // Use user-service.php
auth-ctrl.php                  // Use authentication-controller.php

// Wrong case
UserService.php                // Use user-service.php
user_service.php               // Use kebab-case
```

## Database Naming

### Table Names

- Use **snake_case**
- Use plural form
- Be descriptive

```sql
-- Good
users
user_profiles
order_items
payment_transactions
email_notifications

-- Bad
usr                            -- Abbreviated
tbl_users                      -- Unnecessary prefix
user                           -- Should be plural
```

### Column Names

- Use **snake_case**
- Be descriptive
- Include context

```sql
-- Good
user_id
email_address
created_at
is_active
total_amount

-- Bad
id                             -- Too generic in context
usr_email                      -- Abbreviated
createdAt                      -- Wrong case
active                         -- Missing 'is_'
```

## Namespace Naming

### Format: PascalCase

```php
// Good
namespace App\Services\Authentication;
namespace App\Repositories\User;
namespace App\Controllers\Api;
namespace App\Models\Order;

// Bad
namespace app\services;        // Wrong case
namespace App\Svc;             // Abbreviated
```

## Interface Naming

### Rules

- Use PascalCase
- Often end with "Interface" or describe capability
- Be specific

```php
// Good - Descriptive capability
interface AuthenticatesUsers { }
interface SendsNotifications { }
interface ValidatesInput { }

// Good - With Interface suffix
interface UserRepositoryInterface { }
interface PaymentProcessorInterface { }

// Bad
interface IUser { }            // Don't use Hungarian notation
interface UserInt { }          // Abbreviated
interface Thing { }            // Vague
```

## Event Naming

### Rules

- Use PascalCase
- Past tense (event happened)
- Be specific

```php
// Good
class UserRegistered { }
class OrderPlaced { }
class PaymentProcessed { }
class EmailSent { }
class PasswordReset { }

// Bad
class User { }                 // Not descriptive of event
class Order { }                // Not past tense
class ProcessPayment { }       // Present tense
```

## Test Naming

### Format: camelCase with descriptive sentence

```php
// Good test method names
public function testUserCanLoginWithValidCredentials() { }
public function testLoginFailsWithInvalidPassword() { }
public function testEmailValidationRejectsInvalidFormat() { }
public function testOrderTotalIsCalculatedCorrectly() { }
public function testUserCannotAccessAdminPageWithoutPermission() { }

// Bad test method names
public function test1() { }
public function testLogin() { }
public function testUser() { }
public function testStuff() { }
```

## Route/URL Naming

### Format: kebab-case

- Lowercase
- Use hyphens
- Be descriptive
- RESTful conventions

```
// Good
/user-profile
/order-history
/password-reset
/email-verification
/api/user-authentication

// Bad
/userProfile                   // Wrong case
/user_profile                  // Wrong separator
/up                            // Abbreviated
/page1                         // Meaningless
```

## Configuration Keys

### Format: UPPER_SNAKE_CASE or dot.notation

```php
// Environment variables (UPPER_SNAKE_CASE)
APP_NAME
APP_ENV
DB_HOST
DB_PORT
MAIL_DRIVER
SESSION_TIMEOUT

// Config files (dot.notation)
database.host
database.port
mail.driver
session.timeout
cache.expiration
```

## Quick Reference

| Type | Format | Example |
|------|--------|---------|
| Variable | camelCase | `$userName` |
| Function | camelCase | `getUserProfile()` |
| Class | PascalCase | `UserAuthenticationService` |
| Constant | UPPER_SNAKE_CASE | `MAX_LOGIN_ATTEMPTS` |
| File | kebab-case | `user-service.php` |
| Database Table | snake_case | `user_profiles` |
| Database Column | snake_case | `email_address` |
| Namespace | PascalCase | `App\Services` |
| Interface | PascalCase | `AuthenticatesUsers` |
| Test Method | camelCase | `testUserCanLogin()` |
| Route | kebab-case | `/user-profile` |

## Forbidden Abbreviations

Never use these common abbreviations:

```
❌ usr, u        → ✅ user
❌ msg           → ✅ message
❌ btn           → ✅ button
❌ img           → ✅ image
❌ txt           → ✅ text
❌ num, nr       → ✅ number
❌ str           → ✅ string
❌ int           → ✅ integer (or specific meaning)
❌ arr           → ✅ array (or specific meaning)
❌ obj           → ✅ object (or specific meaning)
❌ temp, tmp     → ✅ temporary (or specific meaning)
❌ calc          → ✅ calculate
❌ auth          → ✅ authentication
❌ admin         → ✅ administrator
❌ config, cfg   → ✅ configuration
❌ ctx           → ✅ context
❌ mgr           → ✅ manager (or better, specific purpose)
❌ ctrl          → ✅ controller
❌ svc           → ✅ service
❌ repo          → ✅ repository
```

## Common Mistakes to Avoid

### 1. Being Too Generic

```php
❌ $data = getUserData();
✅ $userProfile = getUserProfile();

❌ function process() { }
✅ function processPayment() { }

❌ class Manager { }
✅ class UserAccountManager { }
```

### 2. Using Abbreviations

```php
❌ $usrNm = 'John';
✅ $userName = 'John';

❌ function calcAmt() { }
✅ function calculateAmount() { }

❌ class PrdCtrl { }
✅ class ProductController { }
```

### 3. Not Being Descriptive Enough

```php
❌ function get() { }
✅ function getUserProfile() { }

❌ $count = 5;
✅ $activeUserCount = 5;

❌ const MAX = 10;
✅ const MAX_LOGIN_ATTEMPTS = 10;
```

### 4. Wrong Format

```php
❌ $user_name = 'John';        // Wrong: snake_case for variable
✅ $userName = 'John';

❌ function User_Login() { }   // Wrong: PascalCase with underscore
✅ function userLogin() { }

❌ class user_service { }      // Wrong: snake_case for class
✅ class UserService { }
```

## Summary Checklist

When naming, ensure:

- [ ] No abbreviations or acronyms
- [ ] No single or two-letter names (except clear loop variables)
- [ ] Names are descriptive and clear
- [ ] Correct format for the type (camelCase, PascalCase, etc.)
- [ ] Boolean variables ask a question (is, has, can, should)
- [ ] Functions start with verbs
- [ ] Classes use nouns
- [ ] Context is clear without comments

## Related Documentation

- [Coding Standards](./coding-standards.md)
- [Development Workflow](../dev_docs/workflows/development-workflow.md)
