<?php

/*                                                                    - *
 *  COPYRIGHT NOTICE                                                    *
 *                                                                      *
 *  (c) 2012 Martin Helmich <m.helmich@mittwald.de>                     *
 *           Mittwald CM Service GmbH & Co KG                           *
 *           All rights reserved                                        *
 *                                                                      *
 *  This script is part of the TYPO3 project. The TYPO3 project is      *
 *  free software; you can redistribute it and/or modify                *
 *  it under the terms of the GNU General Public License as published   *
 *  by the Free Software Foundation; either version 2 of the License,   *
 *  or (at your option) any later version.                              *
 *                                                                      *
 *  The GNU General Public License can be found at                      *
 *  http://www.gnu.org/copyleft/gpl.html.                               *
 *                                                                      *
 *  This script is distributed in the hope that it will be useful,      *
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of      *
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the       *
 *  GNU General Public License for more details.                        *
 *                                                                      *
 *  This copyright notice MUST APPEAR in all copies of the script!      *
 *                                                                      */



/**
 *
 * Text parser class for cleaning the HTML output. For this, the tidy library is
 * used.
 *
 * @author     Martin Helmich <m.helmich@mittwald.de>
 * @package    MmForum
 * @subpackage TextParser_Service
 * @version    $Id$
 *
 * @copyright  2012 Martin Helmich <m.helmich@mittwald.de>
 *             Mittwald CM Service GmbH & Co. KG
 *             http://www.mittwald.de
 * @license    GNU Public License, version 2
 *             http://opensource.org/licenses/gpl-license.php
 *
 */

class Tx_MmForum_TextParser_Service_TidyService extends Tx_MmForum_TextParser_Service_AbstractTextParserService {



	/*
	 * ATTRIBUTES
	 */



	/**
	 * The tidy configuration.
	 * @var array
	 */
	protected $tidyConfig = Array('indent'         => FALSE,
	                              'output-xhtml'   => TRUE,
	                              'wrap'           => 0,
	                              'show-body-only' => TRUE,
	                              'enclose-text'   => TRUE);



	/**
	 * Instance of tidy.
	 * @var tidy
	 */
	protected $tidy = NULL;



	/*
	 * METHODS
	 */



	/**
	 * Creates a new instance of this service.
	 */

	public function __construct() {
		parent::__construct();

		if (!class_exists('tidy')) {
			throw new Tx_MmForum_Domain_Exception_TextParser_Exception('The TIDY library could not be loaded. Please install the tidy
				 module for PHP or disable the tidy service in your typoscript
				 setup', 1315857493);
		}
		$this->tidy = new tidy();
	}



	/**
	 * Renders the parsed text.
	 *
	 * @param  string $text The text to be parsed.
	 * @return string       The parsed text.
	 */

	public function getParsedText($text) {
		$this->tidy->parseString($text, $this->tidyConfig, 'utf8');
		$this->tidy->cleanRepair();

		$text = $this->tidy . "";
		$text = preg_replace(',<p>\s*(<br />\s*)+,', '<p>', $text);
		$text = preg_replace(',(<br />\s*)+\s*<\/p>,', '</p>', $text);

		return $text;
	}

}
