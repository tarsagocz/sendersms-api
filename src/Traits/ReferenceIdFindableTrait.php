<?php
/**
 * @author Bc. Marek Fajfr <mfajfr90(at)gmail.com>
 * Created at: 13:02 26.09.2019
 */

namespace Smswizz\Traits;

use Smswizz\Connection;

trait ReferenceIdFindableTrait
{
    public static function findByReferenceId($referenceId)
    {
        $result = Connection::get('v1/' . self::MODEL . '/reference_id/' . $referenceId . '/find');

        $data = json_decode($result->getBody()->getContents(), true)[self::MODEL];

        if (is_null($data)) {
            return null;
        } else {
            return self::create($data);
        }
    }
}