## ADR-0021: Implement Makefile for Common Operations

**Status**: Accepted

**Context**:
Need simple, documented commands for common development tasks.

**Decision**:
Create a Makefile with targets for frequent operations like starting services, clearing cache, and accessing containers.

**Consequences**:
- **Positive**:
    - Simplified command interface
    - Self-documenting with target descriptions
    - Consistent across projects
    - Easy for new developers
- **Negative**:
    - Another tool to learn
    - Limited to Unix-like systems
    - Can hide complexity
    - Must maintain both Makefile and Docker Compose

**Implementation Details**:
- `Makefile` in project root
- Commands for Docker operations, cache clearing, documentation generation
- Uses user/group ID for file permission management
- Targets include: `up`, `build_doc`, `cc`, `prompt`