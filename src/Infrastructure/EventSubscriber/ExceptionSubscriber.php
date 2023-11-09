<?php

namespace App\Infrastructure\EventSubscriber;

use App\Infrastructure\Helper\ResponseHelper;
use JetBrains\PhpStorm\ArrayShape;
use Prugala\RequestDto\Exception\RequestValidationException;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;

#[AsEventListener(event: KernelEvents::EXCEPTION, method: 'onKernelException')]
class ExceptionSubscriber implements EventSubscriberInterface
{
    public function __construct(private readonly LoggerInterface $logger, private readonly ResponseHelper $responseHelper)
    {
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        switch ($exception) {
            case is_a($exception, NotFoundHttpException::class):
            case is_a($exception, MethodNotAllowedHttpException::class):
                $message = 'Not found.';
                $code = Response::HTTP_NOT_FOUND;
                break;
            case is_a($exception, AccessDeniedHttpException::class):
                $message = 'Access denied.';
                $code = Response::HTTP_FORBIDDEN;
                break;
            case is_a($exception, InvalidOptionsException::class):
            case is_a($exception, BadRequestHttpException::class):
            case is_a($exception, RequestValidationException::class):
                $violations = [];
                foreach ($exception->getViolationList() as $violation) {
                    $violations[] = [
                        'field' => $violation->getPropertyPath(),
                        'message' => $violation->getMessage(),
                    ];
                }
                $message = 'Validation failed.';
                $code = Response::HTTP_BAD_REQUEST;
                $response = $this->responseHelper->returnSingleErrorResponse($message, $violations, $code);
                $event->setResponse($response);

                return; // Stop further processing
            default:
                $this->logger->error($exception->getMessage(), ['exception ' => $exception]);
                // $message = 'Something went wrong.';
                $message = $exception->getMessage();
                $code = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        $response = $this->responseHelper->returnSingleErrorResponse($message, [], $code);

        $event->setResponse($response);
    }

    #[ArrayShape([KernelEvents::EXCEPTION => 'string'])]
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }
}
