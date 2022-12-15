<?php

namespace App\Twig;

use DateTimeInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class PostTimestampExtension extends AbstractExtension {

    public function getFunctions(): array {
        return [
            new TwigFunction(
                'date_string',
                [$this, 'getString'],
                ['is_safe'=>['html']]
            )
        ];
    }

    public function getString(DateTimeInterface $datetime): string {
        $now = new \DateTime('now');
        $diff = $now->getTimestamp() - $datetime->getTimestamp();
        if(60 >= $diff) {
            $return = 'just now';
        } else if (3600 > $diff) {
            $return = floor($diff/60) . 'm';
        } else if (25200 > $diff) {
            $return = floor($diff/3600) . 'h';
        } else if (86400 > $diff) {
            $return = '<span class="dt-local-adjust" data-dt="' . $datetime->getTimestamp() . '" data-format="g:ia">' . $datetime->format('g:ia') . '</span>';
        } else {
            $longformat = 'M d' . ($now->format('Y')!==$datetime->format('Y') ? ', Y' : '');
            $return = '<span class="dt-local-adjust" data-dt="' . $datetime->getTimestamp() . '" data-format="' . $longformat . '">' .$datetime->format($longformat) . '</span>';
        }
        return $return;
    }
}