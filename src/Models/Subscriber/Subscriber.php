<?php
/**
 * @author Bc. Marek Fajfr <mfajfr90(at)gmail.com>
 * Created at: 10:34 24.09.2019
 */

namespace Smswizz\Models\Subscriber;

use Carbon\Carbon;
use Smswizz\Connection;
use Smswizz\Models\AbstractModel;
use Smswizz\Models\Campaign\CampaignsTrait;
use Smswizz\Models\Message\Message;
use Smswizz\Models\Message\MessagesTrait;
use Smswizz\Traits\DestroyTrait;
use Smswizz\Traits\HasManyTrait;
use Smswizz\Traits\ReferenceIdFindableTrait;
use Smswizz\Traits\StoreTrait;
use Smswizz\Traits\UidFindableTrait;
use Smswizz\Traits\UpdateTrait;

class Subscriber extends AbstractModel implements \JsonSerializable
{
    use UidFindableTrait;
    use ReferenceIdFindableTrait;
    use MessagesTrait;
    use CampaignsTrait;
    use StoreTrait;
    use UpdateTrait;
    use DestroyTrait;

    const VERSION = 'v1';
    const MODEL = 'subscriber';
    const MODELS = 'subscribers';

    /**
     * @var string
     */
    protected $prefix;
    /**
     * @var string
     */
    protected $phone;
    /**
     * @var string
     */
    protected $created_by;
    /**
     * @var Carbon|null
     */
    protected $optouted_at;
    /**
     * @var Carbon|null
     */
    protected $optouting_at;
    /**
     * @var string|null
     */
    protected $reference_id;

    /**
     * Subscriber constructor.
     * @param int|null $id
     * @param null|string $uid
     * @param string $prefix
     * @param string $phone
     * @param string $created_by
     * @param Carbon|null $optouted_at
     * @param Carbon|null $optouting_at
     * @param null|string $reference_id
     * @param Carbon|null $created_at
     * @param Carbon|null $updated_at
     */
    public function __construct(?int $id, ?string $uid, string $prefix, string $phone, string $created_by = SubscriberCreatedByEnumeration::REMOTE_API, ?Carbon $optouted_at = null, ?Carbon $optouting_at = null, ?string $reference_id = null, ?Carbon $created_at = null, ?Carbon $updated_at = null, ?Carbon $deleted_at = null)
    {
        parent::__construct($id, $uid, $created_at, $updated_at);
        $this->prefix = $prefix;
        $this->phone = $phone;
        $this->created_by = $created_by;
        $this->optouted_at = $optouted_at;
        $this->optouting_at = $optouting_at;
        $this->reference_id = $reference_id;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
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
            'prefix'       => $this->prefix,
            'phone'        => $this->phone,
            'created_by'   => $this->created_by,
            'reference_id' => $this->reference_id
        ];
    }

    public static function create($row)
    {
        return new self($row['id'], $row['uid'], $row['prefix'], $row['phone'], $row['created_by'], is_null($row['optouted_at']) ? null : new Carbon($row['optouted_at']), is_null($row['optouting_at']) ? null : new Carbon($row['optouting_at']), $row['reference_id'], new Carbon($row['created_at']), new Carbon($row['updated_at']), is_null($row['deleted_at']) ? null : new Carbon($row['deleted_at']));
    }

    public function send($text, $server_id, $campaign_id = null)
    {
        $result = json_decode(Connection::post(static::VERSION . '/' . static::MODEL . '/' . $this->uid . '/send', [
            'text'        => $text,
            'server_id'   => $server_id,
            'campaign_id' => $campaign_id
        ])
            ->getBody()
            ->getContents(), true);
        $result[Message::MODEL] = Message::create($result[Message::MODEL]);

        return $result;
    }
}