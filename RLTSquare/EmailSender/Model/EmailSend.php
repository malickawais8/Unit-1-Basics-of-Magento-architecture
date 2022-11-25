<?php
declare(strict_types=1);

namespace RLTSquare\EmailSender\Model;

use Magento\Email\Model\BackendTemplate;
use Magento\Framework\App\Area;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\MailException;
use Magento\Framework\Mail\Template\FactoryInterface;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Store\Model\Store;
use RLTSquare\EmailSender\Api\TemplateRepositoryInterface;

/**
 *package for setting template content and user emails
 */
class EmailSend
{
    /**
     * @var BackendTemplate
     */
    protected BackendTemplate $emailTemplate;
    /**
     * @var TransportBuilder
     */
    protected TransportBuilder $transportBuilder;

    /**
     * @var FactoryInterface
     */
    protected FactoryInterface $factory;

    /**
     * @var TemplateRepositoryInterface
     */
    protected TemplateRepositoryInterface $templateRepository;

    /**
     * @param TransportBuilder $transportBuilder
     * @param BackendTemplate $emailTemplate
     * @param FactoryInterface $factory
     * @param TemplateRepositoryInterface $templateRepository
     */
    public function __construct(
        TransportBuilder            $transportBuilder,
        BackendTemplate             $emailTemplate,
        FactoryInterface            $factory,
        TemplateRepositoryInterface $templateRepository
    ) {
        $this->factory = $factory;
        $this->transportBuilder = $transportBuilder;
        $this->emailTemplate = $emailTemplate;
        $this->templateRepository = $templateRepository;
    }

    /**
     * @throws MailException
     * @throws LocalizedException
     */
    public function execute(): void
    {
        $template_id = $this->templateRepository->getById('email_template');
        if ($template_id == null) {
            $template_id = 'email_template';
        }
        $report = [
            'report_date' => date("j F Y", strtotime('-1 day')),
            'name' => 'Malik Awais',
            'email' => 'awais.rehman@rltsquare.com',
        ];

        $postObject = new DataObject();
        $postObject->setData($report);

        $transport = $this->transportBuilder
            ->setTemplateIdentifier($template_id)
            ->setTemplateOptions(['area' => Area::AREA_FRONTEND, 'store' => Store::DEFAULT_STORE_ID])
            ->setTemplateVars(['data' => $postObject])
            ->setFromByScope(['name' => 'Malik Awais', 'email' => 'awais.rehman@rltsquare.com'])
            ->addTo(['danial.javed@rltsquare.com', 'abdullah.zafar@rltsquare.com'])
            ->getTransport();
        $transport->sendMessage();
    }
}
