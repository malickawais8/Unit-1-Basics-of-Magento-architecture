<?php
declare(strict_types=1);

namespace RLTSquare\EmailSender\Api;

use Magento\Framework\Exception\NoSuchEntityException;

/**
 * @interface
 */
interface TemplateRepositoryInterface
{
    /**
     * @param String $id
     * @throws NoSuchEntityException
     *@api
     */
    public function getById(String $id);
}
