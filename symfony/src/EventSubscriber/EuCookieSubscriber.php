<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Service\EuCookieService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class EuCookieSubscriber
 */
class EuCookieSubscriber implements EventSubscriberInterface
{

    /**
     * @var EuCookieService
     */
    protected $euCookieService;

    /**
     * EuCookieSubscriber constructor.
     *
     * @param EuCookieService $euCookieService
     */
    public function __construct(EuCookieService $euCookieService)
    {
        $this->euCookieService = $euCookieService;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::RESPONSE => ['onKernelResponse', -128],
        ];
    }

    /**
     * Inject the cookie law template
     *
     * @param FilterResponseEvent $event
     */
    public function onKernelResponse(FilterResponseEvent $event)
    {
        if (HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType()) {
            return;
        }
        
        $this->euCookieService->inject($event->getResponse(), $event->getRequest());
    }
}
