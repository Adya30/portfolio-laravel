# Product

<!-- impeccable:product-schema 1 -->

## Platform

web

## Users

Confirmed: beginner-to-intermediate learners (primarily Indonesian-speaking) who want
to learn web development and programming. Secondary audience, also confirmed: prospective
clients and recruiters who read the course section as evidence of how well the author
explains and structures technical work.

The learner's job: pick a subject from the collection, then read the material end to end
without friction, jumping between sub-chapters as questions come up.

## Product Purpose

Confirmed: the course section is one of two things the product must succeed at — a
comfortable, well-structured reading experience for the material, and a credible,
orderly collection that shows professional care. Both matter equally.

## Positioning

Confirmed: the material is authored by a working designer-developer, and the collection
presents his own teaching material rather than aggregated third-party links. The
credibility comes from the author's practice, not from volume.

## Operating Context

- Laravel Blade views with Alpine.js components and Tailwind v4 tokens; no build step
  for content.
- Bilingual: every public string is served through an Alpine `lang` store (EN/ID), and
  course records carry `nama`/`nama_idn` and `desk`/`desk_idn` fields.
- Course content is stored as an ordered array of typed blocks (`subbab`, `subheading`,
  `paragraph`, `gambar`, `kode`, `link`, `pembatas`, `tabel`) authored in the admin panel,
  not as free HTML.
- The course section has its own layout (`layouts.course`) separate from the landing page
  layout, but shares the site's design tokens and components.
- Public surfaces are read-only; there is no learner account, login, or server-side
  progress state.

## Capabilities and Constraints

Confirmed from code:

- Three public surfaces: course index (collection), course detail (description + list of
  sub-chapters), and the material reader (one sub-chapter, with a chapter sidebar and an
  in-page heading list).
- Sub-chapter navigation is client-side fetched (Alpine `navigateSubbab`) and pushes
  history state.
- Syntax highlighting is done client-side with highlight.js; code blocks carry their
  language, line numbers, and a copy control.
- Dark and light themes are both first-class.
- No learner accounts and therefore no persisted progress; any progress affordance is
  out of scope for this round (user chose visual change only).

## Evidence on Hand

- Real authored course content and imagery stored in the `courses` table (`konten`,
  `gambar`).
- No testimonials, benchmarks, enrolment numbers, ratings, or completion data exist.
  Future work must not fabricate any of these.

## Product Principles

1. The material is the product; chrome stays out of its way.
2. Structure is the teaching device — sub-chapters and headings must be scannable at a
   glance, at any depth.
3. Craft is the credential: the finishes a visitor can feel are what make the collection
   read as professional.
4. Stay inside the site's existing brand world rather than inventing a second one.

## Accessibility & Inclusion

- Body copy must hold 4.5:1 contrast in both themes; the reading surface is the primary
  deliverable and is read for long stretches.
- Keyboard focus must stay visible on every control, and the reader must remain usable
  with the sidebar collapsed or absent on small screens.
