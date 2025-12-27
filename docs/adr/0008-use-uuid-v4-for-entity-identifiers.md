## ADR-0008: Use UUID v4 for Entity Identifiers

**Status**: Accepted

**Context**:
Need globally unique identifiers that can be generated without database access and don't expose sequence information.

**Decision**:
Use UUID version 4 for all entity identifiers (UserId, PlanetId) instead of auto-incrementing integers.

**Consequences**:
- **Positive**:
    - Can generate IDs before persistence
    - Globally unique across distributed systems
    - No security issues with sequential IDs
    - Enables offline ID generation
- **Negative**:
    - Larger storage requirement (16 bytes vs 4-8 bytes)
    - Less human-readable
    - Slightly slower indexing performance
    - Cannot infer insertion order from ID

**Implementation Details**:
- `UuidValueObject` abstract base class
- Custom Doctrine types for each UUID value object
- Ramsey UUID library for generation and validation
- Validation enforces UUID v4 only