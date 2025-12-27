## ADR-0016: Use Docker for Development Environment

**Status**: Accepted

**Context**:
Need consistent, reproducible development environment across different machines and team members.

**Decision**:
Use Docker Compose with separate containers for Nginx, PHP-FPM, MySQL, Swagger UI, and Mailcatcher.

**Consequences**:
- **Positive**:
    - Consistent environment for all developers
    - Easy onboarding for new team members
    - Isolated services
    - Matches production-like setup
- **Negative**:
    - Performance overhead on non-Linux systems
    - Docker learning curve
    - Debugging can be more complex
    - Resource usage

**Implementation Details**:
- Services defined in `docker-compose.yml`
- Custom PHP Dockerfile with extensions
- Volume mounts for live code updates
- Makefile for common operations