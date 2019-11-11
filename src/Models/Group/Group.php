<?php
/**
 * @author Bc. Marek Fajfr <mfajfr90(at)gmail.com>
 * Created at: 10:03 27.09.2019
 */

namespace Smswizz\Models\Group;

use Carbon\Carbon;
use Smswizz\Models\AbstractModel;
use Smswizz\Models\Campaign\CampaignsTrait;
use Smswizz\Traits\DestroyTrait;
use Smswizz\Traits\StoreTrait;
use Smswizz\Traits\UidFindableTrait;
use Smswizz\Traits\UpdateTrait;

class Group extends AbstractModel implements \JsonSerializable
{
    use UidFindableTrait;
    use CampaignsTrait;
    use StoreTrait;
    use UpdateTrait;
    use DestroyTrait;
    const VERSION = 'v1';
    const MODEL = 'group';
    const MODELS = 'groups';

    /**
     * @var string
     */
    protected $name;

    /**
     * Group constructor.
     * @param int|null $id
     * @param null|string $uid
     * @param string $name
     * @param Carbon|null $created_at
     * @param Carbon|null $updated_at
     */
    public function __construct(?int $id, ?string $uid, string $name, ?Carbon $created_at = null, ?Carbon $updated_at = null, ?Carbon $deleted_at = null)
    {
        parent::__construct($id, $uid, $created_at, $updated_at);
        $this->name = $name;
    }

    public static function create($row)
    {
        return new self($row['id'], $row['uid'], $row['name'], new Carbon($row['created_at']), new Carbon($row['updated_at']), is_null($row['deleted_at']) ? null : new Carbon($row['deleted_at']));
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
            'name'           => $this->name
        ];
    }
}