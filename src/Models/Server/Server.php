<?php
/**
 * @author Bc. Marek Fajfr <mfajfr90(at)gmail.com>
 * Created at: 16:08 26.09.2019
 */

namespace Smswizz\Models\Server;

use Carbon\Carbon;
use Smswizz\Models\AbstractModel;
use Smswizz\Models\Campaign\CampaignsTrait;
use Smswizz\Models\Message\MessagesTrait;
use Smswizz\Traits\DestroyTrait;
use Smswizz\Traits\ReferenceIdFindableTrait;
use Smswizz\Traits\StoreTrait;
use Smswizz\Traits\UidFindableTrait;
use Smswizz\Traits\UpdateTrait;

class Server extends AbstractModel implements \JsonSerializable
{
    use UidFindableTrait;
    use MessagesTrait;
    use CampaignsTrait;
    use StoreTrait;
    use UpdateTrait;
    use DestroyTrait;
    const VERSION = 'v1';
    const MODEL = 'server';
    const MODELS = 'servers';

    /**
     * @var string
     */
    protected $name;
    /**
     * @var string
     */
    protected $provider;
    /**
     * @var int
     */
    protected $sms_per_second;
    /**
     * @var array
     */
    protected $data;

    /**
     * Server constructor.
     * @param int|null $id
     * @param null|string $uid
     * @param string $name
     * @param string $provider
     * @param int $sms_per_second
     * @param array $data
     * @param Carbon|null $created_at
     * @param Carbon|null $updated_at
     */
    public function __construct(?int $id, ?string $uid, string $name, string $provider, int $sms_per_second = 100, array $data = [], ?Carbon $created_at = null, ?Carbon $updated_at = null, ?Carbon $deleted_at = null)
    {
        parent::__construct($id, $uid, $created_at, $updated_at, $deleted_at);
        $this->name = $name;
        $this->provider = $provider;
        $this->sms_per_second = $sms_per_second;
        $this->data = $data;
    }

    public static function create($row)
    {
        return new self($row['id'], $row['uid'], $row['name'], $row['provider'], $row['sms_per_second'], $row['data'] == '' ? [] : $row['data'], new Carbon($row['created_at']), new Carbon($row['updated_at']), is_null($row['deleted_at']) ? null : new Carbon($row['deleted_at']));
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
            'name'           => $this->name,
            'provider'       => $this->provider,
            'sms_per_second' => $this->sms_per_second,
            'data'           => $this->data
        ];
    }
}