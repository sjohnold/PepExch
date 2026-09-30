# Search and recommendation architecture

PepExch uses two independent ranking stages: query relevance for marketplace search and item-to-item compatibility for recommendations.

## Search

`MarketplaceSearch` normalizes Unicode input, collapses whitespace, limits query length, and extracts up to eight unique tokens. The database query searches titles, descriptions, models, locations, brands, and categories.

The relevance score prioritizes:

1. Exact title matches
2. Title prefixes
3. Full phrase occurrences in the title
4. Model matches
5. Description and location matches
6. Individual token matches

Condition, location, brand, date, category, and price filters compose with the search query. Explicit price or date sorting overrides relevance; otherwise search results remain relevance-first. Empty queries use newest-first ordering.

This implementation intentionally uses portable SQL expressions supported by MySQL and SQLite. For a larger catalogue, the same service boundary can be backed by PostgreSQL FTS, Meilisearch, or OpenSearch without changing controllers or UI contracts.

## Recommendations

`ListingRecommendation` generates a bounded candidate set from overlapping categories, desired exchange categories, brand, location, and reciprocal preferences. `ListingSimilarity` then assigns an explainable score:

| Signal | Weight |
| --- | ---: |
| Shared category | up to 45 |
| Same brand | 20 |
| Candidate matches requested category | 20 |
| Reciprocal exchange fit | 15 |
| Same condition | 10 |
| Same location | 10 |

Each recommendation includes `recommendation_score` and `recommendation_reasons`. This makes the result observable in the UI and suitable for offline evaluation.

## Evaluation

The pure scoring layer is covered by unit tests. Useful production metrics include search click-through rate, zero-result rate, recommendation click-through rate, offer creation rate, and successful-exchange rate. Ranking changes should be evaluated against those outcomes rather than clicks alone.
