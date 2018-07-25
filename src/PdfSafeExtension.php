<?php
/**
 * @file PdfSafeExtension.php
 * @author Ambroise Maupate <ambroise@rezo-zero.com>
 */
namespace RZ\PdfSafe;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * Class PdfSafeExtension
 * @package RZ\PdfSafe
 */
class PdfSafeExtension extends AbstractExtension
{
    /**
     * @var string
     */
    private $schemeAndHost;

    /**
     * PdfSafeExtension constructor.
     * @param string $schemeAndHost
     */
    public function __construct($schemeAndHost)
    {
        $this->schemeAndHost = $schemeAndHost;
    }

    /**
     * @return array
     */
    public function getFilters()
    {
        return [
            new TwigFilter('pdfsafe', [$this, 'pdfsafe'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * @param $string
     * @return mixed|string
     */
    public function pdfsafe($string)
    {
        $safeTags = strip_tags($string, '<div><a><table><tr><td><th><p><strong><em><ul><ol><li><blockquote><br><h1><h2><h3><h4><h5><h6><img><hr>');
        $safeTags = preg_replace('#alt="[^"]*"#', '', $safeTags);
        $safeTags = preg_replace('#start="[^"]*"#', '', $safeTags);
        $safeTags = preg_replace('#style="[^"]*"#', '', $safeTags);
        $safeTags = preg_replace('#title="[^"]*"#', '', $safeTags);
        $safeTags = preg_replace('#rev="[^"]*"#', '', $safeTags);
        // disable target attr
        $safeTags = preg_replace('#target="[^"]*"#', '', $safeTags);
        // disable rel attr
        $safeTags = preg_replace('#rel="[^"]*"#', '', $safeTags);
        // disable anchor links
        $safeTags = preg_replace('#href="\#[^"]*"#', '', $safeTags);
        // disable internal links
        $safeTags = preg_replace('#href="(\/[^"]*)"#', 'href="'.$this->schemeAndHost.'$1"', $safeTags);
        // Switch to absolute links
        $safeTags = preg_replace('#src="(\/[^"]*)"#', 'src="'.$this->schemeAndHost.'$1"', $safeTags);
        $safeTags = preg_replace('#<hr\/>#', '', $safeTags);
        $safeTags = preg_replace('#\&\#8617\;#', '', $safeTags);
        $safeTags = preg_replace('#\&#', '&amp;', $safeTags);

        $safeTags = preg_replace('#<td\s*>#', '<td>', $safeTags);
        $safeTags = preg_replace('#<th\s*>#', '<td>', $safeTags);
        $safeTags = preg_replace('#<\/th>#', '</td>', $safeTags);
        $safeTags = preg_replace('#\<p\>\<br\>#', '<p>', $safeTags);

        return html_entity_decode(trim($safeTags));
    }
}
