---
name: testing
description: Design, add, improve, or run tests for Meu Visto Fácil. Use when validating a feature, adding regression coverage, investigating missing tests, testing domain rules, authorization, AI behavior, or critical user flows. Focus on meaningful behavioral confidence rather than arbitrary coverage percentages.
---

# Testing

Improve confidence in Meu Visto Fácil through focused, meaningful tests.

## Read First

Read:

- `AGENTS.md`
- `docs/TESTING.md`

Also read when relevant:

- `docs/SECURITY.md`
- `docs/AI-ARCHITECTURE.md`
- `docs/ARCHITECTURE.md`

Do not write tests before understanding the behavior that actually needs protection.

## Inspect Before Writing Tests

Identify:

- the behavior being tested;
- current tests;
- domain boundaries;
- likely failure paths;
- security implications;
- regression risks.

Do not duplicate tests that already provide the same confidence.

## Choose the Correct Test Level

Prefer the lowest test level that provides meaningful confidence.

### Unit / Domain

Use for:

- pure business rules;
- transformations;
- visa compatibility evaluation;
- requirement conditions;
- checklist merging;
- progress calculation;
- formatting rules with business relevance.

Examples:

```text
evaluateVisaCompatibility()
determineApplicableRequirements()
mergeMandatoryRequirements()
calculateChecklistProgress()

These tests should be fast and independent from network, database, and external providers.

Application

Use for Application Services and orchestration.

Examples:

CreateChecklistService
CreateImmigrationProcessService
GenerateRecommendationsService

Prefer controlled dependencies such as:

InMemoryRepository
FakeAIProvider

Test coordination between:

repositories;
domain rules;
validation;
AI boundaries;
persistence decisions.
Integration

Use when testing real infrastructure behavior.

Examples:

Prisma repositories;
PostgreSQL constraints;
migrations;
Route Handler boundaries;
database relationships.

Use a dedicated test database.

Never use production.

Component

Use React Testing Library for interactive UI behavior.

Prefer accessible queries:

getByRole
getByLabelText
getByText

Test behavior from the user's perspective.

Avoid testing private implementation details.

End-to-End

Use Playwright for critical journeys.

Examples:

Landing
→ Ireland
→ Visa details

and:

Login
→ Questionnaire
→ Recommendation
→ Start Process
→ Checklist

Do not use E2E for every small behavior.

Domain Testing Priorities

The most important domain areas include:

recommendation rules;
compatibility levels;
conditional requirements;
mandatory requirement preservation;
checklist progress;
normalization of profile answers.

Test:

positive cases;
negative cases;
missing information;
edge cases;
invalid states.
Recommendation Engine

Tests should clearly express why a result exists.

Example:

Given:
objective = WORK
hasEmploymentOffer = true

When:
evaluateCriticalSkills(profile)

Then:
the expected compatibility result is returned

Do not merely test that the function returned an object.

Validate the actual rule.

Checklist Rules

Checklist tests must verify:

mandatory items remain;
applicable conditional requirements are included;
non-applicable conditional requirements are excluded;
optional items remain optional;
progress calculation is correct.

Critical invariant:

AI must never remove mandatory official requirements.
AI Tests

Routine tests must not depend on the real OpenAI API.

Use:

FakeAIProvider

Test scenarios such as:

valid structured response;
malformed response;
schema-valid but business-invalid response;
unknown source ID;
unknown requirement code;
timeout;
provider failure;
fallback behavior;
mandatory requirement preservation.

Example:

Base checklist:
A
B
C

B is mandatory.

AI returns:
A
C

Final checklist must still contain:
A
B
C
AI Output Validation

Test both levels:

Schema Validation
↓
Business Validation

A response can be valid according to Zod but invalid according to domain rules.

Example:

{
  "sourceIds": ["unknown-source"]
}

This may satisfy the schema but must fail business validation.

Security Tests

Prioritize negative scenarios.

Test:

unauthenticated access;
unauthorized access;
ownership isolation;
IDOR;
malicious URLs;
invalid redirects;
excessive payloads;
invalid AI references;
mass assignment.
Ownership

Critical scenario:

User A owns Process A.

User B attempts to access Process A.

Expected:
access denied or not found.

Test this behavior for relevant:

reads;
updates;
deletes;
checklist mutations;
AI operations.
URL Validation Tests

Cover safe and unsafe cases.

Valid example:

https://approved-official-host/path

Invalid examples:

http://localhost
https://127.0.0.1
https://10.0.0.1
file:///etc/passwd
javascript:alert(1)
https://official-host.attacker.com

Also test:

redirect to trusted host;
redirect to untrusted host;
too many redirects;
timeout;
URLs with credentials;
unsupported protocols.
XSS

Content originating from:

user input;
AI;
external content;

must not execute arbitrary HTML or JavaScript.

Test malicious strings when relevant.

Example:

<script>alert("xss")</script>
Regression Bugs

For meaningful bugs:

reproduce the failure;
add a regression test when practical;
implement the fix;
verify the regression test passes.

Do not fix a bug without understanding why it occurred.

Avoid Fragile Tests

Do not over-test:

CSS class names;
private state;
implementation-specific hook calls;
exact function call counts without reason;
giant snapshots;
exact AI prose.

Prefer observable behavior and invariants.

Test Factories

Use factories for complex data.

Examples:

makeUserProfile()
makeVisa()
makeRequirement()
makeProcess()
makeChecklist()

Factories should provide valid defaults and allow focused overrides.

Example:

makeUserProfile({
  hasEmploymentOffer: false
})
Test Data

Use fictitious data only.

Never use real production user information.

Tests should be deterministic.

Avoid unnecessary randomness.

Network Rules

Unit tests must not rely on external network access.

Routine tests should not contact:

OpenAI;
government websites;
production Supabase;
production PostgreSQL.

Use mocks, fakes, or controlled test services.

Database Tests

When testing Prisma:

prefer a real test database over deeply mocking Prisma internals.

Verify:

constraints;
relations;
uniqueness;
repository behavior;
migration behavior where relevant.
Component Testing

Test things such as:

form validation;
submit behavior;
loading state;
disabled state;
error state;
empty state;
success feedback;
accessibility.

Prefer user-facing behavior over implementation details.

Accessibility

Testing should help reinforce accessibility.

Prefer queries based on:

roles;
labels;
accessible names.

Ensure important controls can be identified semantically.

E2E Critical Flows

Priority flows:

Visitor
Landing
→ Ireland
→ Visa
→ Official Source
Authenticated User
Login
→ Questionnaire
→ Recommendation
→ Process
→ Checklist
Persistence
Complete checklist item
→ reload
→ state remains saved
Fake External Services

E2E should not normally depend on real OpenAI or real government sites.

Use controlled responses where practical.

Coverage

Coverage is a supporting metric.

Do not optimize for an arbitrary percentage.

Prioritize confidence in:

domain rules;
authorization;
checklist merge;
AI validation;
official source validation.
Test Naming

Use names that communicate behavior.

Good:

returns high compatibility when the required employment criteria are satisfied

Bad:

test1
works
should work
Test Independence

Tests must not depend on execution order.

Each test should create or prepare its own required state.

Time

For date-sensitive logic, use a controlled clock when necessary.

Do not make tests depend on the current real-world date if that makes them unstable.

Run Tests

Run the smallest useful set during development.

Common commands:

pnpm test
pnpm lint
pnpm typecheck

When relevant:

pnpm build
pnpm test:e2e

Do not claim a command passed unless it was actually executed.

Investigate Failures

When a test fails, determine whether the issue is in:

production code;
test expectation;
test setup;
environment;
async behavior;
mocking.

Do not change correct production behavior merely to satisfy an incorrect test.

Self Review

Before finishing, review the test diff.

Look for:

meaningless assertions;
tests that always pass;
excessive mocks;
duplicated coverage;
missing negative cases;
brittle selectors;
accidental production changes.
Completion

Report:

tests added;
tests changed;
scenarios covered;
commands executed;
results;
remaining important coverage gaps.

Do not claim unexecuted tests passed.