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
 * Repository class for topic objects.
 *
 * @author     Martin Helmich <m.helmich@mittwald.de>
 * @package    MmForum
 * @subpackage Domain_Repository_Forum
 * @version    $Id$
 *
 * @copyright  2012 Martin Helmich <m.helmich@mittwald.de>
 *             Mittwald CM Service GmbH & Co. KG
 *             http://www.mittwald.de
 * @license    GNU Public License, version 2
 *             http://opensource.org/licenses/gpl-license.php
 *
 */
class Tx_MmForum_Domain_Repository_Forum_TopicRepository extends Tx_MmForum_Domain_Repository_AbstractRepository {



	/*
	 * REPOSITORY METHODS
	 */



	/**
	 * Finds topics for the forum show view. Page navigation is possible.
	 *
	 * @param  Tx_MmForum_Domain_Model_Forum_Forum $forum
	 *                               The forum for which to load the topics.
	 * @return Tx_MmForum_Domain_Model_Forum_Topic[]
	 *                               The selected subset of topics.
	 */
	public function findForIndex(Tx_MmForum_Domain_Model_Forum_Forum $forum) {
		$query = $this->createQuery();
		$query
			->matching($query->equals('forum', $forum))
			->setOrderings(array('sticky'           => 'DESC',
			                    'last_post_crdate'  => 'DESC'));
		return $query->execute();
	}



	/**
	 * Finds topics by post authors, i.e. all topics that contain at least one post
	 * by a specific author. Page navigation is possible.
	 *
	 * @param  Tx_MmForum_Domain_Model_User_FrontendUser $user
	 *                               The frontend user whose topics are to be loaded.
	 * @return Tx_MmForum_Domain_Model_Forum_Topic[]
	 *                               All topics that contain a post by the specified
	 *                               user.
	 */
	public function findByPostAuthor(Tx_MmForum_Domain_Model_User_FrontendUser $user) {
		$query = $this->createQuery();
		$query
			->matching($query->equals('posts.author', $user))
			->setOrderings(array('posts.crdate' => 'DESC'));
		return $query->execute();
	}



	/**
	 * Counts topics by post authors. See findByPostAuthor.
	 *
	 * @param  Tx_MmForum_Domain_Model_User_FrontendUser $user
	 *                               The frontend user whose topics are to be loaded.
	 * @return integer               The number of topics that contain a post by the
	 *                               specified user.
	 */
	public function countByPostAuthor(Tx_MmForum_Domain_Model_User_FrontendUser $user) {
		return $this
			->findByPostAuthor($user)
			->count();
	}



	/**
	 * Counts all topics for the forum show view.
	 *
	 * @param  Tx_MmForum_Domain_Model_Forum_Forum $forum
	 *                             The forum for which the topics are to be counted.
	 * @return integer             The topic count.
	 */
	public function countForIndex(Tx_MmForum_Domain_Model_Forum_Forum $forum) {
		return $this->countByForum($forum);
	}



	/**
	 * Finds all topic that have been subscribed by a certain user.
	 *
	 * @param Tx_MmForum_Domain_Model_User_FrontendUser $user
	 *                             The user for whom the subscribed topics are to be loaded.
	 * @return Tx_Extbase_Persistence_QueryInterface
	 *                             The topics subscribed by the given user.
	 */
	public function findBySubscriber(Tx_MmForum_Domain_Model_User_FrontendUser $user) {
		$query = $this->createQuery();
		$query
			->matching($query->contains('subscribers', $user))
			->setOrderings(array('lastPost.crdate' => 'ASC'));
		return $query->execute();
	}



}
