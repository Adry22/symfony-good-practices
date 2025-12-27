## ADR-0011: Implement Builder Pattern for Test Fixtures

**Status**: Accepted

**Context**:
Tests need flexible, readable ways to create domain objects with various configurations.

**Decision**:
Implement Builder pattern for constructing test fixtures with fluent interface.

**Consequences**:
- **Positive**:
    - Highly readable test setup code
    - Easy to create objects with specific configurations
    - Reduces test code duplication
    - Optional properties easy to handle
- **Negative**:
    - Additional maintenance for builders
    - Must keep builders in sync with entities
    - Potential for builder explosion

**Implementation Details**:
- Builders in `tests/Common/Builder/` namespace
- `BuilderFactory` provides centralized access
- Fluent interface with `with*()` methods
- Used extensively in unit and integration tests