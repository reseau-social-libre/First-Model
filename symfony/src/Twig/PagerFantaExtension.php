<?php

declare(strict_types=1);

namespace App\Twig;

use Pagerfanta\Pagerfanta;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class PagerFantaExtension
 */
class PagerFantaExtension extends AbstractExtension
{

    /**
     * @var Environment
     */
    private $twig;

    /**
     * PagerFantaExtension constructor.
     *
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('rsl_pagerfanta_pager', [$this, 'renderPager'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * @param Pagerfanta $pagerfanta
     * @param string     $templateName
     *
     * @return string
     */
    public function renderPager(Pagerfanta $pagerfanta, string $templateName)
    {
        $currentPage = $pagerfanta->getCurrentPage();
        $firstPage = 1;
        $lastPage = $pagerfanta->getNbPages();
        $leftPage = max($currentPage - (intval(floor((4) / 2))), $firstPage);
        $rightPage = min($leftPage + 4 - 1, $lastPage);

        if ($rightPage === $lastPage) {
            $leftPage = max($rightPage - 4 + 1, $firstPage);
        }

        $context = [
            'haveToPaginate' => $pagerfanta->haveToPaginate(),
            'hasPreviousPage' => $pagerfanta->hasPreviousPage(),
            'hasNextPage' => $pagerfanta->hasNextPage(),
            'page_current' => $currentPage,
            'page_left' => $leftPage,
            'page_right' => $rightPage,
            'page_first' => $firstPage,
            'page_last' => $lastPage,
            'item_left' => $pagerfanta->getCurrentPageOffsetStart(),
            'item_right' => $pagerfanta->getCurrentPageOffsetEnd(),
            'item_first' => 1,
            'item_last' => $pagerfanta->count(),
        ];

        return $this->twig->render($templateName, $context);
    }
}