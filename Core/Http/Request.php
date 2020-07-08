<?php

namespace Chr15k\Core\Http;

class Request
{
    public $url;
    public $fullUrl;
    public $query;
    public $queries;
    public $method;

    public function __construct()
    {
        $this->url = $this->getUrl();
        $this->fullUrl = $this->getFullUrl();
        $this->query = $this->getQueryString();
        $this->queries = $this->getQueries();
        $this->method = $this->getMethod();
    }

    public function instance()
    {
    	return $this;
    }

    /**
     * Normalizes a query string.
     *
     * @return string
     */
    public static function normaliseQueryString(?string $queryString)
    {
        if ('' === ($queryString ?? '')) {
            return '';
        }

        parse_str($queryString, $qs);
        ksort($qs);

        return http_build_query($qs, '', '&', PHP_QUERY_RFC3986);
    }

    /**
     * Generates the normalized query string for the Request.
     *
     * @return string|null
     */
    public function getQueryString()
    {
        $queryString = static::normaliseQueryString($_SERVER['QUERY_STRING']);

        return '' === $queryString ? null : $queryString;
    }

    public function getUrl()
    {
    	return strtok($this->getFullUrl(), '?');
    }

    public function getFullUrl()
    {
    	return $_SERVER["REQUEST_URI"];
    }

    /**
     * Return an array from the query string variables.
     *
     * @param  string $queryString
     * @return array
     */
    public function getQueries()
    {
    	parse_str($this->query, $queries);

    	return $queries;
    }

    public function getMethod()
    {
    	return $_SERVER['REQUEST_METHOD'];
    }
}