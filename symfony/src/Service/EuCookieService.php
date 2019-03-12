<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Templating\EngineInterface;

/**
 * Class EuCookieService
 */
class EuCookieService
{

    /**
     * @var EngineInterface
     */
    private $templating;

    /**
     * @var string
     */
    private $templateName;

    /**
     * @var string
     */
    private $cookieName;

    /**
     * @var string
     */
    private $cookieValue;

    /**
     * @var string
     */
    private $readMoreLink;

    /**
     * EuCookieService constructor.
     *
     * @param EngineInterface $templating
     * @param string          $templateName
     * @param string          $cookieName
     * @param string          $cookieValue
     * @param string          $readMoreLink
     */
    public function __construct(EngineInterface $templating, string $templateName, string $cookieName, string $cookieValue, string $readMoreLink)
    {
        $this->templating = $templating;
        $this->templateName = $templateName;
        $this->cookieName = $cookieName;
        $this->cookieValue = $cookieValue;
        $this->readMoreLink = $readMoreLink;
    }

    /**
     * Inject in the response the cookie law template
     *
     * @param Response $response
     * @param Request $request
     */
    public function inject(Response $response, Request $request)
    {
        if ($this->checkIfMustBeInjected($response, $request) === false) {
            return;
        }

        $render_template = $this->templating->render($this->templateName, [
            'cookie_name' => $this->cookieName,
            'cookie_value' => $this->cookieValue,
            'cookie_read_more_link' => $this->readMoreLink
        ]);

        $content = $response->getContent();
        $position = mb_strripos($content, '</body>');

        if (false !== $position) {
            $content = mb_substr($content, 0, $position).$render_template.mb_substr($content, $position);
            $response->setContent($content);
        }
    }

    /**
     * Check if we must inject the cookie law template
     *
     * @param Response $response
     * @param Request  $request
     *
     * @return bool
     */
    private function checkIfMustBeInjected(Response $response, Request $request)
    {
        if (false === strpos($response->headers->get('Content-Type'), 'text/html')) {
            return false;
        }

        if ($this->cookieValue === $request->cookies->get($this->cookieName)) {
            return false;
        }

        return true;
    }
}
