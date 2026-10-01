---
name: feature-development
description: Implement or evolve a Meu Visto Fácil product feature. Use when building a new feature, extending an existing feature, or implementing a roadmap task that changes application behavior. Do not use for pure code review, security-only review, or architecture planning without implementation.
---

# Feature Development

Implement product features incrementally and consistently with the Meu Visto Fácil architecture.

## Start

Before changing code:

1. Read `AGENTS.md`.
2. Read `docs/PRODUCT.md`.
3. Read the relevant sections of:
   - `docs/ARCHITECTURE.md`
   - `docs/DATA-MODEL.md`
   - `docs/SECURITY.md`
   - `docs/TESTING.md`
4. Check `docs/ROADMAP.md` when the task corresponds to a roadmap phase.
5. Inspect the current implementation before assuming file locations or patterns.

Do not start implementation until the relevant execution path is understood.

## Determine Scope

Identify:

- the requested behavior;
- affected domain;
- expected user experience;
- files likely to change;
- relevant tests;
- security implications;
- data model implications.

Keep changes limited to the task.

Do not perform unrelated refactors.

## Planning

For a small and isolated feature, proceed after investigation.

For work involving any of the following, create an Exec Plan under `docs/exec-plans/` before implementation:

- multiple domains;
- database migrations;
- authentication;
- authorization;
- AI architecture;
- major refactors;
- new external integrations;
- production infrastructure.

Use the Exec Plan format defined by `AGENTS.md`.

## Architecture

Prefer:

UI
→ Application
→ Domain
→ Infrastructure

Do not put significant business rules in React components, pages, Route Handlers, or Server Actions.

Prefer Server Components by default.

Use Client Components only where interaction requires browser-side behavior.

Keep client boundaries as low as practical.

## Domain

Business rules should be explicit and testable.

Prefer pure functions where practical.

Examples include:

- visa compatibility evaluation;
- requirement applicability;
- checklist generation;
- progress calculation;
- mandatory requirement protection.

Do not make AI responsible for deterministic domain decisions.

## Persistence

For database changes:

1. inspect the current Prisma schema;
2. determine whether the existing model supports the feature;
3. create a migration if the schema changes;
4. add or update indexes/constraints when relevant;
5. update seed data only when required;
6. add repository or integration tests.

Do not modify production data manually.

## Authentication and Authorization

For private operations:

1. resolve the current user on the server;
2. validate input;
3. verify ownership;
4. execute the operation.

Never trust `userId`, `ownerId`, or equivalent values supplied by the browser.

## AI Features

If the feature uses AI:

1. use the project `AIProvider`;
2. provide only necessary context;
3. use structured output;
4. validate the schema;
5. perform business validation;
6. preserve source-controlled information;
7. preserve mandatory requirements;
8. implement fallback behavior;
9. add tests using `FakeAIProvider`.

Never persist raw model output directly.

## UI

Implement all relevant states:

- loading;
- success;
- empty;
- error;
- disabled.

Ensure:

- responsive behavior;
- semantic HTML;
- keyboard accessibility;
- visible focus;
- proper labels.

Do not use placeholder text as the only accessible label.

## Tests

Add tests proportional to the feature.

Prioritize:

- domain behavior;
- negative paths;
- authorization;
- regressions;
- AI validation;
- security-sensitive boundaries.

Avoid excessive mocking of internal code.

## Verification

Run the relevant checks.

For a significant feature, normally run:

```bash
pnpm lint
pnpm typecheck
pnpm test
pnpm build

Run E2E tests when the feature changes a critical user journey.

Do not claim a command passed unless it was executed.

Self Review

Before finishing:

git diff

Review the entire diff for:

unintended changes;
architecture violations;
missing validation;
missing authorization;
debug code;
secrets;
unused imports;
unrelated formatting;
missing tests.
Completion

Report:

what was implemented;
important design decisions;
files changed;
tests added or changed;
commands executed;
results;
remaining risks or follow-up work.

Stop after the requested feature.

Do not automatically begin the next roadmap phase.