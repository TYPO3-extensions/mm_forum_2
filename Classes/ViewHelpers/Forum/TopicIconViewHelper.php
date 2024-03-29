<?php

/* *
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
 * ViewHelper that renders a topic icon.
 *
 * @author     Martin Helmich <m.helmich@mittwald.de>
 * @package    MmForum
 * @subpackage ViewHelpers_Forum
 * @version    $Id$
 *
 * @copyright  2012 Martin Helmich <m.helmich@mittwald.de>
 *             Mittwald CM Service GmbH & Co. KG
 *             http://www.mittwald.de
 * @license    GNU Public License, version 2
 *             http://opensource.org/licenses/gpl-license.php
 *
 */
class Tx_MmForum_ViewHelpers_Forum_TopicIconViewHelper extends Tx_Fluid_ViewHelpers_CObjectViewHelper {



	/**
	 * The frontend user repository.
	 * @var Tx_MmForum_Domain_Repository_User_FrontendUserRepository
	 */
	protected $frontendUserRepository = NULL;



	/**
	 *
	 * Injects a frontend user repository.
	 * @param  Tx_MmForum_Domain_Repository_User_FrontendUserRepository $frontendUserRepository
	 *                             A frontend user repository.
	 * @return void
	 *
	 */
	public function injectFrontendUserRepository(Tx_MmForum_Domain_Repository_User_FrontendUserRepository $frontendUserRepository) {
		$this->frontendUserRepository = $frontendUserRepository;
	}



	/**
	 *
	 * Initializes the view helper arguments.
	 * @return void
	 *
	 */
	public function initializeArguments() {
		$this->registerArgument('important', 'integer',
		                        'Amount of posts required for a topic to contain in order to be marked as important',
		                        FALSE, 15);
	}



	/**
	 *
	 * Renders the topic icon.
	 *
	 * @param  Tx_MmForum_Domain_Model_Forum_Topic $topic
	 *                                                         The topic for which the icon is to be rendered.
	 * @param  integer                             $width      Image width
	 * @param  string                              $alt        Alt text
	 * @return string             The rendered icon.
	 *
	 */
	public function render(Tx_MmForum_Domain_Model_Forum_Topic $topic = NULL, $width = NULL) {
		return parent::render('plugin.tx_mmforum.renderer.icons.topic', $this->getDataArray($topic));
	}



	/**
	 *
	 * Generates a data array that will be passed to the typoscript object for
	 * rendering the icon.
	 * @param  Tx_MmForum_Domain_Model_Forum_Topic $topic
	 *                             The topic for which the icon is to be displayed.
	 * @return array               The data array for the typoscript object.
	 *
	 */
	protected function getDataArray(Tx_MmForum_Domain_Model_Forum_Topic $topic = NULL) {
		if ($topic === NULL) {
			return array();
		} elseif ($topic instanceof Tx_MmForum_Domain_Model_Forum_ShadowTopic) {
			return array('moved' => TRUE);
		} else {
			return array('important' => $topic->getPostCount() >= $this->arguments['important'],
			             'new'       => !$topic->hasBeenReadByUser($this->frontendUserRepository->findCurrent()),
			             'closed'    => $topic->isClosed(),
			             'sticky'    => $topic->isSticky(),
			             'solved'    => FALSE /* TODO: Implement! */);
		}
	}



}
