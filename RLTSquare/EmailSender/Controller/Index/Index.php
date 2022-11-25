<?php

declare(strict_types=1);

namespace RLTSquare\EmailSender\Controller\Index;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\MailException;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use RLTSquare\EmailSender\Logger\Logger;
use RLTSquare\EmailSender\Model\EmailSend;

/**
 *package for sending email and logging in logs
 */
class Index implements ActionInterface
{
    /**
     * @var Logger
     */
    protected Logger $logger;
    /**
     * @var Context
     */
    protected Context $context;
    /**
     * @var EmailSend
     */
    protected EmailSend $emailSend;
    /**
     * @var PageFactory
     */
    protected PageFactory $pageFactory;

    /**
     * @param Logger $logger
     * @param Context $context
     * @param EmailSend $emailSend
     * @param PageFactory $pageFactory
     */
    public function __construct(
        Logger      $logger,
        Context     $context,
        EmailSend   $emailSend,
        PageFactory $pageFactory
    ) {
        $this->logger = $logger;
        $this->context = $context;
        $this->emailSend = $emailSend;
        $this->pageFactory = $pageFactory;
    }

    /**
     * @return Page
     */
    public function execute(): Page
    {
        $this->logger->info('Email has been sent');
        $pageFactory = $this->pageFactory->create();
        try {
            $this->emailSend->execute();
            $pageFactory->getConfig()->getTitle()->set('Test');
        } catch (MailException|LocalizedException $e) {
            $pageFactory->getConfig()->getTitle()->set($e->getMessage());
        }

        return $pageFactory;
    }
}
