<?php
/**
 * @author Bc. Marek Fajfr <mfajfr90(at)gmail.com>
 * Created at: 10:36 27.09.2019
 */

namespace Smswizz\Models\Group;

use Smswizz\Traits\HasOneTrait;

trait GroupTrait
{
    use HasOneTrait;
    /**
     * @var null|Group
     */
    protected $group = null;

    public function group($refresh = false)
    {
        if (is_null($this->group) || $refresh) {
            $this->group = Group::create($this->hasOne(Group::MODEL));
        }
        return $this->group;
    }
}