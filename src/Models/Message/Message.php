<?php
/**
 * @author Bc. Marek Fajfr <mfajfr90(at)gmail.com>
 * Created at: 9:52 24.09.2019
 */

namespace Smswizz\Models\Message;

use Carbon\Carbon;
use Smswizz\Connection;
use Smswizz\Models\AbstractModel;
use Smswizz\Models\Campaign\CampaignTrait;
use Smswizz\Models\Server\ServerTrait;
use Smswizz\Models\Subscriber\SubscriberTrait;
use Smswizz\Traits\StoreTrait;
use Smswizz\Traits\UidFindableTrait;

class Message extends AbstractModel implements \JsonSerializable
{
    use UidFindableTrait;
    use SubscriberTrait;
    use ServerTrait;
    use CampaignTrait;
    use StoreTrait;
    const VERSION = 'v1';
    const MODEL = 'message';
    const MODELS = 'messages';
    /**
     * @var int|null
     */
    protected $subscriber_id;
    /**
     * @var int|null
     */
    protected $campaign_id;
    /**
     * @var int|null
     */
    protected $server_id;
    /**
     * @var string
     */
    protected $text;
    /**
     * @var string
     */
    protected $type;
    /**
     * @var string
     */
    protected $status;
    /**
     * @var Carbon|null
     */
    protected $accomplished_at;
    /**
     * @var string|null
     */
    protected $provider_id;
    /**
     * @var []|null
     */
    protected $raw;

    /**
     * Message constructor.
     * @param int|null $id
     * @param null|string $uid
     * @param int|null $subscriber_id
     * @param int|null $campaign_id
     * @param int|null $server_id
     * @param string $text
     * @param string $type
     * @param string $status
     * @param Carbon|null $accomplished_at
     * @param null|string $provider_id
     * @param null|[] $raw
     * @param Carbon|null $created_at
     * @param Carbon|null $updated_at
     */
    public function __construct(?int $id, ?string $uid, ?int $subscriber_id, ?int $campaign_id = null, ?int $server_id, string $text, string $type, string $status, ?Carbon $accomplished_at = null, ?string $provider_id = null, ?array $raw = [], ?Carbon $created_at = null, ?Carbon $updated_at = null)
    {
        parent::__construct($id, $uid, $created_at, $updated_at);
        $this->subscriber_id = $subscriber_id;
        $this->campaign_id = $campaign_id;
        $this->server_id = $server_id;
        $this->text = $text;
        $this->type = $type;
        $this->status = $status;
        $this->accomplished_at = $accomplished_at;
        $this->provider_id = $provider_id;
        $this->raw = $raw;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    public static function create($row)
    {
        $raw = unserialize($row['raw']);
        return new self($row['id'], $row['uid'], $row['subscriber_id'], $row['campaign_id'], $row['server_id'], $row['text'], $row['type'], $row['status'], is_null($row['accomplished_at']) ? null : new Carbon($row['accomplished_at']), $row['provider_id'], $raw, new Carbon($row['created_at']), new Carbon($row['updated_at']));
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
            'subscriber_id'   => $this->subscriber_id,
            'campaign_id'     => $this->campaign_id,
            'server_id'       => $this->server_id,
            'text'            => $this->text,
            'type'            => $this->type
        ];
    }

    public static function send($prefix, $phone, $text, $server_id, $campaign_id = null)
    {
        $result = json_decode(Connection::post(static::VERSION . '/' . static::MODEL . '/send', [
            'prefix'      => $prefix,
            'phone'       => $phone,
            'text'        => $text,
            'server_id'   => $server_id,
            'campaign_id' => $campaign_id
        ])
            ->getBody()
            ->getContents(), true);
        $result[static::MODEL] = static::create($result[static::MODEL]);

        return $result;
    }
}