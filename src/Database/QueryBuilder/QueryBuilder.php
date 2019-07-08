<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.09.2018
 * Time: 1:34
 */

namespace ES\Kernel\Database\QueryBuilder;

class QueryBuilder
{
    /**
     * @var string
     */
    private $sql = '';

    /**
     * @return QueryBuilder
     */
    public function select(): QueryBuilder
    {
        return $this;
    }

    /**
     * @param array $columns
     * @return QueryBuilder
     */
    public function columns(array $columns): QueryBuilder
    {
        return $this;
    }

    /**
     * @return QueryBuilder
     */
    public function distinct(): QueryBuilder
    {
        return $this;
    }

    /**
     * @param string $column
     * @return QueryBuilder
     */
    public function count(string $column = '*'): QueryBuilder
    {
        return $this;
    }

    /**
     * @param string $column
     * @return QueryBuilder
     */
    public function sum(string $column): QueryBuilder
    {
        return $this;
    }

    /**
     * @param array $confition
     * @return QueryBuilder
     */
    public function having(array $confition): QueryBuilder
    {
        return $this;
    }

    /**
     * @param string $column
     * @return QueryBuilder
     */
    public function max(string $column): QueryBuilder
    {
        return $this;
    }

    /**
     * @param string $column
     * @return QueryBuilder
     */
    public function min(string $column): QueryBuilder
    {
        return $this;
    }

    /**
     * @param string $column
     * @return QueryBuilder
     */
    public function avg(string $column): QueryBuilder
    {
        return $this;
    }

    /**
     * @param string $expSql
     * @return QueryBuilder
     */
    public function expSql(string $expSql): QueryBuilder
    {
        return $this;
    }

    /**
     * @param string $columns
     * @return QueryBuilder
     */
    public function orderBy(string $columns): QueryBuilder
    {
        return $this;
    }

    /**
     * @param string $tables
     * @return QueryBuilder
     */
    public function from(string $tables): QueryBuilder
    {
        return $this;
    }

    /**
     * @param string $table
     * @param string $alias
     * @return QueryBuilder
     */
    public function leftJoin(string $table, string $alias): QueryBuilder
    {
        return $this;
    }

    /**
     * @param string $table
     * @param string $alias
     * @return QueryBuilder
     */
    public function innerJoin(string $table, string $alias): QueryBuilder
    {
        return $this;
    }

    /**
     * @param string $table
     * @param string $alias
     * @return QueryBuilder
     */
    public function rightJoin(string $table, string $alias): QueryBuilder
    {
        return $this;
    }

    /**
     * @param string $column1
     * @param string $column2
     * @return QueryBuilder
     */
    public function using(string $column1, string $column2): QueryBuilder
    {
        return $this;
    }

    /**
     * @param string $column1
     * @param string $column2
     * @return QueryBuilder
     */
    public function on(string $column1, string $column2): QueryBuilder
    {
        return $this;
    }

    /**
     * @return QueryBuilder
     */
    public function where(array $condition): QueryBuilder
    {
        return $this;
    }

    /**
     * @param int $limit
     * @return QueryBuilder
     */
    public function limit(int $limit): QueryBuilder
    {
        return $this;
    }

    /**
     * @param int $offset
     * @return QueryBuilder
     */
    public function offset(int $offset): QueryBuilder
    {
        return $this;
    }

    /**
     * @param string $columns
     * @return QueryBuilder
     */
    public function groupBy(string $columns): QueryBuilder
    {
        return $this;
    }

    /**
     * @param string $sql
     */
    public function setSql(string $sql): void
    {
        $this->sql = $sql;
    }

    /**
     * @return string
     */
    public function getSql(): string
    {
        return $this->sql;
    }

    /**
     * @return QueryBuilder
     */
    public function build(): QueryBuilder
    {
        return $this;
    }
}