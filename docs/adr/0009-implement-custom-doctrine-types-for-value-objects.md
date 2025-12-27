## ADR-0009: Implement Custom Doctrine Types for Value Objects

**Status**: Accepted

**Context**:
Need to persist Value Objects while maintaining their domain semantics and validation rules.

**Decision**:
Create custom Doctrine types for all Value Objects to handle conversion between database values and domain objects.

**Consequences**:
- **Positive**:
    - Value Objects properly hydrated from database
    - Type safety maintained throughout the application
    - Validation happens automatically on hydration
    - Database schema reflects domain model
- **Negative**:
    - Additional code for each Value Object
    - Must register all custom types in Doctrine config
    - Potential performance overhead for complex types
    - Debugging can be more complex

**Implementation Details**:
- Custom types in `Infrastructure/ValueObject/*/Doctrine/`
- Types registered in `config/packages/doctrine.yaml`
- Types include: `UserIdDoctrineType`, `EmailDoctrineType`, `PasswordDoctrineType`, `PlanetIdDoctrineType`, `PlanetNameDoctrineType`
