## ADR-0020: Use Password Hashing with Symfony Security Component

**Status**: Accepted

**Context**:
Need secure password storage that follows current best practices.

**Decision**:
Use Symfony's `UserPasswordHasherInterface` with automatic algorithm selection for password hashing.

**Consequences**:
- **Positive**:
    - Industry-standard password hashing (bcrypt)
    - Automatic algorithm upgrades possible
    - Built-in salt management
    - Framework integration
- **Negative**:
    - Tied to Symfony Security component
    - Cannot easily port to other frameworks
    - Performance impact on authentication

**Implementation Details**:
- `Password` Value Object stores hashed passwords
- `UserPasswordHasherInterface` injected into command handlers
- Configured in `config/packages/security.yaml`
- Auto algorithm selection enabled