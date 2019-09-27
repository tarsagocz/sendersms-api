<?php
/**
 * @author Bc. Marek Fajfr <mfajfr90(at)gmail.com>
 * Created at: 9:21 27.09.2019
 */

namespace Smswizz\Models\Message;

use Smswizz\Traits\HasManyTrait;

trait MessagesTrait
{
    use HasManyTrait;
    /**
     * @var null|Message[]
     */
    protected $messages = null;
    /**
     * @var null|int
     */
    protected $count_message = null;

    public function messagesGet($params = [], $refresh = false)
    {
        if (is_null($this->messages) || $refresh) {
            $this->messages = [];
            $array = $this->hasManyGet(Message::MODELS, $params);
            foreach ($array as $row) {
                $this->messages[] = Message::create($row);
            }
        }
        return $this->messages;
    }

    public function messagesCount($params = [], $refresh = false)
    {
        if (is_null($this->count_message) || $refresh) {
            $this->count_message = $this->hasManyCount(Message::MODELS, $params);
        }
        return $this->count_message;
    }
}