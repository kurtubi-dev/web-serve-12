---
name: avoid-ai-design
description: Impeccable UI audit checklist to detect and clean up generic AI frontend aesthetic clichés.
---

# Impeccable Audit & Avoid-AI-Design Checklist

Run this audit on every generated frontend view to clean up AI design cliches:

## The 6-Point Audit Checklist:

1. **Hierarchy & Asymmetry Check**:
   - [ ] Is the page broken into an intentional layout (split view, sidebar + feed, asymmetric hero) rather than a centered generic hero + 3 identical cards?
   - [ ] Does the visual weight lead the eye naturally to the primary action?

2. **Color Palette Restraint**:
   - [ ] Are neon accents replaced with institutional, muted, or purpose-driven accents?
   - [ ] Are backgrounds neutral and clean rather than covered with heavy multi-colored radial gradient blobs?

3. **Typography & Optical Alignment**:
   - [ ] Are headings distinctive with crisp tracking and leading?
   - [ ] Are numerical data (IPK, SKS, dates, codes) set with tabular figures or clean monospace formatting?

4. **Component Grounding**:
   - [ ] Are cards structured with clean borders (`border-slate-200`) and subtle elevation (`shadow-xs` / `shadow-sm`) rather than blurry giant shadows?
   - [ ] Are interactive elements tactile with explicit focus and hover states?

5. **Utility & Information Density**:
   - [ ] Does every component contain realistic, practical information suitable for an actual campus portal?
   - [ ] Are breadcrumbs, contextual filters, and metadata clearly legible?

6. **Accessibility & Resilience**:
   - [ ] Do image tags have proper fallback handlers (`onerror`) so broken avatars or external assets gracefully degrade to clean initial badges?
   - [ ] Are contrast ratios compliant (WCAG AA/AAA)?

