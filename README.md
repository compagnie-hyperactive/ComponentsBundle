# Components Bundle

This Symfony bundle provides all necessary bricks needed accross other 
[LCH](http://compagnie-hyperactive.com) bundles.

## Repository traits

In order to gather some behavior une one places, we introduce following repository traits.

###  `PaginableEntityRepository`

This provides one public method to retrieve a Doctrine `Paginator` object. Below is the signature

```php
    /**
     * @param QueryBuilder $qb the QueryBuilder object containing the query description
     * @param int $page the page wanted (set to 1 by default)
     * @param int|null $maxResults the batch size, if any
     *
     * @return Paginator
     */
    public function getPaginator(QueryBuilder $qb, int $page = 1, int $maxResults = null)
```

Everything is straitforward here.

### `CountableEntityRepository`

This provides a simple method to easily get total query items count.

### `SearchableEntityRepository`

This provides two methods 

#### Full text search method

This is useful for example in AJAX actions (in a not-API context) where you need to retrieve a
list of entity in large term context : classical AJAX search.

```php
/**
     * Used to search in like mode in entity fields
     * @param array $fields the fields names wanted to be searched in
     * @param string $term the term to be searched
     * @param int|null $maxResults the batch size, if any.
     * @param string|null $language if any, ISO code language to filter items on
     *
     * @return array
     */
    public function findByFulltextTerm(
        array $fields,
        string $term,
        int $maxResults = null,
        string $language = null
    ): array

```