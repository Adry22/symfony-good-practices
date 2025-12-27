## ADR-0015: Implement OpenAPI Documentation with Nelmio

**Status**: Accepted

**Context**:
Need comprehensive, maintainable API documentation that stays in sync with implementation.

**Decision**:
Use NelmioApiDocBundle with PHP 8 attributes for inline API documentation.

**Consequences**:
- **Positive**:
    - Documentation lives with code
    - Automatic OpenAPI spec generation
    - Swagger UI integration
    - Type-safe documentation attributes
- **Negative**:
    - Verbose controller annotations
    - Documentation can clutter code
    - Must remember to update docs with changes
    - Build step required to generate YAML

**Implementation Details**:
- OpenAPI attributes on controller methods
- YAML spec generated via `composer docs` command
- Swagger UI container in Docker Compose
- Spec served at `public/universe.yaml`