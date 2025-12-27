## ADR-0013: Implement Document Generation with PhpOffice

**Status**: Accepted

**Context**:
Need to generate Excel (.xlsx) and Word (.docx) documents from domain data.

**Decision**:
Use PhpOffice libraries (PhpSpreadsheet and PhpWord) with custom Writer implementations following Strategy pattern.

**Consequences**:
- **Positive**:
    - Clean separation of document generation logic
    - Easy to add new document types
    - Template-based Word generation
    - Professional-quality output
- **Negative**:
    - Large library dependencies
    - Memory intensive for large documents
    - Template maintenance for Word documents
    - Limited to Office formats

**Implementation Details**:
- `DownloadExcelPlanetListWriter` for Excel generation
- `DownloadWordPlanetListWriter` extends `PhpWordWriter` base class
- Formatters prepare data: `DownloadPlanetListFormatter`
- Binary responses via controllers
- Template files stored in `listings/` directory