## ADR-0007: Use JWT for Stateless Authentication

**Status**: Accepted

**Context**:
API needs secure, scalable authentication that doesn't require server-side session storage.

**Decision**:
Implement JWT (JSON Web Tokens) based authentication using LexikJWTAuthenticationBundle.

**Consequences**:
- **Positive**:
    - Stateless authentication enables horizontal scaling
    - No session storage required on server
    - Can be used across multiple services
    - Standard, well-supported approach
- **Negative**:
    - Cannot revoke tokens before expiration
    - Token size larger than session IDs
    - Requires secure key management
    - Token refresh strategy needed for long sessions

**Implementation Details**:
- LexikJWTAuthenticationBundle configured in `config/packages/lexik_jwt_authentication.yaml`
- `/login` endpoint for token generation
- JWT keys stored in `config/jwt/`
- Token TTL: 3600 seconds (1 hour)