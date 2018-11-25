<?php
namespace App\Application\Rest\V1\Normalizer;

use App\Application\Rest\V1\Exceptions\RestExceptions;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ErrorNormalizer implements NormalizerInterface
{
    public function normalize($object, $format = null, array $context = array())
    {
        /**
         * @var RestExceptions $object
         */

        return [
            'code' => $object->getStatusCode(),
            'title' => $object->getTitle(),
            'details' => $object->getMessage(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof RestExceptions;
    }
}