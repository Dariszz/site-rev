---
name: feature-workflow
description: Orchestrate the complete development workflow for a Meu Visto Fácil feature from planning through implementation, testing, review, security review when needed, and final verification. Use for medium or large product features where a complete engineering workflow is desired.
---

# Feature Workflow

Orchestrate the complete engineering workflow for a Meu Visto Fácil feature.

This workflow coordinates:

1. architecture planning;
2. implementation;
3. testing;
4. code review;
5. remediation;
6. security review when required;
7. final verification.

Do not skip phases merely to finish faster.

The goal is to deliver a feature that is implemented, tested, reviewed, and ready for the user to inspect.

---

# 1. Read Project Instructions

Before doing anything, read:

- `AGENTS.md`
- `docs/PRODUCT.md`
- `docs/ROADMAP.md`

Then read all documentation relevant to the requested feature.

Common references include:

- `docs/TECH-STACK.md`
- `docs/ARCHITECTURE.md`
- `docs/DATA-MODEL.md`
- `docs/AI-ARCHITECTURE.md`
- `docs/SECURITY.md`
- `docs/TESTING.md`

Also inspect:

```text
docs/decisions/
docs/exec-plans/

when relevant.

Do not assume the current implementation matches the documentation without inspecting the repository.

2. Understand the Requested Feature

Identify:

the user goal;
expected product behavior;
affected domain;
current implementation;
dependencies;
likely files affected;
security implications;
database implications;
AI implications;
required tests.

Clearly define the scope.

Also define what is explicitly outside the scope.

Do not silently expand the task.

3. Determine Workflow Complexity

Classify the task as:

SMALL
MEDIUM
LARGE
SECURITY_SENSITIVE
SMALL

Examples:

copy change;
minor UI adjustment;
simple isolated component.

A small task may not require the full workflow.

When this skill was explicitly requested, still perform at least:

investigate
→ implement
→ test relevant behavior
→ self-review
MEDIUM

Examples:

new UI feature;
new application service;
new questionnaire behavior;
new public page backed by existing data.

Use:

planning
→ implementation
→ testing
→ code review
→ final verification
LARGE

Examples:

authentication;
recommendation engine;
checklist engine;
new persistence workflow;
large database changes;
major AI integration.

Use the complete workflow.

SECURITY_SENSITIVE

Automatically classify as security-sensitive if the feature involves:

authentication;
authorization;
ownership;
account deletion;
private user data;
database permissions;
server-side URL fetching;
SSRF;
secrets;
AI endpoints;
rate limiting;
external integrations with privileged behavior.

Security-sensitive tasks require a security review phase.

4. Phase 1 — Architecture Planning

Adopt the architecture-planning role.

Do not implement production code yet.

Investigate:

existing architecture;
current data flow;
relevant domain logic;
persistence;
authentication and authorization;
tests;
external integrations.

Determine the smallest correct solution.

Do not introduce unnecessary:

microservices;
queues;
event buses;
global state libraries;
databases;
providers;
abstraction layers.

For MEDIUM or LARGE work, create an Exec Plan when useful.

For LARGE or SECURITY_SENSITIVE work, an Exec Plan is required.

Create:

docs/exec-plans/<feature-name>.md

Use:

# Goal

# Current State

# Scope

# Non-goals

# Proposed Architecture

# Implementation Steps

# Files Expected to Change

# Data Changes

# Security Considerations

# Testing

# Risks

# Definition of Done
5. Architecture Gate

Before implementation, evaluate the plan.

Continue automatically only when:

the requested behavior is clear;
the implementation does not require an unresolved product decision;
the architecture is compatible with project rules;
no destructive operation requires user approval;
no major architecture decision is unresolved.

STOP and ask the user when:

two materially different product behaviors are possible;
an architectural decision would significantly change the project;
destructive production behavior is required;
an important requirement cannot be inferred safely;
existing documentation materially conflicts with the user request.

Do not stop for minor implementation decisions that can be resolved safely from the repository.

6. Phase 2 — Feature Development

After the architecture gate passes, adopt the feature-development role.

Implement the approved plan.

Follow:

UI
↓
Application
↓
Domain
↓
Infrastructure

Keep the implementation focused.

Do not perform unrelated refactors.

7. Implementation Rules

During implementation:

prefer Server Components where appropriate;
keep client boundaries small;
keep business logic outside UI;
validate external input;
authorize private operations server-side;
derive ownership from the authenticated user;
use migrations for schema changes;
preserve existing architectural boundaries;
keep integrations encapsulated.

Do not bypass project rules to make implementation easier.

8. Database Changes

When the feature changes persistence:

inspect the current Prisma schema;
update the model;
create a migration;
review constraints;
review indexes;
consider existing data;
update seed only when necessary;
add appropriate tests.

Avoid destructive changes when a safer migration path exists.

9. AI Changes

When the feature involves AI:

Use the project AI abstraction.

Required flow:

trusted application context
        ↓
AIProvider
        ↓
structured output
        ↓
schema validation
        ↓
business validation
        ↓
application

Never persist raw AI output directly.

Never allow AI to freely define:

official requirements;
legal eligibility;
fees;
deadlines;
source URLs.

Preserve mandatory and source-controlled information.

Implement fallback behavior.

10. Phase 3 — Testing

After implementation, adopt the testing role.

Read:

docs/TESTING.md

Inspect:

production changes;
tests already added;
critical behavior;
negative paths;
regressions.

Add or improve meaningful tests.

Do not rewrite correct production code merely to simplify tests.

11. Testing Priorities

Prioritize tests for:

domain rules;
application services;
authorization;
ownership;
validation;
checklist rules;
recommendation rules;
AI business validation;
failure behavior.

Use:

FakeAIProvider

instead of real OpenAI for routine tests.

Use test databases rather than production databases.

12. Security Test Detection

If the feature touches private or sensitive behavior, ensure negative tests exist.

Examples:

unauthenticated user
user accessing another user's resource
invalid ownership
malicious input
mass assignment
invalid AI source
malicious URL
13. Initial Verification

During implementation, prefer targeted verification instead of running the full project verification suite after every change.

Run the smallest useful checks for the affected area.

Examples:

Domain change:

```bash
pnpm test <relevant-test-file-or-pattern>

UI change:

pnpm test <relevant-component-tests>
pnpm typecheck

Database change:

pnpm test <relevant-repository-or-integration-tests>

AI change:

pnpm test <relevant-ai-tests>

Security-sensitive change:

run the relevant negative/security tests for the affected behavior.

Use broader checks only when they provide useful feedback at that stage.

Do not repeatedly run the full test suite, production build, or E2E suite after every small implementation adjustment.

The purpose of this phase is fast feedback while development is still changing.

14. Verification Gate

If a targeted test, lint check, typecheck, or other relevant verification fails:

DO NOT continue as though implementation were complete.

Investigate the failure.

Classify it as:

- implementation defect;
- test defect;
- environment/configuration issue;
- unrelated pre-existing failure.

Fix failures caused by the current work.

Then rerun the smallest relevant verification first.

Do not immediately run the entire project verification suite after every remediation.

If the failure cannot safely be resolved within scope, stop and report it.

15. Phase 4 — Independent Code Review

After verification passes, change perspective and adopt the code-review role.

Start with the smallest relevant review context.

Inspect first:

```bash
git status
git diff
git diff --staged

When reviewing committed branch work against main, use when appropriate:

git diff main...HEAD

Focus first on:

files changed by the current feature;
directly affected tests;
directly affected domain boundaries.

Do not scan the entire repository unless the diff reveals a dependency or architectural concern that requires broader investigation.

Expand the review context only when necessary to understand:

a called service;
a shared domain rule;
an authorization boundary;
a database relationship;
an AI integration;
a security-sensitive dependency.

Do not reread unchanged documentation unless the changed code depends on a rule that must be verified.

Review for:

correctness;
regressions;
architecture;
TypeScript;
validation;
authorization;
database integrity;
AI behavior;
tests;
accessibility;
performance;
scope creep.

Do not assume the implementation is correct merely because earlier phases produced it.
16. Review Findings

Classify findings:

CRITICAL
HIGH
MEDIUM
LOW

Only report real findings.

Do not invent issues.

17. Review Remediation Gate

If code review finds:

CRITICAL
HIGH

findings:

return to implementation mode;
fix the root cause;
update tests;
rerun verification;
perform code review again.

Do not mark the workflow complete while CRITICAL or HIGH findings remain.

MEDIUM findings should normally be fixed when they affect correctness, maintainability, accessibility, or regression risk.

LOW findings may remain if they are nonessential and clearly reported.

18. Security Review Decision

Determine whether a dedicated security review is required.

Security review is REQUIRED when the feature involves:

authentication
authorization
ownership
private user data
account deletion
AI endpoints
server-side URL fetching
SSRF
secrets
database permissions
rate limiting
privileged external integrations

It is also required when:

the user explicitly asks for it;
code review identifies a meaningful security concern;
the feature is preparing for production deployment.

For ordinary low-risk UI features, it may be skipped.

Record whether it was:

REQUIRED
NOT_REQUIRED

and why.

19. Phase 5 — Security Review

When required, adopt the security-review role.

Start by reviewing the security-sensitive portion of the current feature diff.

Inspect first:

- changed files;
- authentication and authorization boundaries touched by the feature;
- user-controlled inputs introduced or changed;
- database mutations introduced or changed;
- external requests introduced or changed;
- AI endpoints or AI data flows introduced or changed.

Do not perform a full repository-wide security audit unless the feature requires it.

Expand to unchanged files only when necessary to verify:

- ownership enforcement;
- shared authentication helpers;
- shared authorization helpers;
- URL validation utilities;
- AI provider boundaries;
- rate limiting;
- database access patterns;
- secret handling.

Read only the relevant sections of `docs/SECURITY.md` and other documentation needed for the affected area.

Focus on:

- authentication;
- authorization;
- ownership;
- IDOR;
- input validation;
- mass assignment;
- SQL/query safety;
- SSRF;
- XSS;
- CSRF;
- secrets;
- sensitive logging;
- AI abuse;
- rate limiting;
- data leakage;
- error disclosure.

Do not assume the earlier code review covered security sufficiently.

20. Security Findings Gate

If the security review identifies:

CRITICAL
HIGH

findings:

return to implementation mode;
remediate the root cause;
add regression/security tests;
rerun relevant verification;
repeat the security review.

The workflow cannot finish while CRITICAL or HIGH security findings remain.

MEDIUM findings should normally be resolved before completion when practical.

21. Avoid Infinite Loops

Do not repeatedly rewrite the same implementation without progress.

If the same issue survives two remediation attempts:

STOP.

Report:

the unresolved finding;
what was attempted;
why it remains unresolved;
recommended next decision.

Do not endlessly loop.

22. Phase 6 — Final Verification

After implementation, testing, code review, remediation, and security review when required, run the complete verification appropriate to the feature.

For significant changes, run:

```bash
pnpm lint
pnpm typecheck
pnpm test
pnpm build

When the feature affects a critical user journey, also run:

pnpm test:e2e

This is the main full verification gate.

Avoid running this complete suite repeatedly during normal implementation unless there is a concrete reason.

If final verification fails:

identify the failing area;
fix the root cause;
rerun the affected check;
once fixed, rerun the complete final verification before completion.

Do not report the feature as READY unless all required final verification checks pass.

23. Final Diff Review

Inspect the final diff.

Check for:

debug code;
console logs;
secrets;
temporary files;
unrelated changes;
unused imports;
stale comments;
accidental formatting;
skipped tests introduced during development;
undocumented architecture changes.
24. Documentation

Update documentation only when implementation changed behavior or architecture that the docs describe.

Possible updates:

docs/ARCHITECTURE.md
docs/DATA-MODEL.md
docs/AI-ARCHITECTURE.md
docs/SECURITY.md
docs/TESTING.md
docs/ROADMAP.md

Create an ADR only for meaningful architecture decisions.

Documentation must describe actual implemented behavior.

25. Do Not Automatically Continue the Roadmap

After completing the requested feature:

STOP.

Do not begin the next ROADMAP phase automatically.

The workflow applies only to the requested scope.

26. Final Status

Classify the final result as one of:

READY
READY_WITH_MINOR_FINDINGS
BLOCKED
READY

All required implementation and verification completed.

No unresolved CRITICAL or HIGH findings.

READY_WITH_MINOR_FINDINGS

Feature is functional and safe enough for review, but legitimate non-blocking findings remain.

Clearly list them.

BLOCKED

A significant unresolved issue prevents safe completion.

Explain exactly what is blocking progress.

27. Final Report

Return a concise engineering report containing:

Feature

What was implemented.

Planning

Exec Plan created and major decisions.

Implementation

Important files and architecture changes.

Testing

Tests added or modified.

Commands executed and results.

Code Review

Findings discovered and remediated.

Remaining findings, if any.

Security Review

Whether it was required.

Findings and remediation.

Final Verification

Final commands and results.

Status
READY
READY_WITH_MINOR_FINDINGS
or
BLOCKED
Follow-up

Only list genuinely useful follow-up work.

28. Core Workflow

The default workflow is:

Understand Feature
        ↓
Architecture Planning
        ↓
Architecture Gate
        ↓
Feature Development
        ↓
Testing
        ↓
Verification
        ↓
Code Review
        ↓
Findings?
   ┌────┴────┐
  yes        no
   ↓          ↓
Remediate   Security Review Needed?
   ↓            ┌────┴────┐
Re-test        yes         no
   ↓            ↓           ↓
Re-review   Security       Final
               Review     Verification
                  ↓
             Findings?
             ┌────┴────┐
            yes        no
             ↓          ↓
         Remediate     Final
             ↓       Verification
          Re-test
             ↓
       Security Review
             ↓
            Final
         Verification
29. Principle

This workflow exists to reduce supervision overhead without reducing engineering quality.

Automate routine engineering decisions.

Do not automate important unresolved product decisions.

The goal is:

plan
→ implement
→ prove
→ review
→ secure
→ verify

before presenting the feature as complete.