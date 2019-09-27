<?php
/**
 * @author Bc. Marek Fajfr <mfajfr90(at)gmail.com>
 * Created at: 15:36 27.09.2019
 */

namespace Smswizz\Traits;

use Smswizz\Connection;

trait UpdateTrait
{
    public function update()
    {
        $result = json_decode(Connection::patch(static::VERSION . '/'  . static::MODEL . '/' . $this->uid .  '/update', $this->jsonSerialize())->getBody()->getContents(), true);
        $result[static::MODEL] = static::create($result[static::MODEL]);
        return $result;
    }
}