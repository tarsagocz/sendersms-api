<?php
/**
 * @author Bc. Marek Fajfr <mfajfr90(at)gmail.com>
 * Created at: 11:11 27.09.2019
 */

namespace Smswizz\Models\Campaign;

use Carbon\Carbon;
use Smswizz\Models\AbstractModel;

class AutoReply extends AbstractModel implements \JsonSerializable
{
    const VERSION = 'v1';
    const MODEL = 'auto-reply';
    const MODELS = 'auto-replies';
    /**
     * @var int|null
     */
    protected $campaign_id;
    /**
     * @var string
     */
    protected $value;
    /**
     * @var string
     */
    protected $condition;
    /**
     * @var string
     */
    protected $text;

    /**
     * AutoReply constructor.
     * @param int|null $id
     * @param null|string $uid
     * @param int|null $campaign_id
     * @param string $value
     * @param string $condition
     * @param string $text
     * @param Carbon|null $created_at
     * @param Carbon|null $updated_at
     */
    public function __construct(?int $id, ?string $uid, ?int $campaign_id, string $value, string $condition, string $text, ?Carbon $created_at = null, ?Carbon $updated_at = null, ?Carbon $deleted_at = null)
    {
        parent::__construct($id, $uid, $created_at, $updated_at);
        $this->campaign_id = $campaign_id;
        $this->value = $value;
        $this->condition = $condition;
        $this->text = $text;
    }

    public static function create($row)
    {
        return new self($row['id'], null, $row['campaign_id'], $row['value'], $row['condition'], $row['text'], new Carbon($row['created_at']), new Carbon($row['updated_at']), null);
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
            'campaign_id' => $this->campaign_id,
            'value'       => $this->value,
            'condition'   => $this->condition,
            'text'        => $this->text
        ];
    }
}