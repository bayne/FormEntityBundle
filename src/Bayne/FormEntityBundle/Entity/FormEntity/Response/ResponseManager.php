<?php

namespace Bayne\FormEntityBundle\Entity\FormEntity\Response;

use Bayne\FormEntityBundle\Entity\FormEntity;
use Bayne\FormEntityBundle\Entity\FormEntity\Response;

class ResponseManager
{
    /**
     * @var ResponseRepository
     */
    private $responseRepository;

    /**
     * ResponseRepository constructor.
     *
     * @codeCoverageIgnore
     *
     * @param ResponseRepository $responseRepository
     */
    public function __construct(
        ResponseRepository $responseRepository
    ) {
        $this->responseRepository = $responseRepository;
    }

    /**
     * @codeCoverageIgnore
     *
     * @param FormEntity $formEntity
     *
     * @return Response[]
     */
    public function getResponsesByFormEntity(FormEntity $formEntity)
    {
        return $this->responseRepository->findByFormEntity($formEntity);
    }
}
