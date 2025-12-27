## ADR-0019: Implement Doctrine Migrations for Schema Management

**Status**: Accepted

**Context**:
Need version-controlled, reproducible database schema changes across environments.

**Decision**:
Use Doctrine Migrations for all database schema changes with auto-generated migration files.

**Consequences**:
- **Positive**:
    - Version-controlled schema changes
    - Rollback capability
    - Consistent schema across environments
    - Audit trail of changes
- **Negative**:
    - Must review auto-generated migrations
    - Can't easily branch with schema changes
    - Migration conflicts on concurrent development
    - Production migration timing critical

**Implementation Details**:
- Migrations in `migrations/` directory
- Auto-generated from entity metadata changes
- Executed in CI pipeline before tests
- Separate migration per schema change