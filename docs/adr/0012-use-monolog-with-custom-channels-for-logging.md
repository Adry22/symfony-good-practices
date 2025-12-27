## ADR-0012: Use Monolog with Custom Channels for Logging

**Status**: Accepted

**Context**:
Need structured logging with different handlers and formatters for various application concerns.

**Decision**:
Use Symfony MonologBundle with custom channels, specifically creating a `main_log` channel with JSON formatting.

**Consequences**:
- **Positive**:
  - Structured, parseable logs
  - Separate log streams for different concerns
  - Easy integration with log aggregation tools
  - Flexible handler configuration per environment
- **Negative**:
  - Additional configuration required
  - Must explicitly inject named loggers
  - JSON logs less human-readable in development

**Implementation Details**:
- Custom channel defined in `config/packages/monolog.yaml`
- Rotating file handler for `main_log`
- JSON formatter for structured logging
- Different configurations per environment (dev, prod)