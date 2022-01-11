<?php

namespace Hsk99\WebmanTask;

use support\Container;

class Server
{
    /**
     * 服务启动触发任务目录
     *
     * @var string
     */
    protected $_startDir = '';

    /**
     * 服务关闭触发任务目录
     *
     * @var string
     */
    protected $_stopDir = '';

    /**
     * 初始化任务文件所在目录
     *
     * @author HSK
     * @date 2021-11-22 09:01:10
     *
     * @param string $startDir
     * @param string $stopDir
     */
    public function __construct($startDir = '', $stopDir = '')
    {
        $this->_startDir = $startDir;
        $this->_stopDir  = $stopDir;
    }

    /**
     * 服务启动
     *
     * @author HSK
     * @date 2021-11-22 09:01:29
     *
     * @param \Workerman\Worker $worker
     *
     * @return void
     */
    public function onWorkerStart($worker)
    {
        $this->load($worker, $this->_startDir);
    }

    /**
     * 服务关闭
     *
     * @author HSK
     * @date 2021-11-22 09:01:48
     *
     * @param \Workerman\Worker $worker
     *
     * @return void
     */
    public function onWorkerStop($worker)
    {
        $this->load($worker, $this->_stopDir);
    }

    /**
     * 加载任务
     *
     * @author HSK
     * @date 2021-11-22 09:02:03
     *
     * @param \Workerman\Worker $worker
     * @param string $dir
     *
     * @return void
     */
    protected function load($worker, $dir = '')
    {
        if (!is_dir($dir)) {
            return;
        }

        $dirIterator = new \RecursiveDirectoryIterator($dir);
        $iterator    = new \RecursiveIteratorIterator($dirIterator);
        foreach ($iterator as $file) {
            if (is_dir($file)) {
                continue;
            }

            $fileinfo = new \SplFileInfo($file);
            $ext = $fileinfo->getExtension();
            if ($ext === 'php') {
                $class = str_replace('/', "\\", substr(substr($file, strlen(base_path())), 0, -4));
                Container::make($class, [$worker]);
            }
        }
    }
}
