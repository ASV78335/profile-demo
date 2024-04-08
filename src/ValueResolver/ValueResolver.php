<?php

namespace App\ValueResolver;

use App\Exception\RequestBodyConvertException;
use App\Exception\ValidationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Throwable;

class ValueResolver implements ValueResolverInterface
{
    private array $acceptedValues = [
        'App\Model\RequestAddress',
        'App\Model\RequestDate',
        'App\Model\RequestPeriod',
        'App\Model\RequestProduct',
        'App\Model\ContractCreateUpdate',
        'App\Model\ProductCreateUpdate',
        'App\Model\SubscriberCreateUpdate'
    ];

    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly ValidatorInterface $validator)
    {
    }

    public function resolve(Request $request, ArgumentMetadata $argument): array
    {
        $argumentType = $argument->getType();
        if (
            !$argumentType || (!in_array($argumentType, $this->acceptedValues)  )
        ) {
            return [];
        }

        try {
            $model = $this->serializer->deserialize(
                $request->getContent(),
                $argumentType,
                JsonEncoder::FORMAT
            );
        } catch (Throwable $throwable) {
            throw new RequestBodyConvertException($throwable);
        }

        $errors = $this->validator->validate($model);

        if (count($errors) > 0) {
            throw new ValidationException($errors);
        }

        return [$model];
    }
}
