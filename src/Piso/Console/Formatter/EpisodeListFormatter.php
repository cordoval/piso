<?php

namespace Piso\Console\Formatter;

use Piso\Index\EpisodeList;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Formatter that outputs episode list strings
 */
interface EpisodeListFormatter
{
    public function unknownShow(OutputInterface $output, $show);
    public function noEpisodes(OutputInterface $output, $show);
    public function episodeList(OutputInterface $output, $show, EpisodeList $episodes);
}