## ADR-0004: Implement Domain Events with Event Bus

**Status**: Accepted

**Context**:
Need to decouple domain logic and trigger side effects (like sending emails) when domain events occur.

**Decision**:
Implement Domain Events pattern with an Event Bus using Symfony's EventDispatcher, publishing events from Aggregate Roots.

**Consequences**:
- **Positive**:
    - Loose coupling between domain logic and side effects
    - Single Responsibility: entities focus on business logic
    - Easy to add new event listeners without modifying domain code
    - Better testability (can verify events are published)
- **Negative**:
    - Async behavior can make debugging harder
    - Event ordering dependencies need careful management
    - More indirection in the codebase

**Implementation Details**:
- `AggregateRoot` base class records events
- `DomainEventPublisherMiddleware` publishes events after command execution
- Event subscribers in `Application/EventListener/`
- Events in `Domain/Event/` (e.g., `UserRegistered`, `UserNameChanged`, `UserAddressChanged`)