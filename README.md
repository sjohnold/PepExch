# PepExch

PepExch is a full-stack barter marketplace for discovering items, negotiating exchanges, chatting with other members, and managing offers through a structured exchange workflow.

## Highlights

- Weighted search across listing titles, descriptions, models, locations, brands, and categories
- Relevance-first ranking with category, condition, location, brand, price, and recency filters
- Explainable recommendations based on item similarity and reciprocal exchange preferences
- Listings, wishlists, chat, reviews, notifications, reports, and administration
- Laravel 12 API and application layer with an Inertia + Vue 3 interface

## Search and recommendations

Search uses a deterministic weighted ranking pipeline: exact title and prefix matches are strongest, followed by title tokens, model, description, and location. Filters are composed on the same query and results fall back to newest-first when no search term is supplied.

The recommendation service generates candidates from shared categories, brand, location, and requested exchange categories. It then scores each candidate for category overlap, brand and condition similarity, local availability, and one-way or reciprocal exchange fit. The API response includes both the score and human-readable reasons, making the ranking observable and testable.

## Local Setup

1. Install PHP dependencies:
   ```bash
   composer install
   ```

2. Install frontend dependencies:
   ```bash
   npm install
   ```

3. Configure the environment:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Run migrations and seeders:
   ```bash
   php artisan migrate --seed
   ```

5. Start the application:
   ```bash
   composer run dev
   ```

## Tests and build

```bash
npm run build
composer test
```

Run just the ranking tests with:

```bash
php artisan test --filter MarketplaceSearchTest
```

## License

Released under the MIT License.
