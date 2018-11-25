<?php
namespace App\Application\Rest\V1\Normalizer;

use App\Application\Rest\V1\Exceptions\BadRequestException;
use App\Application\Rest\V1\Exceptions\RestExceptions;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class BadRequestErrorNormalizer implements NormalizerInterface
{
    public function normalize($object, $format = null, array $context = array())
    {
        /**
         * @var BadRequestException $object
         */

        $errors = [];
        $validationError = $object->getValidationError();
        if($validationError) {
            foreach ($validationError->getIterator() as $error) {
                $errors[$error->getPropertyPath()] = $error->getMessage();
            }
        }


        return [
            'code' => $object->getStatusCode(),
            'title' => $object->getTitle(),
            'details' => $object->getMessage(),
            'validation_errors' => $errors
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof BadRequestException;
    }
}