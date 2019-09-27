<?php
/**
 * @author Bc. Marek Fajfr <mfajfr90(at)gmail.com>
 * Created at: 9:26 27.09.2019
 */

namespace Smswizz\Models\Server;

use Smswizz\Traits\HasOneTrait;

trait ServerTrait
{
    use HasOneTrait;
    /**
     * @var null|Server
     */
    protected $server = null;

    public function server($refresh = false)
    {
        if (is_null($this->server) || $refresh) {
            $this->server = Server::create($this->hasOne(Server::MODEL));
        }
        return $this->server;
    }
}