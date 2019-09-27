<?php
/**
 * @author Bc. Marek Fajfr <mfajfr90(at)gmail.com>
 * Created at: 10:26 27.09.2019
 */

namespace Smswizz\Models\Campaign;

use Carbon\Carbon;
use Smswizz\Models\AbstractModel;
use Smswizz\Models\Group\GroupTrait;
use Smswizz\Models\Message\MessagesTrait;
use Smswizz\Models\Server\ServersTrait;
use Smswizz\Models\Subscriber\SubscribersTrait;
use Smswizz\Traits\HasManyTrait;
use Smswizz\Traits\ReferenceIdFindableTrait;
use Smswizz\Traits\UidFindableTrait;

class Campaign extends AbstractModel implements \JsonSerializable
{
    use UidFindableTrait;
    use ReferenceIdFindableTrait;
    use ServersTrait;
    use SubscribersTrait;
    use GroupTrait;
    use MessagesTrait;
    use HasManyTrait;
    const VERSION = 'v1';
    const MODEL = 'campaign';
    const MODELS = 'campaigns';
    /**
     * @var string|null
     */
    protected $reference_id;
    /**
     * @var Carbon|null
     */
    protected $send_at;
    /**
     * @var string
     */
    protected $name;
    /**
     * @var Carbon|null
     */
    protected $finished_at;
    /**
     * @var Carbon|null
     */
    protected $ended_at;
    /**
     * @var string|null
     */
    protected $optout_type;
    /**
     * @var string|null
     */
    protected $optout_url;
    /**
     * @var string|null
     */
    protected $text;
    /**
     * @var string
     */
    protected $status;
    /**
     * @var string
     */
    protected $type;
    /**
     * @var int|null
     */
    protected $group_id;

    /**
     * @var null|AutoReply[]
     */
    protected $auto_replies = null;

    /**
     * @var null|int
     */
    protected $auto_replies_count = null;

    /**
     * Campaign constructor.
     * @param int|null $id
     * @param null|string $uid
     * @param null|string $reference_id
     * @param Carbon|null $send_at
     * @param string $name
     * @param Carbon|null $finished_at
     * @param Carbon|null $ended_at
     * @param string|null $optout_type
     * @param null|string $optout_url
     * @param string $text
     * @param string $status
     * @param string $type
     * @param int|null $group_id
     * @param Carbon $created_at
     * @param Carbon $updated_at
     */
    public function __construct(?int $id, ?string $uid, ?string $reference_id, ?Carbon $send_at, string $name, ?Carbon $finished_at, ?Carbon $ended_at, ?string $optout_type, ?string $optout_url, ?string $text, string $status, string $type, ?int $group_id, Carbon $created_at, Carbon $updated_at)
    {
        parent::__construct($id, $uid, $created_at, $updated_at);
        $this->reference_id = $reference_id;
        $this->send_at = $send_at;
        $this->name = $name;
        $this->finished_at = $finished_at;
        $this->ended_at = $ended_at;
        $this->optout_type = $optout_type;
        $this->optout_url = $optout_url;
        $this->text = $text;
        $this->status = $status;
        $this->type = $type;
        $this->group_id = $group_id;
    }

    public static function create($row)
    {
        return new self($row['id'], $row['uid'], $row['reference_id'], is_null($row['send_at']) ? null : new Carbon($row['send_at']), $row['name'], is_null($row['finished_at']) ? null : new Carbon($row['finished_at']), is_null($row['ended_at']) ? null : new Carbon($row['ended_at']), $row['optout_type'], $row['optout_url'], $row['text'], $row['status'], $row['type'], $row['group_id'], new Carbon($row['created_at']), new Carbon($row['updated_at']));
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
            'reference_id' => $this->reference_id,
            'send_at'      => $this->send_at,
            'name'         => $this->name,
            'finished_at'  => $this->finished_at,
            'ended_at'     => $this->ended_at,
            'optout_type'  => $this->optout_type,
            'optout_url'   => $this->optout_url,
            'text'         => $this->text,
            'status'       => $this->status,
            'type'         => $this->type,
            'group_id'     => $this->group_id
        ];
    }

    public function autoRepliesGet($params = [], $refresh = false)
    {
        if (is_null($this->auto_replies) || $refresh) {
            $this->auto_replies = [];
            $array = json_decode($this->hasMany('get', AutoReply::MODELS, $params)->getBody()->getContents(), true)['auto_replies'];
            foreach ($array as $row) {
                $this->auto_replies[] = AutoReply::create($row);
            }
        }
        return $this->auto_replies;
    }
    public function autoRepliesCount($params = [], $refresh = false)
    {
        if (is_null($this->auto_replies_count) || $refresh) {
            $this->auto_replies_count = $this->hasManyCount(AutoReply::MODELS, $params);
        }
        return $this->auto_replies_count;
    }
}