## ADR-0002: Implement CQRS Pattern with Tactician

**Status**: Accepted

**Context**:
Need to separate read and write operations, improve scalability, and maintain clear responsibilities in the application layer.

**Decision**:
Use CQRS (Command Query Responsibility Segregation) pattern with Tactician command bus library for both commands and queries.

**Consequences**:
- **Positive**:
  - Clear separation between write operations (Commands) and read operations (Queries)
  - Each use case has its own handler with single responsibility
  - Easier to test individual handlers
  - Middleware support for cross-cutting concerns (logging, transactions, events)
- **Negative**:
  - More boilerplate code for simple operations
  - Two separate buses to configure and maintain
  - Learning curve for team members unfamiliar with CQRS

**Implementation Details**:
- Commands in `Application/Command/` namespace
- Queries in `Application/Query/` namespace
- Tactician configured in `config/packages/config.yaml`
- Separate buses for commands and queries