## ADR-0003: Use Value Objects for Domain Primitives

**Status**: Accepted

**Context**:
Need to enforce business rules and validation at the domain level while preventing primitive obsession.

**Decision**:
Implement Value Objects for domain primitives like Email, Password, UserId, PlanetId, PlanetName, and Address.

**Consequences**:
- **Positive**:
  - Business rules encapsulated within Value Objects
  - Type safety and validation at compile/runtime
  - Immutability enforced (where applicable)
  - Self-documenting code
  - Prevents invalid state in domain entities
- **Negative**:
  - More classes to maintain
  - Requires custom Doctrine types for persistence
  - Initial development overhead

**Implementation Details**:
- Value Objects in domain layer: `Shared/Domain/ValueObject/`, `User/Domain/Entity/User/UserId/`
- Custom Doctrine types in infrastructure layer
- Validation logic in Value Object constructors