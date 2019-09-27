<?php
/**
 * @author Bc. Marek Fajfr <mfajfr90(at)gmail.com>
 * Created at: 15:58 27.09.2019
 */

namespace Smswizz\Traits;

use Smswizz\Connection;

trait DestroyTrait
{
    public function destroy()
    {
        $result = json_decode(Connection::delete(static::VERSION . '/'  . static::MODEL . '/' . $this->uid .  '/destroy')->getBody()->getContents(), true);
        $result[static::MODEL] = static::create($result[static::MODEL]);
        return $result;
    }
}