## ADR-0005: Use Specification Pattern for Complex Queries

**Status**: Accepted

**Context**:
Need flexible, reusable query logic that can be combined and tested independently from the persistence layer.

**Decision**:
Implement the Specification pattern for complex domain queries, particularly for filtering and searching entities.

**Consequences**:
- **Positive**:
    - Reusable query logic across different contexts
    - Domain queries are testable in isolation
    - Can combine specifications using composite pattern
    - Query logic stays in the domain layer
- **Negative**:
    - More abstraction layers
    - Can be overkill for simple queries
    - Requires understanding of the pattern

**Implementation Details**:
- `Specification` interface in `Shared/Domain/Criteria/`
- `Criteria` value object combining Specification, Order, and PaginationLimits
- Concrete specifications like `ContainsPlanetNameSpecification`
- Repository methods accept Criteria objects