# AI-Assisted Development Guidelines

## Overview

This document provides guidelines for developers using AI coding assistants (GitHub Copilot, ChatGPT, etc.) when working on ChronoBoard. These guidelines ensure AI suggestions align with our principles of simplicity, clarity, and maintainability.

## Core Principles for AI Assistance

### Follow KISS, YAGNI, and MVP

AI tools should help you:
- ✅ Write simple, clear code
- ✅ Implement what's needed now
- ✅ Focus on minimum viable solutions

AI tools should NOT:
- ❌ Generate complex abstractions
- ❌ Add speculative features
- ❌ Create unnecessary patterns

## Prompting AI Tools

### Good Prompts

Structure prompts to get simple, focused solutions:

✅ **Good Examples**:

```
"Write a function to validate email format"
→ Simple validation function, no extra features

"Create a User class with id, name, and email properties"
→ Just the needed properties

"Write a test for the login function"
→ Focused test for specific functionality

"Add error handling to the payment function"
→ Specific improvement to existing code
```

### Bad Prompts

Avoid prompts that encourage over-engineering:

❌ **Bad Examples**:

```
"Create a flexible, extensible email validation system"
→ Too complex, will generate unnecessary abstractions

"Design a User management system"
→ Too broad, will add speculative features

"Create a comprehensive testing framework"
→ Unnecessary when simple tests suffice

"Build a generic utility library for all future needs"
→ Speculative, violates YAGNI
```

## Accepting AI Suggestions

### When to Accept

✅ Accept suggestions that:
- Solve the specific problem
- Use clear, descriptive names
- Are simple and straightforward
- Match existing code patterns
- Follow project conventions
- Add needed functionality only

### When to Reject

❌ Reject suggestions that:
- Add unused abstractions
- Include speculative features
- Use vague or abbreviated names
- Are overly complex
- Add design patterns without clear benefit
- Include "future-proofing" code
- Create base classes without multiple implementations
- Add configuration for non-existent options

## Common AI Anti-Patterns to Avoid

### 1. Unnecessary Abstractions

❌ **AI Often Suggests**:
```php
abstract class BaseController {
    abstract protected function getModel();
    abstract protected function getRepository();
    abstract protected function getValidator();
}

class UserController extends BaseController {
    protected function getModel() {
        return User::class;
    }
    // More boilerplate...
}
```

✅ **What You Should Write**:
```php
class UserController {
    public function getUsers() {
        return User::all();
    }
}
```

### 2. Premature Design Patterns

❌ **AI Often Suggests**:
```php
// Factory pattern when you only have one type
class UserFactory {
    public function create($type) {
        switch ($type) {
            case 'admin':
                return new AdminUser();
            case 'regular':
                return new RegularUser();
            // Cases for types that don't exist yet
        }
    }
}
```

✅ **What You Should Write**:
```php
// Just create users directly
function createUser($data) {
    return new User($data);
}
```

### 3. Generic Utilities

❌ **AI Often Suggests**:
```php
class StringUtils {
    public static function capitalize($str) { }
    public static function trim($str) { }
    public static function slugify($str) { }
    public static function sanitize($str) { }
    public static function encode($str) { }
    // 20+ more methods you might need someday
}
```

✅ **What You Should Write**:
```php
// Specific functions when actually needed
function capitalizeUserName($name) {
    return ucfirst($name);
}
```

### 4. Over-Configured Systems

❌ **AI Often Suggests**:
```php
class EmailService {
    private $config = [
        'provider' => 'smtp',
        'fallback_provider' => 'sendgrid',
        'retry_count' => 3,
        'timeout' => 30,
        'enable_tracking' => false,
        'enable_analytics' => false,
        // 50+ configuration options
    ];
}
```

✅ **What You Should Write**:
```php
class EmailService {
    public function send($to, $subject, $body) {
        // Simple implementation
    }
}
```

### 5. Speculative Features

❌ **AI Often Suggests**:
```php
class User {
    private $id;
    private $name;
    private $email;
    
    // Features not in requirements
    private $settings = [];
    private $preferences = [];
    private $metadata = [];
    private $flags = [];
}
```

✅ **What You Should Write**:
```php
class User {
    private $id;
    private $name;
    private $email;
    // Add more when actually needed
}
```

## Reviewing AI-Generated Code

### Checklist for AI Suggestions

Before accepting AI-generated code, verify:

- [ ] **Naming**: Are all names clear and descriptive? No abbreviations?
- [ ] **Simplicity**: Is this the simplest solution?
- [ ] **Necessity**: Is all code needed right now?
- [ ] **Abstractions**: Are abstractions justified by current use cases?
- [ ] **Features**: Does it add only requested functionality?
- [ ] **Patterns**: Are design patterns actually needed?
- [ ] **Configuration**: Are config options used now?
- [ ] **Dependencies**: Are new dependencies necessary?

### Red Flags in AI Code

🚩 Watch for these warning signs:

- **Generic names**: `Manager`, `Handler`, `Processor`, `Utils`, `Helper`
- **Abstract classes** with only one implementation
- **Interfaces** not used by multiple classes
- **Factory patterns** for single type
- **Strategy patterns** with one strategy
- **Configuration arrays** with unused options
- **Commented-out code** for "future use"
- **Method parameters** that aren't used
- **Features marked** as "for future extension"

## AI Tools: Specific Guidance

### GitHub Copilot

**Settings to Configure**:
- Keep suggestions short and focused
- Disable suggestions for comments (can generate over-documentation)

**Usage Tips**:
- Write clear function names first (Copilot will follow pattern)
- Start with implementation, not comments
- Review each suggestion before accepting
- Reject suggestions that add extra features

**Example Workflow**:
```php
// 1. Write clear function name
function validateUserEmail

// 2. Review Copilot suggestion
// ✅ Accept if simple validation
// ❌ Reject if creates validation framework

// 3. Verify the accepted code
```

### ChatGPT / Similar Tools

**Effective Prompts**:

✅ **Good**:
```
"Write a simple function to calculate order total from price and quantity"

"Show me how to validate an email address in PHP"

"Create a basic User class with id, name, and email"
```

❌ **Avoid**:
```
"Design a flexible, extensible order processing system"

"Create a comprehensive validation framework"

"Build a complete user management system with all possible features"
```

**Follow-up Questions**:
If AI suggests something complex, ask:
- "Can you simplify this?"
- "Do I need all these features?"
- "What's the minimum code to make this work?"
- "Can you remove the abstractions?"

## Specific AI Restrictions

### What to Tell Your AI

When starting a coding session with AI:

```
"Follow these rules:
1. Use clear, descriptive variable and function names - no abbreviations
2. Keep code simple - no unnecessary abstractions
3. Don't add features not in the requirements
4. Don't create generic utility classes
5. Don't use design patterns unless clearly needed
6. Don't add configuration for features that don't exist
7. Focus on the specific problem only"
```

### Custom AI Instructions

If your AI tool supports custom instructions:

```
Code Generation Rules:
- KISS: Keep code simple and straightforward
- YAGNI: Don't add features until needed
- MVP: Minimum viable implementation only
- Clear naming: Full words, no abbreviations (userName not usrNm)
- No premature abstractions
- No speculative features
- No generic utility classes
- No unused design patterns
- Test what exists, not what might exist
```

## Examples: Good vs. Bad AI Usage

### Example 1: Data Validation

**Prompt**: "Validate user input"

❌ **Bad AI Response** (Over-engineered):
```php
class ValidationFactory {
    public static function create($type) { }
}

interface Validator {
    public function validate($data);
    public function getRules();
    public function setRules($rules);
}

class EmailValidator implements Validator {
    private $rules = [];
    private $options = [];
    public function validate($data) { }
    public function getRules() { }
    public function setRules($rules) { }
    public function setOptions($options) { }
}
```

✅ **Good AI Response** (Simple):
```php
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}
```

### Example 2: User Service

**Prompt**: "Create user service"

❌ **Bad AI Response**:
```php
interface UserServiceInterface {
    public function create($data);
    public function update($id, $data);
    public function delete($id);
    public function find($id);
    public function search($criteria);
    public function export($format);
    public function import($data);
}

abstract class BaseUserService implements UserServiceInterface {
    // Abstract methods and helpers for future subclasses
}

class DatabaseUserService extends BaseUserService {
    // Implementation
}
```

✅ **Good AI Response**:
```php
class UserService {
    public function createUser($userData) {
        // Simple implementation
    }
    
    public function findUserById($userId) {
        // Simple implementation
    }
}
```

## Testing with AI

### Test Generation Guidelines

When asking AI to generate tests:

✅ **Good Prompts**:
```
"Write a test for the calculateTotal function"
"Test that validateEmail returns false for invalid emails"
"Create a test for user login with valid credentials"
```

❌ **Avoid**:
```
"Generate comprehensive test suite"
"Create all possible test cases"
"Write tests for all future scenarios"
```

### Test Code Quality

AI-generated tests should:
- Test actual functionality (not mocks of mocks)
- Have clear, descriptive names
- Test one thing per test
- Not test things that don't exist

## Refactoring with AI

### Safe Refactoring Prompts

✅ **Good**:
```
"Rename this variable to be more descriptive"
"Extract this code into a function with a clear name"
"Simplify this conditional logic"
```

❌ **Avoid**:
```
"Refactor this into a design pattern"
"Add abstraction layers for flexibility"
"Make this more generic and reusable"
```

## Team Standards

### Code Review for AI Code

When reviewing AI-generated code:

1. **Check for complexity**: Is it simpler than human might write?
2. **Verify necessity**: Is everything in the code needed now?
3. **Inspect abstractions**: Are they justified?
4. **Review names**: Are they clear and descriptive?
5. **Question patterns**: Are design patterns actually needed?

### Communicating Issues

If AI code doesn't meet standards:

```
❌ "This is too complex"
✅ "Can you simplify this? We don't need the factory pattern 
   since we only have one user type"

❌ "Bad code"
✅ "This adds features we don't need. Please remove the 
   metadata and settings properties and only keep id, name, email"

❌ "Use better names"
✅ "Please rename 'usrMgr' to 'userManager' and 'calc' to 
   'calculateTotal' - we use full descriptive names"
```

## Summary

### Remember

1. **AI is a tool, not a decision maker**
   - You decide what code to accept
   - Question suggestions that seem complex

2. **Simple beats clever**
   - Clear code > elegant abstractions
   - Working code > extensible frameworks

3. **Build what you need now**
   - Not what you might need later
   - Add features when requirements come

4. **Names matter**
   - AI often suggests abbreviated names
   - Always use full, descriptive names

5. **Review everything**
   - Don't blindly accept suggestions
   - Think about whether code is needed

### Quick Decision Guide

Ask yourself:
- Do I need this abstraction? → Probably not
- Will I use this feature now? → If not, don't add it
- Can I understand this in 6 months? → Names should be clear
- Is this the simplest solution? → If not, simplify it

## Related Documentation

- [Coding Standards](./coding-standards.md)
- [Naming Conventions](./naming-conventions.md)
- [Development Workflow](../dev_docs/workflows/development-workflow.md)
