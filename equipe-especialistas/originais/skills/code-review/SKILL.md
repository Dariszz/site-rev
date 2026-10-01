---
name: code-review
description: Review Meu Visto Fácil code changes before merge or completion. Use when reviewing a diff, branch, pull request, completed feature, or implementation for correctness, regressions, architecture, maintainability, TypeScript, tests, accessibility, performance, and security. Review first; do not modify code unless explicitly asked to fix findings.
---

# Code Review

Perform a production-quality review of the current changes.

Do not modify code during the initial review.

## Read First

Read:

- `AGENTS.md`

Then read the project documentation relevant to the changed area.

Use when appropriate:

- `docs/ARCHITECTURE.md`
- `docs/SECURITY.md`
- `docs/TESTING.md`
- `docs/AI-ARCHITECTURE.md`
- `docs/DATA-MODEL.md`
- `docs/PRODUCT.md`

Do not review code in isolation from the documented project decisions.

## Establish the Change Set

Inspect the complete set of changes.

For uncommitted work, inspect:

```bash
git status
git diff
git diff --staged

For a branch review against main, use when appropriate:

git diff main...HEAD

Do not review only one changed file if the feature spans multiple files.

Understand the complete change before reporting findings.

Understand Intent

Before identifying issues, determine:

what the change is supposed to accomplish;
the expected user behavior;
the acceptance criteria;
the affected domain;
whether the change follows the current roadmap or Exec Plan.

Do not report a difference from personal preference as a defect.

Review Priorities

Review in this order:

correctness;
security;
regressions;
architecture;
data integrity;
tests;
accessibility;
performance;
maintainability.

Do not bury important defects under cosmetic feedback.

Correctness

Look for:

incorrect business logic;
incorrect state transitions;
edge cases;
missing null handling;
stale data;
unexpected side effects;
broken error handling;
incorrect assumptions;
race conditions;
duplicate operations.

Ask:

Does this implementation actually satisfy the requested behavior?
Product Rules

Check that implementation respects the Meu Visto Fácil product principles.

In particular:

do not guarantee visa eligibility;
do not guarantee approval;
preserve uncertainty where required;
distinguish official information from AI-generated suggestions;
keep official sources traceable.
Architecture

Check whether the change respects:

UI
↓
Application
↓
Domain
↓
Infrastructure

Look for:

business logic inside components;
business logic inside Route Handlers;
business logic inside Server Actions;
Prisma usage spread through UI code;
direct OpenAI SDK usage outside the provider boundary;
duplicated domain logic;
unnecessary global state;
unnecessary abstraction;
god services;
god components.

Do not require abstraction where the simpler implementation is clearer.

Server and Client Boundaries

Verify:

Server Components are used by default where appropriate;
"use client" is not unnecessarily high in the tree;
secrets and server-only dependencies cannot reach the client bundle;
server-side data fetching is not routed through unnecessary internal APIs.
TypeScript

Review for:

any;
unsafe type assertions;
broad as casts;
incorrect nullable types;
invalid states represented as valid;
duplicated type definitions;
external data used without runtime validation.

Do not accept TypeScript suppression merely to make the code compile.

Examples to inspect carefully:

as unknown as SomeType
// @ts-ignore
any

These are not automatically wrong, but they require justification.

Validation

Check all external boundaries.

Examples:

form input;
route params;
query params;
JSON requests;
cookies;
environment variables;
AI output;
external HTTP responses.

Look for request data passed directly into Prisma.

Example of a risk:

prisma.user.update({
  data: body
})

Verify that only allowed fields are persisted.

Authentication

For private operations, verify server-side authentication exists.

Do not consider:

hidden UI;
route navigation;
client state;

sufficient authentication controls.

Look for use of centralized auth helpers such as:

requireUser()

when appropriate.

Authorization and Ownership

Inspect all private resource operations.

Examples:

process read;
process update;
checklist mutation;
process deletion;
AI generation for a process;
profile changes.

Verify ownership is enforced server-side.

Look specifically for IDOR vulnerabilities.

A request containing a valid resource ID must not grant access by itself.

Database

Review:

Prisma queries;
ownership filters;
relationships;
constraints;
unique rules;
indexes where clearly necessary;
migrations;
cascade behavior;
destructive changes;
unbounded queries.

Look for N+1 query patterns.

Review migrations separately when schema changes are involved.

Data Model

Check whether new data is modeled consistently with docs/DATA-MODEL.md.

Avoid:

unnecessary JSON replacing real relationships;
country-specific columns in generic models;
storing easily derived values without reason;
loss of source traceability;
loss of process snapshot history.
AI

For changes involving AI, verify:

Trusted structured data
+
Deterministic rules
↓
AI personalization
↓
Validation

Check that:

AI does not define legal truth;
AI does not invent URLs;
source IDs are validated;
requirement IDs/codes are validated;
outputs use schemas;
business validation occurs after schema validation;
mandatory requirements cannot be removed;
source-controlled data cannot be overwritten;
fallback exists;
OpenAI is called through AIProvider;
tests use FakeAIProvider where appropriate.
AI Failure Behavior

Ask:

What happens if OpenAI fails?

The core application should remain usable where documented.

Report implementations where AI failure causes unnecessary total failure.

Official Sources

Verify:

URLs originate from trusted records;
AI cannot inject arbitrary URLs;
source relationships remain intact;
official information and AI content are distinguishable.
URL Validation / SSRF

If server-side URLs are involved, inspect carefully.

Check:

protocol restrictions;
safe hostname matching;
allowlist behavior;
redirects;
final redirect destination;
timeouts;
response limits;
private/internal IP protections;
arbitrary ports;
localhost;
credentials in URLs.

Look for unsafe checks such as:

hostname.includes("gov.ie")

which could trust malicious domains.

XSS

Inspect content from:

users;
AI;
external sources.

Look for:

dangerouslySetInnerHTML

or unsanitized Markdown/HTML rendering.

Verify untrusted content cannot execute scripts.

Secrets

Search the diff for:

API keys;
tokens;
database credentials;
service-role keys;
real environment values.

Check that server secrets cannot enter client components or public environment variables.

Logging

Check that logs do not expose:

passwords;
tokens;
authorization headers;
API keys;
complete personal profiles;
unnecessary personal data.

Prefer structured logs.

Error Handling

Review:

stable error codes;
safe messages;
expected fallbacks;
missing error states.

Check that users do not receive:

stack traces;
SQL;
filesystem paths;
provider internals;
secrets.
Tests

Determine whether tests provide confidence in the changed behavior.

Look for missing:

domain tests;
negative cases;
ownership tests;
regression tests;
integration tests;
AI fallback tests;
mandatory requirement tests;
URL security tests.

Do not require tests for trivial markup changes without meaningful behavior.

Test Quality

Look for tests that:

assert nothing meaningful;
mock everything;
depend on implementation details;
use brittle selectors;
always pass;
duplicate existing coverage.

Prefer behavioral assertions.

Accessibility

For UI changes, inspect:

semantic HTML;
accessible names;
form labels;
keyboard behavior;
focus management;
button/link semantics;
error messages;
heading hierarchy.

Do not treat accessibility as a cosmetic concern.

Responsive Behavior

Check whether the change reasonably supports:

mobile;
tablet;
desktop.

Report obvious layout assumptions that break core usability.

UI States

Check asynchronous UI for appropriate:

loading;
error;
empty;
success;
disabled states.

Report interfaces that silently fail or appear broken when data is unavailable.

Performance

Only report realistic issues.

Look for:

N+1 database queries;
unbounded findMany;
unnecessary client components;
repeated network requests;
duplicate database queries;
large client-side dependencies;
expensive calculations on every render;
avoidable waterfalls.

Do not invent theoretical performance issues without evidence.

Dependencies

If the change adds a dependency, ask:

was it necessary?
does an existing dependency solve it?
is it actively maintained?
does it introduce unnecessary complexity?
is it used only for something trivial?

Do not recommend removing a dependency merely because another option exists.

Scope

Check for unrelated changes.

Examples:

unrelated dependency upgrades;
mass formatting;
unrelated file renames;
unrelated refactors;
architecture changes not needed by the feature.

Report scope creep when it meaningfully increases risk or review complexity.

Temporary Code

Look for accidental:

console.log
debug code
temporary flags
fake production data
commented-out code
unused imports
temporary TODOs

Only report TODOs when they indicate unfinished required behavior.

Git Hygiene

When appropriate, check whether generated artifacts or secrets were accidentally committed.

Do not focus on commit-message style unless explicitly requested.

Finding Threshold

Only report meaningful findings.

Do not manufacture issues just to return feedback.

A finding should represent one of:

real defect;
likely regression;
security vulnerability;
data integrity issue;
meaningful architectural violation;
important missing test;
significant accessibility issue;
realistic performance problem.
Severity

Classify findings using:

CRITICAL

Likely severe production or security impact.

Examples:

authentication bypass;
major secret exposure;
destructive data loss;
arbitrary server-side request access.
HIGH

Serious defect likely to affect users, security, or data.

Examples:

cross-user resource access;
broken core flow;
official requirements silently removed.
MEDIUM

Meaningful defect or maintainability risk that should be fixed.

Examples:

missing important error handling;
meaningful regression;
incorrect edge case;
missing critical test.
LOW

Minor but legitimate issue.

Use sparingly.

Do not classify style preferences as LOW findings merely to include them.

Finding Format

For each finding provide:

Severity:
Location:
Problem:
Impact:
Recommended direction:

When available, include:

exact file;
relevant line;
relevant function/component.

Explain why the issue matters.

Do not simply say:

This should be refactored.
Findings Order

Return findings ordered:

CRITICAL
HIGH
MEDIUM
LOW

Within the same severity, place highest-impact issues first.

Testing Gaps

After findings, include a short section for important missing test coverage when applicable.

Do not duplicate a test gap already reported as a finding.

Residual Risk

Mention remaining uncertainty only when meaningful.

Examples:

behavior depends on an external provider that was not tested;
migration was reviewed statically but not executed;
browser-specific behavior was not verified.
No Findings

If the implementation has no meaningful issues, say so clearly.

Do not invent problems.

Example:

No meaningful correctness, security, or architecture issues were found in the reviewed diff.

You may still mention tests that were not executed.

Do Not Fix Automatically

The initial review is analysis only.

Do not modify production code unless explicitly asked to fix the findings.

This separation prevents the reviewer from hiding problems by rewriting them during review.

Completion

Return:

findings ordered by severity;
important testing gaps;
residual risks;
concise overall assessment.

Keep the review focused and actionable.