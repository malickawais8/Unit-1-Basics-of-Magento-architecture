<?php
declare(strict_types=1);

namespace RLTSquare\EmailSender\Model;

use Magento\Email\Model\ResourceModel\Template as TemplateResourceModel;
use Magento\Email\Model\TemplateFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use RLTSquare\EmailSender\Api\TemplateRepositoryInterface;

/**
 * @TemplateRepository
 */
class TemplateRepository implements TemplateRepositoryInterface
{
    /**
     * @var TemplateFactory
     */
    protected TemplateFactory $templateFactory;

    /**
     * @var TemplateResourceModel
     */
    protected TemplateResourceModel $templateResourceModel;

    /**
     * @param TemplateFactory $templateFactory
     * @param TemplateResourceModel $templateResourceModel
     */
    public function __construct(
        TemplateFactory $templateFactory,
        TemplateResourceModel $templateResourceModel
    ) {
        $this->templateFactory        = $templateFactory;
        $this->templateResourceModel  = $templateResourceModel;
    }

    /**
     * @param string $id
     * @return int|null
     * @throws NoSuchEntityException
     */
    public function getById(string $id)
    {
        $object = $this->templateFactory->create();
        $this->templateResourceModel->load($object, $id, 'orig_template_code');
        if (!$object->getId()) {
            throw new NoSuchEntityException(__('Object with id "%1" does not exist.', $id));
        }
        return $object->getId();
    }
}
