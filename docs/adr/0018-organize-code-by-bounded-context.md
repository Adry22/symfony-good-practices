## ADR-0018: Organize Code by Bounded Context

**Status**: Accepted

**Context**:
Need clear code organization that reflects business domains and prevents coupling.

**Decision**:
Organize source code into separate bounded contexts (Planet, User, Shared) at the top level, with each having its own Application, Domain, and Infrastructure layers.

**Consequences**:
- **Positive**:
  - Clear boundaries between business domains
  - Easier to reason about dependencies
  - Supports team specialization
  - Potential for future extraction into microservices
- **Negative**:
  - More directory structure to navigate
  - Shared code requires careful management
  - Can lead to code duplication to avoid coupling
  - Team must understand bounded context concept

**Implementation Details**:
- Top-level directories: `src/Planet/`, `src/User/`, `src/Shared/`
- Each context has Application, Domain, Infrastructure layers
- Shared context for cross-cutting concerns
- PSR-4 autoloading configured per context