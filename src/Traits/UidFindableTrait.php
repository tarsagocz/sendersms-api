<?php
/**
 * @author Bc. Marek Fajfr <mfajfr90(at)gmail.com>
 * Created at: 13:02 26.09.2019
 */

namespace Smswizz\Traits;

use Smswizz\Connection;

trait UidFindableTrait
{
    public static function findByUid($uid)
    {
        $result = Connection::get('v1/' . self::MODEL . '/uid/' . $uid . '/find');

        $data = json_decode($result->getBody()->getContents(), true)[self::MODEL];

        if (is_null($data) || empty($data)) {
            return null;
        } else {
            return self::create($data);
        }
    }
}