<?php

namespace App\Services;

class DigParser {
    /**
     * Parse the output from dig.
     */
    public function parse($raw) {
        $regex = '/' .
            '^;(.*?)' .
            ';; QUESTION SECTION\:(.*?)' .
            '(;; ANSWER SECTION\:(.*?))?' .
            '(;; AUTHORITY SECTION\:(.*?))?' .
            '(;; ADDITIONAL SECTION\:(.*?))?' .
            '(;;.*)' .
            '/ims';

        if (preg_match($regex, $raw, $matches)) {

            $result = new Result();

            /* Start parsing the data */

            /* query section */

            $line = trim(preg_replace('/^(;*)/', '', trim($matches[2])));
            list($host, $class, $type) = preg_split('/[\s]+/', $line, 3);
            $result->query[] = new Resource($host, null, $class, $type, null);


            /* answer section */

            $temp = trim($matches[4]);
            if ($temp) {
                $temp = explode("\n", $temp);
                if (count($temp)) {
                    foreach ($temp as $line) {
                        $result->answer[] = $this->parseDigResource($line);
                    }
                }
            }


            /* authority section */

            $temp = trim($matches[6]);
            if ($temp) {
                $temp = explode("\n", $temp);
                if (count($temp)) {
                    foreach ($temp as $line) {
                        $result->authority[] = $this->parseDigResource($line);
                    }
                }
            }


            /* additional section */

            $temp = trim($matches[8]);
            if ($temp) {
                $temp = explode("\n", $temp);
                if (count($temp)) {
                    foreach ($temp as $line) {
                        $result->additional[] = $this->parseDigResource($line);
                    }
                }
            }

            /* footer */

            $temp = explode("\n", trim($matches[9]));
            if (preg_match('/query time: (.*?)$/i', $temp[0], $m)) {
                $result->queryTime = trim($m[1]);
            }

            /* done */

            return $result;
        }

        throw new \Exception("Can't parse raw data");
    }

    /**
     * Parses a resource record line
     *
     * @param string           $line    The line to parse
     *
     * @return obj Net_Dig_resource  $return   A Net_Dig_resource object
     *
     * @access private
     * @author Colin Viebrock <colin@easyDNS.com>
     * @since  PHP 4.0.5
     */
    private function parseDigResource($line) {
        /* trim and remove leading ;, if present */

        $line = trim(preg_replace('/^(;*)/', '', trim($line)));

        if ($line) {
            list($host, $ttl, $class, $type, $data) = preg_split('/[\s]+/', $line, 5);
            return new Resource($host, $ttl, $class, $type, $data);
        }

        return null;
    }
}

class Resolver {
    private $parser;

    public function __construct(DigParser $parser) {
        $this->parser = $parser;
    }

    public function query($server, $name, $type) {
        $cmd = sprintf(
            'dig @%s %s %s',
            escapeshellarg($server),
            escapeshellarg($name),
            escapeshellarg($type)
        );
        exec($cmd, $output);
        $raw = trim(implode("\n", $output));
        return $this->parser->parse($raw);
    }
}

class Resource {
    public $host, $ttl, $class, $type, $data;

    public function __construct($host = null, $ttl = null, $class = null, $type = null, $data = null) {
        $this->host = $host;
        $this->ttl = $ttl;
        $this->class = $class;
        $this->type = $type;
        $this->data = $data;
    }
}

class Result {
    public $query, $answer, $authority, $additional;
    public $queryTime;

    public function __construct($query = null, $answer = null, $authority = null, $additional = null, $queryTime = null) {
        $this->query = $query;
        $this->answer = $answer;
        $this->authority = $authority;
        $this->additional = $additional;
        $this->queryTime = $queryTime;
    }
}
