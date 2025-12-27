## ADR-0017: Implement CircleCI for Continuous Integration

**Status**: Accepted

**Context**:
Need automated testing and code quality checks on every commit.

**Decision**:
Use CircleCI for CI/CD pipeline with PHPStan static analysis and PHPUnit tests.

**Consequences**:
- **Positive**:
    - Automated quality gates
    - Early bug detection
    - Fast feedback on pull requests
    - Consistent build environment
- **Negative**:
    - CI configuration maintenance
    - Build time costs
    - Can slow down rapid development
    - Requires internet connection for builds

**Implementation Details**:
- Pipeline defined in `.circleci/config.yml`
- Steps: dependency caching, static analysis, migrations, fixtures, tests
- Docker-based CI environment
- PHPStan level 5 enforcement