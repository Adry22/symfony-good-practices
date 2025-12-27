## ADR-0010: Use Embeddable Objects for Composed Value Objects

**Status**: Accepted

**Context**:
Need to represent complex value objects (like Address and UserProfile) that are part of an entity but not entities themselves.

**Decision**:
Use Doctrine's `#[ORM\Embeddable]` attribute for composed Value Objects like Address and UserProfile.

**Consequences**:
- **Positive**:
    - No separate table for embedded objects
    - Maintains Value Object semantics
    - Better performance (no joins)
    - Clear domain model representation
- **Negative**:
    - All fields stored in parent entity table
    - Cannot query embedded objects independently
    - Column naming can be confusing
    - Nullable handling can be tricky

**Implementation Details**:
- `Address` and `UserProfile` marked as `#[ORM\Embeddable]`
- Embedded in User entity with `#[ORM\Embedded]`
- Prefix used to avoid column name conflicts