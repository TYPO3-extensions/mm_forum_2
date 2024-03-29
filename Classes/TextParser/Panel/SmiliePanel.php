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
 * @author     Martin Helmich <m.helmich@mittwald.de>
 * @package    MmForum
 * @subpackage TextParser_Panel
 * @version    $Id$
 *
 * @copyright  2010 Martin Helmich <m.helmich@mittwald.de>
 *             Mittwald CM Service GmbH & Co. KG
 *             http://www.mittwald.de
 * @license    GNU Public License, version 2
 *             http://opensource.org/licenses/gpl-license.php
 *
 */

class Tx_MmForum_TextParser_Panel_SmiliePanel extends Tx_MmForum_TextParser_Panel_AbstractPanel {



	/**
	 * TODO
	 *
	 * @var Tx_MmForum_Domain_Repository_Format_SmilieRepository
	 */
	protected $smilieRepository = NULL;



	/**
	 * TODO
	 *
	 * @var array<Tx_MmForum_Domain_Model_Format_Smilie>
	 */
	protected $smilies = NULL;



	/**
	 * TODO
	 *
	 * @param Tx_MmForum_Domain_Repository_Format_SmilieRepository $smilieRepository
	 *
	 * @return void
	 */
	public function injectSmilieRepository(Tx_MmForum_Domain_Repository_Format_SmilieRepository $smilieRepository) {
		$this->smilieRepository = $smilieRepository;
		$this->smilies          = $this->smilieRepository->findAll();
	}



	/**
	 * TODO
	 *
	 * @return array
	 */
	public function getItems() {
		$result = array();

		foreach ($this->smilies as $smilie) {
			$result[] = $smilie->exportForMarkItUp();
		}
		return array(array('name'        => $this->settings['title'],
		                   'className'   => $this->settings['iconClassName'],
		                   'replaceWith' => $this->smilies[0]->getSmilieShortcut(),
		                   'dropMenu'    => $result));
	}

}