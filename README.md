# ChronoBoard-Sample-Sprint-Learn-2025

ChronoBoard-Sample-Sprint-Learn-2025 is a backend learning demo built with Yii2, Tailwind, and MySQL (PostgreSQL and GraphQL on alternate branches). It covers authentication with RBAC, REST APIs, caching, mail queues, and CI/CD via Docker and GitHub Actions—emphasizing clarity, scalability, and disciplined engineering.

## Quick Start

Get started quickly with one of these setup options:

- **[Docker Setup](dev_docs/setup/docker-setup.md)** - Recommended for local development
- **[Codespaces Setup](dev_docs/setup/codespaces-setup.md)** - Cloud-based development environment
- **[Manual Setup](dev_docs/setup/environment-setup.md)** - Traditional local installation

## Development Principles

This project follows **KISS** (Keep It Simple, Stupid), **YAGNI** (You Aren't Gonna Need It), and **MVP** (Minimum Viable Product) principles:

- ✅ Write simple, clear code with descriptive names (no abbreviations)
- ✅ Implement only what's needed now
- ✅ Focus on readability and maintainability
- ❌ No unnecessary abstractions or complexity
- ❌ No speculative features
- ❌ No premature optimization

## Documentation

📖 **[Full Documentation Index](DOCUMENTATION.md)** - Complete guide to all documentation

### For Developers

**Getting Started**
- [Environment Setup Guide](dev_docs/setup/environment-setup.md)
- [Docker Setup Guide](dev_docs/setup/docker-setup.md)
- [Codespaces Setup Guide](dev_docs/setup/codespaces-setup.md)

**Development Workflow**
- [Development Workflow](dev_docs/workflows/development-workflow.md) - Daily development process
- [Branch Strategy](dev_docs/workflows/branch-strategy.md) - Git branching conventions
- [Code Review Process](dev_docs/workflows/code-review-process.md) - How we review code

**Code Standards**
- [Coding Standards](guidelines/coding-standards.md) - Code quality guidelines
- [Naming Conventions](guidelines/naming-conventions.md) - How to name variables, functions, classes
- [AI-Assisted Development](guidelines/ai-assisted-development.md) - Using AI tools effectively

**Testing & Deployment**
- [Testing Strategy](dev_docs/testing/testing-strategy.md) - How to write and run tests
- [Deployment Process](dev_docs/deployment/deployment-process.md) - Deploying with Docker and CI/CD

### Templates and Examples

- [Pull Request Template](formats/pull-request-template.md) - PR format
- [Issue Template](formats/issue-template.md) - Issue reporting format
- [README Template](formats/readme-template.md) - Documentation template

## Contributing

We welcome contributions! Here's how to get started:

1. **Read the documentation** - Familiarize yourself with our workflows and standards
2. **Set up your environment** - Follow the [setup guide](dev_docs/setup/environment-setup.md)
3. **Pick an issue** - Find something to work on
4. **Create a branch** - Follow our [branch strategy](dev_docs/workflows/branch-strategy.md)
5. **Make changes** - Follow our [coding standards](guidelines/coding-standards.md)
6. **Submit a PR** - Use the [PR template](formats/pull-request-template.md)

See [Development Workflow](dev_docs/workflows/development-workflow.md) for detailed contribution guidelines.

## Key Features

- **Authentication with RBAC** - Role-based access control
- **REST APIs** - Well-structured API endpoints
- **Caching** - Redis-based caching
- **Email Queues** - Asynchronous email processing
- **Docker Support** - Containerized development and deployment
- **CI/CD** - Automated testing and deployment via GitHub Actions

## Technology Stack

- **Backend**: PHP 8.1, Yii2 Framework
- **Database**: MySQL 8.0 (PostgreSQL on alternate branch)
- **Frontend**: Tailwind CSS
- **API**: REST (GraphQL on alternate branch)
- **Caching**: Redis
- **Containerization**: Docker & Docker Compose
- **CI/CD**: GitHub Actions

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Support

- **Documentation**: See `dev_docs/` for comprehensive guides
- **Issues**: Report bugs or request features via [GitHub Issues](../../issues)
- **Questions**: Ask in [GitHub Discussions](../../discussions)

---

**Note**: This project emphasizes clean, maintainable code. All contributions should follow our principles of simplicity, clarity, and avoiding unnecessary complexity.
