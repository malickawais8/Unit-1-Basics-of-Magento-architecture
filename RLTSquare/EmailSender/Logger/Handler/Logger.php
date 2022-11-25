<?php

declare(strict_types=1);

namespace RLTSquare\EmailSender\Logger\Handler;

use Exception;
use Magento\Framework\Filesystem\DriverInterface;
use Magento\Framework\Logger\Handler\Base;

class Logger extends Base
{
    /**
     * Logging level
     * @var int
     */
    protected $loggerType = \Monolog\Logger::INFO;

    /**
     * @param DriverInterface $filesystem
     * @param string $filePath
     * @param string $fileName
     * @throws Exception
     */
    public function __construct(
        DriverInterface $filesystem,
        $filePath = null,
        $fileName = null
    ) {
        $fileName = '/var/log/rltsquare.log';
        parent::__construct($filesystem, $filePath, $fileName);
    }
}
