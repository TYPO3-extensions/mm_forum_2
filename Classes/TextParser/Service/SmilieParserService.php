<?php

/*                                                                      *
 *  COPYRIGHT NOTICE                                                    *
 *                                                                      *
 *  (c) 2010 Martin Helmich <m.helmich@mittwald.de>                     *
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
 * Text parser class for parsing smilies.
 *
 * @author     Martin Helmich <m.helmich@mittwald.de>
 * @package    MmForum
 * @subpackage TextParser_Service
 * @version    $Id$
 *
 * @copyright  2010 Martin Helmich <m.helmich@mittwald.de>
 *             Mittwald CM Service GmbH & Co. KG
 *             http://www.mittwald.de
 * @license    GNU Public License, version 2
 *             http://opensource.org/licenses/gpl-license.php
 *
 */

class Tx_MmForum_TextParser_Service_SmilieParserService
	extends Tx_MmForum_TextParser_Service_AbstractTextParserService {



	/*
	 * ATTRIBUTES
	 */



	/**
	 * The smilie repository.
	 * @var Tx_MmForum_Domain_Repository_Format_SmilieRepository
	 */
	protected $smilieRepository;



	/**
	 * All smilies.
	 * @var array<Tx_MmForum_Domain_Model_Format_Smilie>
	 */
	protected $smilies;



	/*
	 * METHODS
	 */



	/**
	 * Injects an instance of the smilie repository.
	 * @param \Tx_MmForum_Domain_Repository_Format_SmilieRepository $smilieRepository An instance of the smilie repository.
	 */
	public function injectSmilieRepository(Tx_MmForum_Domain_Repository_Format_SmilieRepository $smilieRepository) {
		$this->smilieRepository = $smilieRepository;
		$this->smilies          = $this->smilieRepository->findAll();
	}



	/**
	 * Renders the parsed text.
	 *
	 * @param  string $text The text to be parsed.
	 * @return string       The parsed text.
	 */
	public function getParsedText($text) {
		foreach ($this->smilies as $smilie) {
			$text = str_replace($smilie->getSmilieShortcut(), $this->getSmilieIcon($smilie), $text);
		}
		return $text;
	}



	/**
	 *
	 * Renders a smilie icon.
	 *
	 * @param  Tx_MmForum_Domain_Model_Format_Smilie $smilie
	 *                             The smilie that is to be rendered.
	 *
	 * @return string              The smilie as HTML code.
	 *
	 */

	protected function getSmilieIcon(Tx_MmForum_Domain_Model_Format_Smilie $smilie) {
		return '<img src="' . $smilie->getIconFilename() . '" alt="' . $smilie->getSmilieShortcut() . '" />';
	}

}

?>
