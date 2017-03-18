<?php

namespace IsaiasCardenas\Domcrawler\domcrawlers;

interface CrawlerInterface
{
	public function parse();
	public function getHistory();
}
