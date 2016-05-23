<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 16/5/18
 * Time: 上午11:15
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Swoole\Handler;

use FastD\Swoole\Console\Output;
use FastD\Swoole\Console\Process;
use FastD\Swoole\Server\Server;

/**
 * Class Handle
 *
 * @package FastD\Swoole\Handler
 */
class Handle extends HandlerAbstract
{
    /**
     * Base start handle. Storage process id.
     *
     * @param \swoole_server $server
     * @return mixed
     */
    public function onStart(\swoole_server $server)
    {
        if (null !== ($file = $this->server->getPidFile())) {
            if (!is_dir($dir = dirname($file))) {
                mkdir($dir, 0755, true);
            }

            file_put_contents($file, $server->master_pid . PHP_EOL);
        }

        Process::rename(Server::SERVER_NAME);

        Output::output(sprintf('Server[%s] started', $this->server->getPid()));
    }

    /**
     * Shutdown server process.
     */
    public function onShutdown()
    {
        if (null !== ($file = $this->server->getPidFile())) {
            unlink($file);
        }

        Output::output(sprintf('Server[%s] shutdown ', $this->server->getPid()));
    }

    public function onManagerStart()
    {
        Output::output(sprintf('Server[%s] Manager started', $this->server->getPid()));
    }

    public function onManagerStop()
    {
        Output::output(sprintf('Server[%s] Manager stop', $this->server->getPid()));
    }

    public function onWorkerStart()
    {
        Output::output(sprintf('Server[%s] Worker started', $this->server->getPid()));
    }

    public function onWorkerStop()
    {
        Output::output(sprintf('Server[%s] Worker stop', $this->server->getPid()));
    }

    public function onWorkerError()
    {
        Output::output(sprintf('Server[%s] Worker error', $this->server->getPid()));
    }
}