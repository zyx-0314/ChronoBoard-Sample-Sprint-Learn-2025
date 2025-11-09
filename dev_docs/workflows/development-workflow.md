# Development Workflow

## Overview

This document outlines the development workflow for ChronoBoard. Follow these steps to contribute effectively while maintaining code quality and consistency.

## Core Principles

- **KISS (Keep It Simple, Stupid)**: Write simple, straightforward code
- **YAGNI (You Aren't Gonna Need It)**: Don't add functionality until necessary
- **MVP Mindset**: Focus on minimum viable implementation first
- **Clear Naming**: Use descriptive, full-word names (no acronyms or 1-2 letter identifiers)

## Development Steps

### 1. Start New Work

1. **Sync with main branch**
   ```bash
   git checkout main
   git pull origin main
   ```

2. **Create feature branch**
   ```bash
   git checkout -b feature/descriptive-feature-name
   ```
   
   Branch naming conventions:
   - `feature/` - New features
   - `fix/` - Bug fixes
   - `docs/` - Documentation updates
   - `refactor/` - Code refactoring
   - `test/` - Test additions or updates

### 2. Make Changes

1. **Write simple, clear code**
   - Use full, descriptive variable and function names
   - Avoid premature abstractions
   - Implement only what is needed now

2. **Commit frequently with clear messages**
   ```bash
   git add .
   git commit -m "Add user authentication endpoint"
   ```

3. **Keep commits focused and atomic**
   - Each commit should represent one logical change
   - Write descriptive commit messages in present tense

### 3. Test Your Changes

1. **Run local tests**
   ```bash
   # See dev_docs/testing/testing-strategy.md for details
   composer test
   ```

2. **Test manually in development environment**
   - Use Docker or Codespaces for consistent environment
   - Verify functionality works as expected

### 4. Submit for Review

1. **Push your branch**
   ```bash
   git push origin feature/descriptive-feature-name
   ```

2. **Create Pull Request**
   - Use PR template in formats/pull-request-template.md
   - Link related issues
   - Describe what changed and why
   - Include testing steps

3. **Address review feedback**
   - Make requested changes
   - Push updates to same branch
   - Respond to comments

### 5. Merge and Deploy

1. **After approval, merge PR**
   - Squash commits if necessary
   - Delete feature branch after merge

2. **Verify deployment**
   - Check CI/CD pipeline status
   - Monitor for issues

## Daily Workflow

```
┌─────────────────┐
│  Pull latest    │
│  from main      │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│  Create feature │
│  branch         │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│  Write code     │
│  + tests        │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│  Commit and     │
│  push           │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│  Create PR      │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│  Code review    │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│  Merge to main  │
└─────────────────┘
```

## Best Practices

### Code Quality

- Write self-documenting code with clear names
- Add comments only when code cannot be made clearer
- Follow project coding standards (see guidelines/coding-standards.md)
- Run linter before committing

### Collaboration

- Communicate early and often
- Ask questions when unclear
- Review others' code thoughtfully
- Be respectful in feedback

### Productivity

- Focus on one task at a time
- Keep PRs small and focused
- Don't overthink solutions
- Refactor only when needed

## Common Commands

```bash
# Check current status
git status

# View differences
git diff

# Stash changes temporarily
git stash
git stash pop

# Update branch with main
git checkout main
git pull
git checkout feature/your-branch
git merge main

# Undo last commit (keep changes)
git reset --soft HEAD~1
```

## Getting Help

- Review documentation in dev_docs/
- Ask team members
- Check existing code for patterns
- Refer to coding standards

## Anti-Patterns to Avoid

❌ **Don't create unused abstractions**
- Don't create base classes "just in case"
- Don't add configuration options you don't need yet

❌ **Don't implement speculative features**
- Build what is needed now
- Wait for requirements before adding functionality

❌ **Don't use unclear naming**
- Avoid: `u`, `tmp`, `data`, `mgr`, `ctrl`
- Use: `user`, `temporaryFile`, `userProfile`, `userManager`, `authenticationController`

❌ **Don't skip testing**
- Always test your changes
- Add tests for new features

## Next Steps

- Review [Branch Strategy](./branch-strategy.md)
- Read [Code Review Process](./code-review-process.md)
- Check [Coding Standards](../guidelines/coding-standards.md)
