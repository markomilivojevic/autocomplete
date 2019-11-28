<?php

namespace Ducha\Autocomplete;

use Illuminate\Redis\Connections\Connection;

/**
 * Class Autocomplete
 * @package App\Autocomplete
 */
class Autocomplete
{
    const TERM_CASE_SEPARATOR = ':';

    /**
     * @var \Illuminate\Redis\Connections\Connection
     */
    protected $connection;


    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param string $bucket
     * @param string $term
     * @return bool
     */
    public function addTerm(string $bucket, string $term): bool
    {
        $term = $this->normalizeTerm($term);

        return $this->save($bucket, $term);
    }

    /**
     * @param string $bucket
     * @param string $term
     * @return bool
     */
    public function removeTerm(string $bucket, string $term): bool
    {
        $term = $this->normalizeTerm($term);

        return $this->remove($bucket, $term);
    }

    /**
     * Normalize term for case insensitive search
     *
     * @param string $term
     * @return string
     */
    protected function normalizeTerm(string $term): string
    {
        if (strpos($term, static::TERM_CASE_SEPARATOR)) {
            throw new \InvalidArgumentException('Term cannot contain "' . static::TERM_CASE_SEPARATOR . '"');
        }

        return strtolower($term) . static::TERM_CASE_SEPARATOR . $term;
    }

    /**
     * @param string $bucket
     * @param array $terms
     * @return int
     */
    public function addTerms(string $bucket, array $terms): int
    {
        $termsAdded = 0;
        foreach ($terms as $term) {
            if ($this->addTerm($bucket, $term)) {
                $termsAdded++;
            }
        }

        return $termsAdded;
    }

    /**
     * @param string $bucket
     * @param string $term
     * @return bool
     */
    protected function save(string $bucket, string $term): bool
    {
        return $this->connection->zAdd($bucket, 0, $term);
    }

    /**
     * @param string $bucket
     * @param string $term
     * @return bool
     */
    protected function remove(string $bucket, string $term): bool
    {
        return $this->connection->zRem($bucket, $term);
    }

    /**
     * @param string $bucket
     * @param string $prefix
     * @return array
     */
    public function complete(string $bucket, string $prefix): array
    {
        $prefix = strtolower($prefix);
        $matches = $this->connection->zRangeByLex($bucket, "[$prefix", "[$prefix\xff");

        return $this->prepareMatches($matches);
    }

    /**
     * @param array $matches
     * @return array
     */
    protected function prepareMatches(array $matches): array
    {
        $result = [];

        foreach ($matches as $match) {
            $term = explode(static::TERM_CASE_SEPARATOR, $match)[1] ?? null;

            if ($term) {
                $result[] = $term;
            }
        }

        return $result;
    }

    /**
     * @param string $bucket
     * @return array
     */
    public function all(string $bucket): array
    {
        $allRecords = $this->connection->zRange($bucket, 0, -1);

        return $this->prepareMatches($allRecords);
    }
}