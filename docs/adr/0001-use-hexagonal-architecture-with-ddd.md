## ADR-0001: Use Hexagonal Architecture with DDD Tactical Patterns

**Status**: Accepted

**Context**:
The project needs a clean, maintainable architecture that separates business logic from infrastructure concerns and allows for testability and flexibility.

**Decision**:
Implement Hexagonal Architecture (Ports & Adapters) combined with Domain-Driven Design tactical patterns, organizing code into distinct bounded contexts (Planet, User, Shared).

**Consequences**:
- **Positive**:
  - Clear separation between domain logic and infrastructure
  - Business logic is framework-agnostic and highly testable
  - Easy to swap implementations (e.g., repositories, mailers)
  - Better code organization and maintainability
- **Negative**:
  - Increased initial complexity and learning curve
  - More files and abstractions than traditional MVC
  - Requires discipline to maintain boundaries

**Implementation Details**:
- Domain entities in `src/{Context}/Domain/Entity/`
- Application layer with Commands/Queries in `src/{Context}/Application/`
- Infrastructure adapters in `src/{Context}/Infrastructure/`
- Domain logic is independent of Symfony framework