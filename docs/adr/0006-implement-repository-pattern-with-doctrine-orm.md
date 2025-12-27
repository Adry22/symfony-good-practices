## ADR-0006: Implement Repository Pattern with Doctrine ORM

**Status**: Accepted

**Context**:
Need to abstract data persistence and provide a domain-oriented interface for data access.

**Decision**:
Use Repository pattern with Doctrine ORM as the persistence implementation, keeping repositories as interfaces in the domain layer.

**Consequences**:
- **Positive**:
    - Domain layer remains independent of persistence technology
    - Easy to mock for testing
    - Can switch ORM or database without changing domain code
    - Query logic centralized in repositories
- **Negative**:
    - Two repository classes per entity (interface + implementation)
    - Doctrine-specific code leaks into infrastructure layer
    - Learning curve for custom Doctrine types

**Implementation Details**:
- Repository interfaces in domain: `Domain/Repository/`
- Doctrine implementations in infrastructure: `Infrastructure/Repository/`
- `BaseRepository` provides common functionality
- Custom types for Value Objects