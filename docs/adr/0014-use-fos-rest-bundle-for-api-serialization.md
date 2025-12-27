## ADR-0014: Use FOS REST Bundle for API Serialization

**Status**: Accepted

**Context**:
Need consistent JSON serialization for API responses with proper content negotiation.

**Decision**:
Use FOSRestBundle with JMS Serializer for handling API responses and serialization.

**Consequences**:
- **Positive**:
    - Automatic content negotiation
    - Flexible serialization configuration
    - View layer separation from domain
    - Standard REST practices enforced
- **Negative**:
    - Additional layer of abstraction
    - Configuration overhead
    - Learning curve for serialization groups
    - Bundle is in maintenance mode

**Implementation Details**:
- `ApiController` extends `AbstractFOSRestController`
- JMS Serializer for object serialization
- View layer handling in controllers
- JSON as default format