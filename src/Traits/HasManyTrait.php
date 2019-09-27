<?php
/**
 * @author Bc. Marek Fajfr <mfajfr90(at)gmail.com>
 * Created at: 14:13 26.09.2019
 */

namespace Smswizz\Traits;

use Smswizz\Connection;

trait HasManyTrait
{
    public function hasMany($method, $relation, $params)
    {
        return Connection::get(static::VERSION . '/' . static::MODEL . '/uid/' . $this->uid . '/' . $relation . '/' . $method . self::params($params));
    }

    public function hasManyGet($relation, $params = [])
    {
        $result = $this->hasMany('get', $relation, $params);
        return json_decode($result->getBody()->getContents(), true)[$relation];
    }

    public function hasManyCount($relation, $params = [])
    {
        $result = $this->hasMany('count', $relation, $params);
        return json_decode($result->getBody()->getContents(), true)['count'];
    }
}