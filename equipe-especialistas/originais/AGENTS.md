# Meu Visto Fácil — Agent Instructions

## 1. Purpose

This repository contains the Meu Visto Fácil application.

Before making changes, agents must understand the relevant product, architecture, security, testing, and roadmap constraints.

Do not treat this repository as a blank playground.

Follow the documented product and architecture decisions unless the current task explicitly requires a reviewed change.

---

# 2. Required Documentation

Read the documents relevant to the task before implementation.

Core documentation:

```text
docs/PRODUCT.md
docs/TECH-STACK.md
docs/ARCHITECTURE.md
docs/DATA-MODEL.md
docs/AI-ARCHITECTURE.md
docs/SECURITY.md
docs/TESTING.md
docs/ROADMAP.md
```

Use:

```text
docs/decisions/
```

for architecture decision records.

Use:

```text
docs/exec-plans/
```

for execution plans for complex work.

---

# 3. Documentation Priority

When instructions conflict, prefer this order:

```text
1. Current user task
2. AGENTS.md
3. Relevant approved ADR
4. ARCHITECTURE.md / SECURITY.md
5. Feature-specific documentation
6. Other project documentation
7. Existing implementation patterns
```

If a conflict is material, do not silently choose one.

Explain the conflict and use the safest interpretation consistent with the task.

---

# 4. Product Principle

Meu Visto Fácil helps users understand immigration paths using structured official information, deterministic rules, and controlled AI personalization.

The product is not a legal authority.

Never implement behavior that guarantees:

```text
visa eligibility
visa approval
legal outcome
```

Prefer language such as:

```text
may be compatible
based on the information provided
still needs confirmation
```

---

# 5. Core Technical Principles

Prefer:

```text
simple
typed
server-first
secure
testable
observable
```

Avoid:

```text
premature abstraction
premature microservices
unnecessary dependencies
unrelated refactors
magic behavior
```

---

# 6. Architecture Direction

The project uses approximately:

```text
UI
 ↓
Application
 ↓
Domain
 ↓
Infrastructure
```

Frontend and backend live inside one Next.js application.

This does not mean business logic should live inside React components or route files.

---

# 7. Framework Rules

Use:

```text
Next.js
React
TypeScript
App Router
```

Prefer Server Components by default.

Use Client Components only when browser interaction requires them.

Do not add:

```text
"use client"
```

at a high level merely for convenience.

Keep the client boundary as low as practical.

---

# 8. TypeScript

TypeScript strict mode is required.

Avoid:

```ts
any
```

unless no reasonable typed alternative exists.

If `any` is necessary:

* keep it local;
* explain why;
* validate external data before use.

Do not suppress TypeScript errors just to make CI pass.

---

# 9. Feature Organization

Prefer code close to its domain.

Example:

```text
src/features/checklists/
src/features/recommendations/
src/features/profile/
```

Do not create generic dumping grounds such as:

```text
helpers.ts
misc.ts
common.ts
utils.ts
```

unless the code is genuinely shared and cohesive.

---

# 10. Business Logic

Business rules should live outside UI components.

Examples:

```text
calculateChecklistProgress()
evaluateVisaCompatibility()
determineApplicableRequirements()
mergeMandatoryRequirements()
```

Prefer pure functions where practical.

---

# 11. Application Services

Complex operations should be coordinated through Application Services.

Examples:

```text
CreateChecklistService
CreateImmigrationProcessService
GenerateRecommendationsService
```

Application Services may coordinate:

```text
authentication
repositories
domain rules
AI providers
external integrations
```

They should not become giant god services.

---

# 12. Database Access

Prisma is infrastructure.

Do not spread complex Prisma queries throughout:

```text
components
hooks
pages
```

Use repositories or focused server-side queries when that improves clarity.

Do not create repository abstractions for trivial cases purely to follow a pattern.

---

# 13. Authentication

Supabase Auth handles identity.

All sensitive operations must resolve the current user server-side.

Use centralized helpers such as:

```ts
getCurrentUser()
requireUser()
```

Never trust a user ID supplied by the browser.

---

# 14. Authorization

Authentication is not authorization.

For private resources, validate ownership server-side.

For example:

```text
process.id = requestedProcessId
AND
process.userProfileId = currentUserProfileId
```

Never assume a resource belongs to a user because the UI exposed its ID.

---

# 15. Input Validation

All external input must be treated as untrusted.

Validate inputs with Zod or the project-approved equivalent before use.

External input includes:

```text
forms
JSON requests
route params
query params
cookies
AI output
external HTTP responses
environment variables
```

Do not pass request objects directly into Prisma.

---

# 16. AI Principle

AI is not the truth layer.

The required flow is:

```text
Official structured data
        +
Deterministic rules
        ↓
Trusted result
        ↓
AI personalization
        ↓
Validation
        ↓
User
```

Never use the AI model as the sole authority for immigration facts.

---

# 17. AI Restrictions

AI must not freely invent:

```text
URLs
fees
official deadlines
legal requirements
visa types
eligibility decisions
```

Official URLs must come from trusted application data.

---

# 18. AI Provider Boundary

Do not import or call the OpenAI SDK directly from arbitrary features.

Use the project AI provider abstraction.

Conceptually:

```text
AIProvider
   ↓
OpenAIProvider
```

Tests should use:

```text
FakeAIProvider
```

---

# 19. Structured AI

Programmatic AI results should use structured outputs and schema validation.

Required flow:

```text
AI Output
 ↓
Schema Validation
 ↓
Business Validation
 ↓
Use
```

Never persist AI output directly without validation.

---

# 20. Mandatory Requirements

AI must never remove mandatory official requirements.

When generating or personalizing checklists:

```text
Base Checklist
 ↓
AI Enhancement
 ↓
Validation
 ↓
Mandatory Merge
 ↓
Final Checklist
```

Mandatory official items always win.

---

# 21. Official Sources

Official sources are trusted application records.

Do not let the AI create source URLs.

Source references generated by AI must map to source IDs already supplied in context.

Unknown source IDs must be rejected.

---

# 22. URL Validation

Server-side URL validation is security-sensitive.

Do not make arbitrary server requests to URLs supplied by users.

Official link validation must follow the project security rules, including:

```text
approved hostname
approved protocol
redirect validation
timeout
SSRF protection
response limits
```

Read:

```text
docs/SECURITY.md
```

before changing this behavior.

---

# 23. Security-Sensitive Areas

Changes involving any of the following require explicit security review:

```text
authentication
authorization
ownership
URLs
external HTTP requests
AI endpoints
secrets
account deletion
database permissions
```

Do not weaken a security rule merely to make implementation easier.

---

# 24. Secrets

Never:

```text
commit secrets
hardcode API keys
log secrets
send server secrets to the browser
place real credentials in docs
```

Use environment variables.

Keep `.env.example` free of real values.

---

# 25. Logging

Use structured logging for important server operations.

Do not log unnecessary personal information.

Never log:

```text
passwords
session tokens
authorization headers
API keys
database credentials
```

---

# 26. Error Handling

Use stable application/domain errors where appropriate.

Prefer explicit codes such as:

```text
AUTH_REQUIRED
ACCESS_DENIED
PROCESS_NOT_FOUND
AI_OUTPUT_INVALID
RATE_LIMIT_EXCEEDED
```

Do not expose stack traces or infrastructure details to users.

---

# 27. Tests

Read:

```text
docs/TESTING.md
```

for full testing strategy.

Every implementation should test the behavior that carries meaningful risk.

Do not chase meaningless coverage percentages.

---

# 28. Testing Expectations

Examples:

## Domain change

Run/add domain tests.

## UI behavior

Run/add component tests.

## Database change

Run migration/repository/integration checks.

## Authorization change

Add negative ownership tests.

## AI feature

Add:

```text
schema validation tests
business validation tests
fallback tests
```

## URL validation

Add SSRF/security cases.

---

# 29. Bug Fix Rule

For a meaningful bug:

1. reproduce it;
2. add a regression test when practical;
3. implement the smallest correct fix;
4. rerun relevant tests.

Do not perform unrelated cleanup unless needed for the fix.

---

# 30. Verification

Before completing a significant task, run relevant checks.

Common full verification:

```bash
pnpm lint
pnpm typecheck
pnpm test
pnpm build
```

When relevant:

```bash
pnpm test:e2e
```

Do not claim checks passed if they were not executed.

---

# 31. Completion Report

When finishing implementation, report:

```text
what changed
files changed
tests added/updated
commands executed
results
known risks
anything not tested
```

Keep the report factual.

---

# 32. Build Failures

Never hide or bypass failures by:

```text
disabling tests
removing lint rules
adding broad ts-ignore
skipping validation
```

unless the task explicitly requires a justified configuration change.

Fix the underlying issue.

---

# 33. Scope Discipline

Only modify what is necessary for the requested task.

Do not:

```text
upgrade unrelated dependencies
rename unrelated files
reformat the whole repository
refactor unrelated modules
change architecture without reason
```

Large unrelated diffs reduce review quality.

---

# 34. Investigate Before Editing

Before changing unfamiliar code:

1. inspect relevant files;
2. trace the data flow;
3. identify existing conventions;
4. locate related tests;
5. understand the change boundary.

Do not guess the repository structure.

---

# 35. Complex Task Planning

A task should receive an Exec Plan when it involves:

```text
multiple domains
database migrations
authentication changes
architecture changes
AI architecture changes
complex refactors
production deployment
```

Create it under:

```text
docs/exec-plans/
```

---

# 36. Exec Plan Format

Use:

```text
Goal
Current State
Scope
Non-goals
Implementation Steps
Files Expected to Change
Data Changes
Security Considerations
Testing
Risks
Definition of Done
```

---

# 37. Plan Before Implementation

For complex tasks:

```text
Investigate
 ↓
Plan
 ↓
Implement
 ↓
Test
 ↓
Review Diff
 ↓
Report
```

Do not start coding immediately when the system impact is unclear.

---

# 38. Small Tasks

Small, well-scoped tasks do not need unnecessary planning documents.

Examples:

```text
fix copy
adjust spacing
add a simple component test
```

Use judgment.

---

# 39. Architecture Changes

Do not silently diverge from:

```text
docs/ARCHITECTURE.md
```

If the current architecture cannot support the task:

1. identify the problem;
2. propose the smallest viable change;
3. explain consequences;
4. create ADR when meaningful;
5. update documentation;
6. then implement.

---

# 40. ADRs

Use:

```text
docs/decisions/
```

for important decisions.

Typical examples:

```text
change auth provider
introduce queue
split backend service
adopt global state library
introduce RAG/vector database
```

Do not create ADRs for trivial changes.

---

# 41. Roadmap

Follow:

```text
docs/ROADMAP.md
```

unless the current user task explicitly changes priorities.

Do not automatically begin the next roadmap phase after finishing the requested one.

Stop at the requested boundary.

---

# 42. MVP Discipline

Do not block the MVP with features outside current scope.

Examples outside the initial MVP unless explicitly requested:

```text
payments
premium subscription
native mobile app
full admin panel
open chatbot
document uploads
RAG/vector database
notifications platform
microservices
```

---

# 43. Dependencies

Before adding a package, ask:

```text
Does an existing dependency already solve this?

Can the platform solve this cleanly?

Is this dependency maintained?

Does it add meaningful complexity?
```

Do not install libraries for trivial helpers.

---

# 44. Package Manager

Use:

```text
pnpm
```

Do not introduce npm/yarn lockfiles.

Keep:

```text
pnpm-lock.yaml
```

authoritative.

---

# 45. Node Version

Respect the repository-defined Node version.

Do not silently change Node versions during unrelated tasks.

---

# 46. Database Migrations

Database schema changes require migrations.

Do not make undocumented manual production schema changes.

Review destructive changes carefully.

---

# 47. Seed Data

Seed data must be:

```text
reviewed
repeatable
safe
free of secrets
```

Do not invent production immigration facts.

Data displayed publicly must eventually be reviewed against official sources.

---

# 48. Immigration Content

Do not invent official immigration requirements during implementation.

If the task requires real-world immigration facts not already in reviewed project data:

* identify that research is required;
* use authoritative official sources;
* clearly distinguish verified data from placeholder development content.

Never silently fabricate production seed data.

---

# 49. UI

The product should look like a real application, not a generic scaffold.

Maintain consistency in:

```text
spacing
typography
components
states
responsive behavior
accessibility
```

Do not create one-off styling patterns unnecessarily.

---

# 50. Accessibility

Accessibility is part of implementation.

Prefer:

```text
semantic HTML
real buttons
real labels
keyboard support
visible focus
accessible names
```

Use ARIA only when needed.

---

# 51. Forms

Forms should include:

```text
labels
validation messages
loading state
disabled state
error state
success feedback
```

Do not rely solely on placeholder text as labels.

---

# 52. Responsive Design

New interfaces must work on:

```text
mobile
tablet
desktop
```

Do not build desktop-only features and defer responsive behavior indefinitely.

---

# 53. Loading, Error and Empty States

Asynchronous interfaces must consider:

```text
loading
error
empty
success
```

Do not assume requests always succeed.

---

# 54. Performance

Do not prematurely optimize.

But avoid obvious problems such as:

```text
unnecessary client components
unbounded queries
large client bundles
N+1 queries
duplicate requests
```

Measure before introducing complex caching.

---

# 55. Server Data Fetching

For server-side code, prefer calling application/services directly.

Avoid unnecessary internal HTTP loops such as:

```text
Server Component
 ↓
internal API
 ↓
same server
 ↓
database
```

when the service can be called directly.

---

# 56. Server Actions

Server Actions should act as boundaries.

They should generally:

```text
authenticate
validate
authorize
call application service
map result
```

Do not put hundreds of lines of domain logic inside actions.

---

# 57. Route Handlers

Use Route Handlers when an actual HTTP boundary is useful.

Examples:

```text
webhooks
external API access
streaming
callbacks
```

Do not create internal APIs only because they resemble traditional backend architecture.

---

# 58. Client State

Prefer:

```text
server data → server components
form data → React Hook Form
URL state → search params
local state → React
```

Do not add a global state library unless there is a concrete need.

---

# 59. TanStack Query

Use TanStack Query where client-side server synchronization actually benefits from:

```text
optimistic updates
polling
complex mutations
client caching
```

Do not automatically use it for every read request.

---

# 60. Multi-Agent Work

Parallel agents are useful only for independent work.

Good:

```text
Agent A → landing page
Agent B → documentation
Agent C → independent tests
```

Bad:

```text
Agent A → modify profile schema
Agent B → modify same profile schema
```

Avoid parallel changes to the same architectural surface unless coordinated.

---

# 61. Planning Agent

For large changes, a planning/research agent should:

```text
inspect
trace
identify risks
propose files
propose tests
```

and avoid modifying code unless explicitly asked.

---

# 62. Implementation Agent

An implementation agent should:

```text
follow the approved plan
keep scope focused
add tests
run verification
```

Do not reinterpret the product unless blocked.

---

# 63. Review Agent

A review agent should initially avoid modifying code.

Review the diff for:

```text
correctness
regressions
architecture
TypeScript
security
performance
accessibility
tests
```

Only report real findings.

Classify severity when useful.

---

# 64. Security Review Agent

For sensitive changes, review specifically for:

```text
authentication
authorization
IDOR
SSRF
XSS
CSRF
secret exposure
input validation
rate limiting
data leaks
AI abuse
```

---

# 65. Test Agent

A test-focused agent should identify gaps without rewriting the feature unnecessarily.

Prefer meaningful behavioral coverage over excessive mocking.

---

# 66. Documentation Agent

Documentation should reflect real code.

Do not update documentation to describe behavior that has not been implemented.

Do not leave architecture docs stale after significant approved changes.

---

# 67. Self Review

Before considering work complete:

```bash
git diff
```

Review the complete diff.

Look for:

```text
accidental changes
debug code
unused imports
temporary comments
secrets
unrelated formatting
missing tests
```

---

# 68. Temporary Code

Remove before completion:

```text
console.log debugging
TODOs created only as reminders
temporary feature switches
fake production data
commented-out old implementations
```

Unless intentionally documented.

---

# 69. Comments

Comments should explain:

```text
why
constraint
non-obvious reasoning
```

not repeat:

```text
what the next line does
```

---

# 70. Naming

Use explicit domain names.

Prefer:

```text
evaluateVisaCompatibility
officialSource
immigrationProcess
```

over:

```text
processData
handleThing
doStuff
```

---

# 71. Functions

Prefer small cohesive functions.

Do not enforce arbitrary line limits if splitting harms clarity.

Large functions should trigger responsibility review.

---

# 72. Components

Avoid components carrying:

```text
data fetching
business rules
mutation logic
formatting
analytics
large rendering tree
```

all at once.

Split by responsibility when useful.

---

# 73. Reuse

Do not abstract after the first occurrence just because two pieces look similar.

Prefer real patterns over speculative reuse.

---

# 74. Testing External Services

Normal tests must not depend on real:

```text
OpenAI
government websites
production Supabase
production PostgreSQL
```

Use controlled test boundaries.

---

# 75. CI

Do not add CI steps that require production secrets for routine tests.

CI should be reproducible.

---

# 76. Git

Keep commits understandable.

Prefer focused commits.

Do not force-push shared branches without explicit instruction.

Do not alter Git history unless requested.

---

# 77. Main Branch

Treat:

```text
main
```

as deployable.

Do not knowingly leave `main` broken.

---

# 78. Production

Never perform destructive production operations unless explicitly requested and understood.

Changes to production data, migrations, secrets, or authentication must be handled conservatively.

---

# 79. Deployment

Before production deploy, ensure relevant:

```text
lint
typecheck
tests
build
security checks
```

have passed.

Follow deployment documentation and roadmap.

---

# 80. Definition of Done

A significant task is complete when:

```text
scope implemented
        ↓
architecture respected
        ↓
input validation considered
        ↓
authorization considered
        ↓
tests added where needed
        ↓
relevant tests passing
        ↓
typecheck passing
        ↓
build passing when relevant
        ↓
diff reviewed
        ↓
docs updated if needed
```

---

# 81. Completion Behavior

Do not automatically continue into adjacent tasks.

After completing the requested scope:

1. summarize;
2. report validation;
3. report remaining risks;
4. stop.

---

# 82. If Something Is Unclear

Investigate existing documentation and code first.

Do not guess when the answer can be discovered from the repository.

If a product decision is genuinely undefined and blocks safe implementation, identify it clearly rather than silently inventing permanent behavior.

---

# 83. Final Principle

The goal is not to generate the largest amount of code.

The goal is to build Meu Visto Fácil as a:

```text
reliable
secure
well-structured
testable
maintainable
portfolio-quality
```

product.

Agents should optimize for correct, reviewable progress rather than maximum code output.

## Context and Token Efficiency

Use repository context deliberately.

Do not read every documentation file for every task.

Start with:
- `AGENTS.md`;
- the user's task;
- the files directly related to the requested change.

Then read only the documentation needed for the affected area.

Examples:

UI work:
- `docs/PRODUCT.md`
- relevant parts of `docs/ARCHITECTURE.md`

Database work:
- `docs/DATA-MODEL.md`
- relevant parts of `docs/ARCHITECTURE.md`

AI work:
- `docs/AI-ARCHITECTURE.md`
- relevant parts of `docs/SECURITY.md`

Authentication/security work:
- `docs/SECURITY.md`
- relevant parts of `docs/ARCHITECTURE.md`

Testing work:
- `docs/TESTING.md`
- documentation for the affected feature

Do not repeatedly reread unchanged files during the same task unless necessary.

Prefer targeted repository inspection over broad repository scans.

Do not inspect unrelated directories.

Do not run full test suites when a smaller relevant test provides sufficient feedback during development.

Run broader verification only at the appropriate workflow gate.

Avoid verbose progress reports.

Keep intermediate notes concise.

Reuse information already discovered during the current task instead of rediscovering it.

Stop when the requested scope is complete.
