# Code Review Process

## Overview

Code review is essential for maintaining quality, sharing knowledge, and catching issues early. This document outlines our code review process for ChronoBoard.

## Goals of Code Review

1. **Quality Assurance**: Catch bugs and issues before they reach production
2. **Knowledge Sharing**: Spread understanding of codebase across team
3. **Consistency**: Maintain coding standards and patterns
4. **Learning**: Help developers improve their skills
5. **Collaboration**: Foster team communication and ownership

## Code Review Principles

### For Authors

- **Make reviewable changes**: Keep PRs small and focused
- **Provide context**: Explain why changes are needed
- **Self-review first**: Check your own code before requesting review
- **Be responsive**: Address feedback promptly
- **Stay humble**: Be open to suggestions and learning

### For Reviewers

- **Be constructive**: Focus on improving the code, not criticizing the author
- **Be thorough**: Review carefully but don't nitpick unnecessarily
- **Be timely**: Review within 24 hours when possible
- **Ask questions**: If something is unclear, ask rather than assume
- **Appreciate good work**: Acknowledge clever solutions and good practices

## When to Request Review

### Always Request Review For:

✅ New features
✅ Bug fixes
✅ Refactoring
✅ API changes
✅ Database schema changes
✅ Configuration changes
✅ Dependency updates
✅ Documentation updates

### May Skip Review For:

⚠️ Fixing typos in non-code files (use judgment)
⚠️ Updating version numbers only
⚠️ Emergency hotfixes (but get post-merge review)

## Pull Request Checklist

### Before Creating PR

- [ ] Code follows coding standards
- [ ] All tests pass locally
- [ ] New tests added for new functionality
- [ ] Code is self-documenting with clear names
- [ ] No commented-out code left in
- [ ] No debug statements or console logs
- [ ] Documentation updated if needed
- [ ] Branch is up to date with main

### Creating the PR

- [ ] Use descriptive title
- [ ] Fill out PR template completely
- [ ] Link related issues
- [ ] Describe what changed and why
- [ ] Include testing steps
- [ ] Add screenshots for UI changes
- [ ] Request appropriate reviewers

## What to Review

### Code Quality

1. **Readability**
   - Are names clear and descriptive?
   - Is the code easy to understand?
   - Is complexity necessary?

2. **Simplicity**
   - Is this the simplest solution?
   - Are there unnecessary abstractions?
   - Can any code be removed?

3. **Correctness**
   - Does code do what it claims?
   - Are edge cases handled?
   - Are errors handled appropriately?

4. **Testing**
   - Are there adequate tests?
   - Do tests cover edge cases?
   - Are tests clear and maintainable?

### Design and Architecture

1. **Adherence to Principles**
   - Does it follow KISS?
   - Does it follow YAGNI?
   - Is it MVP-focused?

2. **No Premature Optimization**
   - Is complexity justified?
   - Are abstractions needed now?
   - Will this really be reused?

3. **Consistency**
   - Matches existing patterns?
   - Follows project structure?
   - Uses established libraries?

### Security

1. **Input Validation**
   - User input validated?
   - SQL injection prevented?
   - XSS prevented?

2. **Authentication/Authorization**
   - Proper access controls?
   - Sensitive data protected?
   - Secure defaults used?

3. **Dependencies**
   - Known vulnerabilities checked?
   - Unnecessary dependencies avoided?
   - Versions pinned appropriately?

## Review Process

### Step 1: Initial Check (2-5 minutes)

Quick scan to understand:
- What is the PR trying to achieve?
- Is it appropriately sized?
- Does description provide adequate context?

**If PR is too large**: Request it be split into smaller PRs

### Step 2: Understand the Changes (5-15 minutes)

- Read the PR description and linked issues
- Understand the problem being solved
- Review the overall approach
- Check if tests are included

### Step 3: Detailed Code Review (15-30 minutes)

Go through each file:
1. Check naming and clarity
2. Look for potential bugs
3. Verify error handling
4. Check for security issues
5. Ensure tests are adequate
6. Verify documentation updates

### Step 4: Test the Changes (5-15 minutes)

- Pull branch locally if complex change
- Run tests
- Manually test functionality if needed
- Verify nothing is broken

### Step 5: Provide Feedback

Leave comments that are:
- **Specific**: Point to exact lines/issues
- **Constructive**: Suggest improvements
- **Categorized**: Mark as blocking vs. optional

## Providing Feedback

### Comment Types

**❗ Blocking Issues** - Must be fixed before merge
```
❗ This will cause a null pointer exception if user is not logged in.
Need to add authentication check.
```

**💡 Suggestions** - Improvements but not required
```
💡 Consider extracting this into a separate function for better readability.
Not blocking, but would improve maintainability.
```

**❓ Questions** - Need clarification
```
❓ Why are we using this approach instead of the existing utility?
Just curious about the reasoning.
```

**✅ Praise** - Acknowledge good work
```
✅ Nice job handling this edge case! Great use of the factory pattern here.
```

### Writing Good Comments

**Good Examples**:
```
❗ Line 45: This query is vulnerable to SQL injection. 
Use prepared statements instead:
$statement = $db->prepare("SELECT * FROM users WHERE id = ?");
$statement->execute([$userId]);
```

```
💡 Lines 120-150: This method is doing too much. Consider splitting into:
- validateUserInput()
- saveUserData()
- sendConfirmationEmail()
This would make testing easier and improve readability.
```

**Bad Examples**:
```
❌ "This is wrong."  # Not specific or helpful
❌ "Why would you do it this way?"  # Sounds judgmental
❌ "We don't do it like this."  # No explanation
```

## Responding to Feedback

### As the Author

1. **Read all comments carefully**
   - Understand the concern
   - Don't get defensive
   - Ask for clarification if needed

2. **Categorize feedback**
   - Must fix (blocking)
   - Should fix (suggestions)
   - Can discuss (questions/disagreements)

3. **Make changes**
   - Fix blocking issues
   - Consider suggestions
   - Respond to all comments

4. **Push updates**
   ```bash
   git add .
   git commit -m "Address review feedback: improve error handling"
   git push
   ```

5. **Reply to comments**
   - Mark resolved issues as resolved
   - Explain your changes
   - Continue discussion if needed

### Handling Disagreements

1. **Discuss respectfully**
   - Explain your reasoning
   - Be open to other perspectives
   - Focus on code, not people

2. **Seek common ground**
   - Find compromise if possible
   - Understand trade-offs
   - Consider asking third opinion

3. **Escalate if needed**
   - Bring to team discussion
   - Document decision
   - Move forward once decided

## Approval and Merge

### Approving a PR

**Approve when**:
- All blocking issues resolved
- Code meets standards
- Tests are adequate
- You understand the changes
- You'd be comfortable maintaining this code

**Request changes when**:
- Critical issues exist
- Tests are missing
- Security concerns present
- Doesn't meet standards

### Merging

1. **Final checks before merge**
   - All reviewers approved
   - All checks passing (CI/CD)
   - Branch up to date with main
   - No unresolved comments

2. **Merge strategy**
   - Use "Squash and merge" for cleaner history
   - Edit commit message if needed
   - Ensure good commit message

3. **After merge**
   - Delete feature branch
   - Verify deployment
   - Monitor for issues

## Time Expectations

### For Authors

- Wait up to 24 hours for initial review
- Respond to feedback within 24 hours
- Keep PRs moving forward

### For Reviewers

- Provide initial review within 24 hours
- Smaller PRs get priority
- Urgent fixes reviewed ASAP

### For Everyone

- Communicate if you'll be delayed
- Tag someone else if you can't review
- Don't let PRs get stale

## Common Review Scenarios

### Large PR

**Problem**: PR has 50+ files changed

**Solution**:
1. Ask author to split into smaller PRs
2. If impossible, schedule synchronous review
3. Focus on critical paths first

### Unclear Purpose

**Problem**: Don't understand what PR is trying to do

**Solution**:
1. Ask author to clarify in comments
2. Request better PR description
3. Link to relevant documentation/issues

### Style Nitpicks

**Problem**: Code works but doesn't match preferred style

**Solution**:
1. Only comment if it violates standards
2. Use linters to catch style issues automatically
3. Don't block PR for minor style preferences

### Missing Tests

**Problem**: New functionality without tests

**Solution**:
1. Request tests before approval (blocking)
2. Specify what scenarios need testing
3. Help author if they're unsure how to test

## Anti-Patterns to Avoid

### As Author

❌ **Creating huge PRs**: Keep changes small and focused
❌ **Not responding to feedback**: Address comments promptly
❌ **Taking feedback personally**: Focus on improving code
❌ **Ignoring suggestions**: Consider all feedback thoughtfully
❌ **Merging without approval**: Wait for proper review

### As Reviewer

❌ **Nitpicking unnecessarily**: Focus on important issues
❌ **Being vague**: Give specific, actionable feedback
❌ **Rubber-stamping**: Don't approve without reviewing
❌ **Being judgmental**: Focus on code, not person
❌ **Delaying reviews**: Review promptly

## Tools and Automation

### GitHub Features

- **Code owners**: Automatic reviewer assignment
- **Required reviews**: Enforce review before merge
- **Status checks**: Automated tests and linting
- **Templates**: Standardized PR format

### Automated Checks

- Linting (code style)
- Unit tests
- Integration tests
- Security scanning
- Build verification

## Review Checklist

Use this checklist when reviewing:

- [ ] Purpose and approach are clear
- [ ] Changes are minimal and focused
- [ ] Names are descriptive and clear
- [ ] No unnecessary abstractions or complexity
- [ ] No speculative features (YAGNI)
- [ ] Code follows KISS principle
- [ ] Error handling is appropriate
- [ ] Security concerns addressed
- [ ] Tests are included and adequate
- [ ] Documentation updated if needed
- [ ] No debugging code left in
- [ ] Follows coding standards
- [ ] Would be comfortable maintaining this code

## Summary

Good code review:
- Maintains quality
- Shares knowledge
- Improves code
- Helps team grow
- Moves quickly

Keys to success:
- Keep PRs small
- Review promptly
- Be constructive
- Stay focused on goals
- Communicate clearly

## Related Documentation

- [Development Workflow](./development-workflow.md)
- [Branch Strategy](./branch-strategy.md)
- [Coding Standards](../guidelines/coding-standards.md)
