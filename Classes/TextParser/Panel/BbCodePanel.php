<?php

/* *
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
 * @version    $Id: BasicParserService.php 39978 2010-11-09 14:19:52Z mhelmich $
 *
 * @copyright  2010 Martin Helmich <m.helmich@mittwald.de>
 *             Mittwald CM Service GmbH & Co. KG
 *             http://www.mittwald.de
 * @license    GNU Public License, version 2
 *             http://opensource.org/licenses/gpl-license.php
 *
 */
class Tx_MmForum_TextParser_Panel_BbCodePanel extends Tx_MmForum_TextParser_Panel_AbstractPanel {



	/**
	 * @var Tx_MmForum_Domain_Repository_Format_BBCodeRepository
	 */
	protected $bbCodeRepository = NULL;



	/**
	 * @var array<Tx_MmForum_Domain_Model_Format_BBCode>
	 */
	protected $bbCodes = NULL;



	/**
	 * @param Tx_MmForum_Domain_Repository_Format_BBCodeRepository $bbCodeRepository
	 */
	public function injectBbCodeRepository(Tx_MmForum_Domain_Repository_Format_BBCodeRepository $bbCodeRepository) {
		$this->bbCodeRepository = $bbCodeRepository;
		$this->bbCodes          = $this->bbCodeRepository->findAll();
	}



	/**
	 * @return array
	 */
	public function getItems() {
		$result = array();

		foreach ($this->bbCodes as $bbCode) {
			$result[] = $bbCode->exportForMarkItUp();
		}
		return $result;
	}



}