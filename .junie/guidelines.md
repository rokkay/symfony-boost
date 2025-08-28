# Initial Setup
- Scan and understand the entire project before starting.
- Get familiar with all existing conventions, coding styles, formats, and patterns.
- New code must strictly follow the same style — naming, structure, logic patterns, formatting, and architecture.
- Always add tests for new code, matching the structure and style of existing tests.

# Tooling
- Respect all tools and dependencies in composer.json.
- Use tools like PHPStan, Rector, PHPUnit, etc., as configured — no overrides.

# PHP Standards
- Use PHP 8.3 syntax and features.
- Enforce strict typing: scalar types, return types, property types — everywhere.
- Strict array shapes only — no loose or untyped arrays.
- Use enums for fixed values.
- Never use mixed types — including in array shapes.
- Do not auto-format or touch unrelated code.

# Code Quality
- Apply existing naming, formatting, and architectural patterns exactly.
- Do not deviate from established conventions.
- No commented-out code.
- Avoid magic strings and numbers.
- Keep classes/functions short, focused, and testable.

# Testing
- When editing code, run only the related tests during development.
- Before finishing the task, run `composer test` to ensure the full suite passes.

# Other
- Prefer value objects over raw arrays when appropriate.
- Avoid over-engineering — keep things simple and pragmatic.
- Never leave TODOs or FIXMEs without clear context or a linked issue.
- Never leave comments within code blocks, only on methods.