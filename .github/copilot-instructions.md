<!--
  Purpose: concise, repository-specific instructions for AI coding agents (GitHub Copilot, ChatGPT, etc.)
  Keep this file short (20–50 lines). Prefer precise, actionable rules and file references.
-->

# Copilot / AI assistant instructions — ChronoBoard-Sample-Sprint-Learn-2025

Short guidance to help an AI agent produce changes that match this repo's conventions and developer workflows.

## Big picture (quick)

- Backend demo built on PHP (Yii2), MySQL/PostgreSQL, Redis, containerized with Docker. Main artefacts: application code, tests, and developer docs under `dev_docs/`.
- Key infra: `docker-compose.yml` (local), `docker-compose.prod.yml` (prod examples in docs), GitHub Actions for CI/CD (see `dev_docs/deployment/deployment-process.md`).

## Essential rules for automated edits

1. Follow the project's KISS / YAGNI / MVP principles (see `guidelines/ai-assisted-development.md`). Make the smallest change that satisfies the requirement.
2. Naming and style: variables & functions use camelCase (e.g. `$userName`, `getUserProfile()`); classes use PascalCase (`UserAuthenticationService`); file names use kebab-case (`user-authentication-service.php`); constants use UPPER_SNAKE_CASE (`MAX_LOGIN_ATTEMPTS`). See `guidelines/naming-conventions.md` and `guidelines/coding-standards.md` for examples.
3. Avoid premature abstractions: do not introduce new base classes, generic `Utils`/`Helper` dumps, or factories for a single concrete type. If unsure, prefer a simple function or a single-purpose class.
4. Tests required: any behavior change must include a test. Run locally with `composer test` or `docker-compose exec app composer test` (Docker). See `dev_docs/testing/testing-strategy.md` for test conventions.
5. Keep PRs small and focused. Use the PR template `formats/pull-request-template.md` and fill the "What changed" and "How to test" sections explicitly.
6. Do not add new runtime dependencies without justification. If a package is added, also update `composer.json`, document why, and add tests.

## Common commands (examples found in docs)

- Install deps: `composer install` (or containerized equivalent)
- Run tests: `composer test` or `docker-compose exec app composer test`
- Lint / style: `composer lint` (see repo templates)
- Local dev: `docker-compose up -d` / `docker-compose down`
- Production build (docs show): `docker-compose -f docker-compose.prod.yml build` and `docker-compose -f docker-compose.prod.yml up -d` (see `dev_docs/deployment/deployment-process.md`).

## Integration & secrets to be aware of

- External services: MySQL, Redis, Docker, GitHub Container Registry (ghcr), GitHub Actions. The example deploy workflow references `ghcr.io` and `appleboy/ssh-action` (see deployment doc).
- Deployment-related secrets: `PRODUCTION_HOST`, `PRODUCTION_USER`, `SSH_PRIVATE_KEY` are expected by the example workflow.

## Where to look before coding

- `README.md` — top-level project overview
- `dev_docs/setup/` — environment & Codespaces instructions (`.devcontainer`)
- `dev_docs/testing/testing-strategy.md` — testing rules and examples
- `dev_docs/deployment/deployment-process.md` — CI/CD examples and deployment commands
- `guidelines/ai-assisted-development.md`, `guidelines/coding-standards.md`, `guidelines/naming-conventions.md` — style + AI rules
- `formats/pull-request-template.md`, `formats/issue-template.md` — how to format PRs and issues

## If you are the AI and uncertain

- If the task scope is ambiguous, generate a small change and include a clear PR description + tests. If still unsure, create an issue using `formats/issue-template.md` and request human guidance.

---

Please review this draft and tell me any missing repo-specific details or commands you'd like included.
