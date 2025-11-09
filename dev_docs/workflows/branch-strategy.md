# Branch Strategy

## Overview

This document defines the branching strategy for ChronoBoard. We use a simplified Git workflow that emphasizes clarity and maintainability.

## Branch Types

### Main Branch

- **Name**: `main`
- **Purpose**: Production-ready code
- **Protection**: Protected, requires PR and review
- **Deployment**: Auto-deploys to production

**Rules**:
- Never commit directly to main
- All changes via Pull Request
- Must pass all tests and checks
- Requires at least one approval

### Feature Branches

- **Naming**: `feature/descriptive-name`
- **Purpose**: Develop new features
- **Lifespan**: Short-lived (delete after merge)

**Examples**:
```
feature/user-authentication
feature/task-creation-endpoint
feature/email-notification-system
```

**Workflow**:
1. Branch from main
2. Develop feature
3. Create PR to main
4. Merge after approval
5. Delete branch

### Fix Branches

- **Naming**: `fix/descriptive-issue-name`
- **Purpose**: Bug fixes
- **Lifespan**: Short-lived (delete after merge)

**Examples**:
```
fix/login-validation-error
fix/email-sending-timeout
fix/date-formatting-issue
```

**Workflow**:
1. Branch from main
2. Fix bug
3. Add test to prevent regression
4. Create PR to main
5. Merge after approval
6. Delete branch

### Documentation Branches

- **Naming**: `docs/what-is-documented`
- **Purpose**: Documentation updates
- **Lifespan**: Short-lived (delete after merge)

**Examples**:
```
docs/setup-instructions
docs/api-documentation
docs/deployment-guide
```

### Refactor Branches

- **Naming**: `refactor/what-is-refactored`
- **Purpose**: Code improvements without changing functionality
- **Lifespan**: Short-lived (delete after merge)

**Examples**:
```
refactor/authentication-service
refactor/database-queries
refactor/error-handling
```

### Test Branches

- **Naming**: `test/what-is-tested`
- **Purpose**: Adding or improving tests
- **Lifespan**: Short-lived (delete after merge)

**Examples**:
```
test/user-authentication-tests
test/api-endpoint-integration-tests
```

## Branch Naming Conventions

### Do ✅

- Use lowercase letters
- Use hyphens to separate words
- Be descriptive and specific
- Use full words, not abbreviations

**Good Examples**:
```
feature/user-profile-management
fix/password-reset-email-failure
docs/docker-setup-instructions
refactor/user-service-error-handling
```

### Don't ❌

- Use vague names
- Use acronyms or abbreviations
- Use underscores or camelCase
- Use ticket numbers only

**Bad Examples**:
```
feature/tmp          # Too vague
fix/bug              # Not descriptive
feature/usr-mgmt     # Uses abbreviations
FEATURE/Test         # Wrong case
feature_new_stuff    # Uses underscores
```

## Working with Branches

### Creating a Branch

```bash
# Ensure you're on main and up to date
git checkout main
git pull origin main

# Create and switch to new branch
git checkout -b feature/your-feature-name
```

### Pushing a Branch

```bash
# First time push
git push -u origin feature/your-feature-name

# Subsequent pushes
git push
```

### Updating Branch with Main

```bash
# Option 1: Merge (recommended for most cases)
git checkout feature/your-feature-name
git merge main

# Option 2: Rebase (for cleaner history, use with caution)
git checkout feature/your-feature-name
git rebase main
```

### Deleting Branches

```bash
# Delete local branch (after merge)
git branch -d feature/your-feature-name

# Delete remote branch (usually done automatically by GitHub)
git push origin --delete feature/your-feature-name
```

## Branch Lifecycle

```
main
  │
  ├─ feature/user-login ──┐
  │                        │ (develop)
  │                        │
  │                        │ (PR created)
  │                        │
  │ ◄──────────────────────┘ (merge + delete)
  │
  ├─ fix/login-error ──────┐
  │                         │ (fix bug)
  │                         │
  │ ◄───────────────────────┘ (merge + delete)
  │
  ▼ (continues...)
```

## Pull Request Process

1. **Before Creating PR**
   - Ensure branch is up to date with main
   - Run all tests locally
   - Review your own changes

2. **Creating PR**
   - Use descriptive title
   - Fill out PR template
   - Link related issues
   - Request reviewers

3. **During Review**
   - Address feedback promptly
   - Push changes to same branch
   - Discuss disagreements respectfully

4. **After Approval**
   - Merge using "Squash and merge" for cleaner history
   - Delete branch after merge
   - Verify deployment

## Best Practices

### Keep Branches Small

- Focus on single feature or fix
- Easier to review
- Faster to merge
- Less merge conflicts

### Update Regularly

- Merge main into feature branch frequently
- Reduces merge conflicts
- Keeps branch current

### Short Lifespan

- Create branch when starting work
- Merge within days, not weeks
- Delete immediately after merge

### Clear Ownership

- One person primarily responsible per branch
- Communicate before working on someone else's branch

## Handling Merge Conflicts

1. **Update your branch**
   ```bash
   git checkout feature/your-feature
   git merge main
   ```

2. **Resolve conflicts**
   - Open conflicted files
   - Choose correct version
   - Remove conflict markers
   - Test changes

3. **Complete merge**
   ```bash
   git add .
   git commit -m "Resolve merge conflicts with main"
   git push
   ```

## Alternative Branches (Reference)

The repository may include alternate implementation branches:

- Branches exploring PostgreSQL implementation
- Branches exploring GraphQL implementation
- These are learning resources, not for direct merging

## Common Scenarios

### Scenario: Need to switch branches mid-work

```bash
# Save current work
git stash

# Switch to other branch
git checkout other-branch

# Do work on other branch...

# Return to original branch
git checkout feature/original-branch
git stash pop
```

### Scenario: Made commits to wrong branch

```bash
# Note the commit hash
git log

# Switch to correct branch
git checkout correct-branch

# Cherry-pick commit
git cherry-pick <commit-hash>

# Go back and remove from wrong branch
git checkout wrong-branch
git reset --hard HEAD~1
```

### Scenario: Need to update branch name

```bash
# Rename local branch
git branch -m old-name new-name

# Delete old remote branch and push new one
git push origin --delete old-name
git push -u origin new-name
```

## Summary

- Use descriptive, lowercase, hyphenated branch names
- Keep branches short-lived
- Merge frequently
- Delete after merge
- Follow naming conventions
- Focus on single purpose per branch

## Related Documentation

- [Development Workflow](./development-workflow.md)
- [Code Review Process](./code-review-process.md)
- [Coding Standards](../guidelines/coding-standards.md)
