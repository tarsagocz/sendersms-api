<?php
/**
 * @author Bc. Marek Fajfr <mfajfr90(at)gmail.com>
 * Created at: 15:35 27.09.2019
 */

namespace Smswizz\Traits;

use Smswizz\Connection;

trait StoreTrait
{
    public function store()
    {
        $result = json_decode(Connection::post(static::VERSION . '/'  . static::MODEL . '/store', $this->jsonSerialize())->getBody()->getContents(), true);
        $result[static::MODEL] = static::create($result[static::MODEL]);
        return $result;
    }
}