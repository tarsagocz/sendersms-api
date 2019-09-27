<?php
/**
 * @author Bc. Marek Fajfr <mfajfr90(at)gmail.com>
 * Created at: 9:28 27.09.2019
 */

namespace Smswizz\Models\Server;

use Smswizz\Traits\HasManyTrait;

trait ServersTrait
{
    use HasManyTrait;
    /**
     * @var null|Server[]
     */
    protected $servers = null;
    /**
     * @var null|int
     */
    protected $count_server = null;

    public function serversGet($params = [], $refresh = false)
    {
        if (is_null($this->servers) || $refresh) {
            $this->servers = [];
            $array = $this->hasManyGet(Server::MODELS, $params);
            foreach ($array as $row) {
                $this->servers[] = Server::create($row);
            }
        }
        return $this->servers;
    }

    public function serversCount($params = [], $refresh = false)
    {
        if (is_null($this->count_server) || $refresh) {
            $this->count_server = $this->hasManyCount(Server::MODELS, $params);
        }
        return $this->count_server;
    }
}