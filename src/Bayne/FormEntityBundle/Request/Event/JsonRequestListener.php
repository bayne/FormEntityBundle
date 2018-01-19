<?php

namespace Bayne\FormEntityBundle\Request\Event;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\Serializer\Encoder\JsonDecode;

/**
 * For JSON-bodied requests, add the object to Request's request parameter bag
 */
class JsonRequestListener
{
    /**
     * @var JsonDecode
     */
    private $jsonDecode;

    public function __construct(DecoderInterface $jsonDecode)
    {
        if (false === $jsonDecode->supportsDecoding('json')) {
            throw new \RuntimeException('Decoder must support json');
        }
        $this->jsonDecode = $jsonDecode;
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        if (empty($request->getContent())) {
            return;
        }

        if ($request->getContentType() !== 'json') {
            return;
        }

        try {
            $data = $this->jsonDecode->decode($request->getContent(), 'json');
            $request->request->replace($data);
        } catch (\UnexpectedValueException $e) {
            throw new BadRequestHttpException('Invalid JSON', $e);
        }
    }
}
