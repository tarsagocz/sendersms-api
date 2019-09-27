<?php
/**
 * @author Bc. Marek Fajfr <mfajfr90(at)gmail.com>
 * Created at: 15:55 26.09.2019
 */

namespace Smswizz\Traits;

use Smswizz\Connection;

trait HasOneTrait
{
    public function hasOne($relation)
    {
        return json_decode(Connection::get(static::VERSION . '/' . static::MODEL . '/uid/' . $this->uid . '/' . $relation)->getBody()->getContents(), true)[$relation];
    }
}