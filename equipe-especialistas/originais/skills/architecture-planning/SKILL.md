name: architecture-planning
description: Investigate and plan a complex Meu Visto Fácil technical change before implementation. Use for architecture decisions, complex features, refactors, database changes, authentication changes, AI architecture changes, or work spanning multiple domains. This skill plans and documents; it should not implement the feature unless explicitly requested afterward.
---

# Architecture Planning

Investigate a technical change and produce a reviewable implementation plan.

Do not modify production code while performing the planning phase unless explicitly requested.

## Read First

Read:

- `AGENTS.md`
- `docs/PRODUCT.md`
- `docs/TECH-STACK.md`
- `docs/ARCHITECTURE.md`

Then read the documents relevant to the task:

- `docs/DATA-MODEL.md`
- `docs/AI-ARCHITECTURE.md`
- `docs/SECURITY.md`
- `docs/TESTING.md`
- `docs/ROADMAP.md`

Also inspect existing architecture decision records under:

```text
docs/decisions/
Investigate

Inspect the actual repository before proposing a solution.

Trace:

entry points;
current data flow;
domain logic;
persistence;
authentication;
authorization;
tests;
external integrations.

Do not propose architectural changes based only on assumptions.

Define the Problem

Clearly describe:

current behavior;
desired behavior;
current limitation;
why a technical change may be needed.

Separate product requirements from technical preferences.

Evaluate Alternatives

For meaningful architecture decisions, consider realistic alternatives.

Compare them using factors such as:

complexity;
maintainability;
security;
testability;
performance;
migration cost;
operational cost;
compatibility with the existing architecture.

Do not create fake alternatives just to make the plan look more complete.

Prefer the Smallest Correct Change

Do not introduce:

microservices;
queues;
event buses;
global state libraries;
new databases;
new external providers;
large abstraction layers;

unless a concrete requirement justifies them.

Prefer improving the existing architecture over replacing it.

Architecture Compatibility

Evaluate the proposed change against the project direction:

UI
↓
Application
↓
Domain
↓
Infrastructure

Check whether the proposal preserves:

separation of concerns;
testability;
server-side security;
controlled infrastructure dependencies.

If the proposal intentionally breaks an existing architectural rule, explain why.

Security Analysis

Identify possible impact on:

authentication;
authorization;
ownership;
user data;
external input;
SSRF;
AI behavior;
secrets;
rate limiting;
privacy.

Read docs/SECURITY.md when any of these areas are involved.

Data Analysis

For database-related changes, identify:

entities affected;
migrations required;
indexes;
constraints;
backward compatibility;
snapshot/history impact;
seed impact;
data migration risks.

Do not recommend destructive migrations without considering existing data.

AI Analysis

If AI is involved, evaluate:

whether AI is actually necessary;
trusted context;
structured output;
schema validation;
business validation;
fallback behavior;
prompt versioning;
observability;
cost;
rate limiting.

Do not propose giving the model unrestricted control over business rules.

Testing Strategy

Define the tests required for implementation.

Consider:

unit tests;
domain tests;
application tests;
integration tests;
component tests;
E2E tests;
negative security tests;
AI evaluation cases.

Focus on the risks introduced by the proposed change.

Produce an Exec Plan

For implementation work, create:

docs/exec-plans/<descriptive-name>.md

Use this structure:

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

The plan must be actionable enough for another agent to implement.

Avoid vague steps such as:

Implement backend.
Add tests.
Improve security.

Prefer concrete steps.

ADR

Create an ADR under:

docs/decisions/

only when the decision materially changes the long-term architecture.

Examples:

changing authentication provider;
introducing a queue;
splitting the backend into another service;
introducing RAG/vector search;
adopting global state management;
changing the primary database.

Do not create ADRs for ordinary implementation details.

ADR Format

When needed, use:

# Title

## Status

Accepted / Proposed / Superseded

## Context

Why this decision is needed.

## Decision

What was decided.

## Consequences

Benefits, costs, risks, and trade-offs.
Do Not Implement

This skill is primarily for investigation and planning.

Do not start implementing the proposed solution unless the user explicitly asks to continue with implementation.

The expected output is a technical plan, not production code.

Finish

At completion, report:

key findings;
recommended approach;
important trade-offs;
Exec Plan created;
ADR created, if applicable;
unresolved risks or questions.

Do not automatically move to implementation.