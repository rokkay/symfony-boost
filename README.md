# Symfony Boost Bundle

Symfony Boost is a lightweight Symfony bundle that ships an MCP (Model Context Protocol) Server and a set of conventions to supercharge AI‑assisted development for Symfony projects. It is designed to work hand‑in‑hand with `symfony/mcp-bundle`, exposing your application’s context and safe tooling so AI agents (IDE copilots, chat assistants, or CI bots) can generate Symfony‑idiomatic code and perform routine maintenance tasks confidently.

> Status: Experimental. API and conventions may evolve ahead of a 1.0 release.

## Highlights

- First‑class MCP Server for Symfony via `symfony/mcp-bundle`.
- Sensible defaults: curated capabilities and safe tools for code generation and refactoring.
- Symfony‑aware prompts, scaffolds, and guardrails for common components (Controllers, Commands, Forms, Messages, Validators, Doctrine, HTTP‑Kernel, etc.).
- Documentation and patterns to keep AI changes maintainable, testable, and secure.

## Requirements

- PHP >= 8.3
- Symfony 6.4 or 7.x components (tested with 7.x)

See `composer.json` for exact constraints.

## Installation

```bash
composer require rokkay/symfony-boost --dev
```

Why --dev? The MCP server and AI tooling are typically used in development, CI, or local automation contexts.

### Bundle registration

If you use Symfony Flex, the bundle will be auto‑enabled. Otherwise, add it manually to your `config/bundles.php`:

```php
return [
    // ...
    Rokkay\SymfonyBoostBundle\RokkaySymfonyBoostBundle::class => ['all' => true],
];
```

## What the MCP Server provides

Through the MCP protocol, an AI client can:
- Inspect project structure (safe, read‑only file discovery and snippets)
- Propose code changes as patches with justification
- Generate Symfony‑aware scaffolding (controllers, commands, DTOs, message handlers, etc.)
- Run read‑only diagnostics (container‑lint, router:match, debug:container) and summarize
- Run guarded test commands (phpunit subsets) and parse results

All mutating actions are designed to be explicit, reviewable, and limited to allowed paths.

## Using with AI Clients

Most modern AI tools with MCP client support can connect to this server. Typical configurations:

```json
  "mcpServers":
  {
    "symfony-boost": {
      "command": "php",
      "args": [
        "/your/full/path/to/bin/console",
        "boost:mcp"
      ]
    }
  }
```
Once connected, the assistant will discover capabilities and available tools automatically.

## Boosting AI‑assisted development: Recommended Practices

- Keep the context rich and current
  - Ensure `composer.json` and `symfony.lock`/`composer.lock` are up‑to‑date so the assistant understands dependencies.
  - Prefer small, focused PRs; AI diff review works best with limited scope.
- Codify constraints
  - Use PHPStan and PHPUnit; expose their commands via the MCP diagnostic tools.
  - Adopt Rector or PHP CS Fixer for refactor/format, and prefer assistants to output proposed diffs.
- Guide the assistant
  - Provide clear intents: feature description, public API, and acceptance criteria.
  - Link to domain rules, ADRs, or docs; put them under `docs/` so the MCP read‑only tools can fetch them.
- Be explicit with write permissions
  - Restrict write paths to `src/` and `tests/` unless necessary.
  - Require justification for any file deletion or moves.
- Validate every change
  - Run `phpunit` and static analysis before merging.
  - Prefer “apply patch” flows over unrestricted file write operations.

## Example workflows

1) Generate a controller and test
- Ask your MCP client: “Create a Controller FooController with route /foo returning JSON, and a corresponding functional test.”
- The assistant proposes files under `src/Controller` and `tests/Functional` with a git‑style patch.
- You review and apply via your IDE.

2) Debug a failing route
- “List routes matching GET /api/users/42 and explain controller resolution.”
- The assistant runs `bin/console debug:router | grep users` (or an internal route matching tool) and summarizes.

3) Safe refactor
- “Extract service UserPasswordUpgrader, update DI wiring, and adjust consumers. Provide a patch and run PHPUnit subset for security.”

## Development

- Install dev tools:
  - `composer install`
  - `vendor/bin/phpstan analyse`
  - `vendor/bin/phpunit`
- Local MCP server:
  - `php bin/console mcp:serve`

Contributions are welcome. Please open issues with detailed repro steps and proposed improvements to MCP capabilities or guardrails.

## Versioning and Stability

This bundle follows semantic versioning when possible. Until 1.0, minor releases may contain breaking changes. Pin versions in CI if stability is critical.

## Security

Never expose your development MCP server to the public internet without proper authentication and network controls. Restrict write paths and prefer patch/diff flows.

## License

Licensed under the MIT License. See [LICENSE](./LICENSE).

## Credits

- MCP foundation: `symfony/mcp-bundle` and `symfony/mcp-sdk`
- Author: @rokkay
