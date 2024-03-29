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
 *  it under the terms of the GNU General public License as published   *
 *  by the Free Software Foundation; either version 2 of the License,   *
 *  or (at your option) any later version.                              *
 *                                                                      *
 *  The GNU General public License can be found at                      *
 *  http://www.gnu.org/copyleft/gpl.html.                               *
 *                                                                      *
 *  This script is distributed in the hope that it will be useful,      *
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of      *
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the       *
 *  GNU General public License for more details.                        *
 *                                                                      *
 *  This copyright notice MUST APPEAR in all copies of the script!      *
 *                                                                      */



/**
 *
 * A service class that handles the entire authentication.
 *
 * @author     Martin Helmich <m.helmich@mittwald.de>
 * @package    MmForum
 * @subpackage Domain_Service
 * @version    $Id: AuthenticationService.php 39978 2010-11-09 14:19:52Z mhelmich $
 *
 * @copyright  2010 Martin Helmich <m.helmich@mittwald.de>
 *             Mittwald CM Service GmbH & Co. KG
 *             http://www.mittwald.de
 * @license    GNU public License, version 2
 *             http://opensource.org/licenses/gpl-license.php
 *
 */
class Tx_MmForum_Service_Authentication_AuthenticationService extends Tx_MmForum_Service_AbstractService
	implements Tx_MmForum_Service_Authentication_AuthenticationServiceInterface {



	/*
	 * ATTRIBUTES
	 */



	/**
	 * A frontend user repository.
	 * @var Tx_MmForum_Domain_Repository_User_FrontendUserRepository
	 */
	protected $frontendUserRepository = NULL;



	/**
	 * An instance of the mm_forum cache class.
	 * @var Tx_MmForum_Cache_Cache
	 */
	protected $cache = NULL;



	/**
	 * The current frontend user.
	 * @var Tx_MmForum_Domain_Model_User_FrontendUser
	 */
	protected $user = -1;


	/**
	 * TRUE to treat logged in backend users as administrators.
	 * @var bool
	 */
	protected $implicitAdministratorInBackend = TRUE;



	/**
	 * An identifier for all user groups the current user is a memver of.
	 * This identifier will be used as part of a cache identifier.
	 *
	 * @var string
	 */
	private $userGroupIdentifier = NULL;



	/*
	 * INITIALIZATION
	 */


	/**
	 * Constructor of this class.
	 *
	 * @param Tx_MmForum_Domain_Repository_User_FrontendUserRepository $frontendUserRepository A frontend user repository.
	 * @param Tx_MmForum_Cache_Cache                                   $cache                  An instance of the mm_forum cache.
	 */
	public function __construct(Tx_MmForum_Domain_Repository_User_FrontendUserRepository
	                            $frontendUserRepository, Tx_MmForum_Cache_Cache $cache) {
		$this->frontendUserRepository = $frontendUserRepository;
		$this->cache                  = $cache;
	}



	/**
	 * Disables the implicit treatment of logged in backend users as administrator
	 * users. This feature is necessary to make this class unittestable (probably bad
	 * practice, feel free to correct this...).
	 *
	 * @return void
	 */
	public function disableImplicitAdministrationInBackend() {
		$this->implicitAdministratorInBackend = FALSE;
	}



	/*
	 * AUTHENTICATION METHODS
	 */



	/**
	 * Asserts that the current user is authorized to read a specific object.
	 *
	 * @param  Tx_MmForum_Domain_Model_AccessibleInterface $object
	 *                             The object that is to be accessed.
	 *
	 * @return void
	 */
	public function assertReadAuthorization(Tx_MmForum_Domain_Model_AccessibleInterface $object) {
		$this->assertAuthorization($object, 'read');
	}



	/**
	 * Asserts that the current user is authorized to create a new topic in a
	 * certain forum.
	 *
	 * @param  Tx_MmForum_Domain_Model_Forum_Forum $forum
	 *                             The forum in which the new topic is to be created.
	 *
	 * @return void
	 */
	public function assertNewTopicAuthorization(Tx_MmForum_Domain_Model_Forum_Forum $forum) {
		$this->assertAuthorization($forum, 'newTopic');
	}



	/**
	 * Asserts that the current user is authorized to create a new post within a
	 * topic.
	 *
	 * @param  Tx_MmForum_Domain_Model_Forum_Topic $topic
	 *                             The topic in which the new post is to be created.
	 *
	 * @return void
	 */
	public function assertNewPostAuthorization(Tx_MmForum_Domain_Model_Forum_Topic $topic) {
		$this->assertAuthorization($topic, 'newPost');
	}



	/**
	 * Asserts that the current user is authorized to edit an existing post.
	 *
	 * @param  Tx_MmForum_Domain_Model_Forum_Post $post
	 *                             The post that shall be edited.
	 *
	 * @return void
	 */
	public function assertEditPostAuthorization(Tx_MmForum_Domain_Model_Forum_Post $post) {
		$this->assertAuthorization($post, 'editPost');
	}



	/**
	 * Asserts that the current user is authorized to delete a post.
	 *
	 * @param  Tx_MmForum_Domain_Model_Forum_Post $post
	 *                             The post that is to be deleted.
	 *
	 * @return void
	 */
	public function assertDeletePostAuthorization(Tx_MmForum_Domain_Model_Forum_Post $post) {
		$this->assertAuthorization($post, 'deletePost');
	}



	/**
	 * Asserts that the current user has moderator access to a certain forum.
	 *
	 * @param  Tx_MmForum_Domain_Model_AccessibleInterface $object
	 *                             The object that is to be moderated.
	 *
	 * @return void
	 */
	public function assertModerationAuthorization(Tx_MmForum_Domain_Model_AccessibleInterface $object) {
		$this->assertAuthorization($object, 'moderate');
	}



	/**
	 * Asserts that the current user has administrative access to a certain
	 * forum (note: administrative access is currently only possible from the
	 * backend module!).
	 *
	 * @param Tx_MmForum_Domain_Model_AccessibleInterface $object
	 *
	 * @return void
	 */
	public function assertAdministrationAuthorization(Tx_MmForum_Domain_Model_AccessibleInterface $object) {
		$this->assertAuthorization($object, 'administrate');
	}



	/**
	 * Asserts that the current user is authorized to perform a certain
	 * action on an potentially protected object.
	 *
	 * @param  Tx_MmForum_Domain_Model_AccessibleInterface $object
	 *                                                                  The object for which the access is to be
	 *                                                                  checked.
	 * @param  string                                      $action      The action for which the access check is
	 *                                                                  to be performed.
	 *
	 * @return void
	 * @throws Tx_MmForum_Domain_Exception_Authentication_NoAccessException
	 */
	public function assertAuthorization(Tx_MmForum_Domain_Model_AccessibleInterface $object, $action) {
		if ($this->checkAuthorization($object, $action) === FALSE) {
			throw new Tx_MmForum_Domain_Exception_Authentication_NoAccessException("You are not authorized to perform this action!", 1284709852);
		}
	}



	/**
	 * Checks whether the current user is authorized to perform a certain
	 * action on an object.
	 *
	 * @param  Tx_MmForum_Domain_Model_AccessibleInterface $object The object for which the access is to be checked.
	 * @param  string                                      $action The action for which the access check is to be
	 *                                                             performed.
	 *
	 * @return boolean             TRUE, when the user is authorized,
	 *                             otherwise FALSE.
	 */
	public function checkAuthorization(Tx_MmForum_Domain_Model_AccessibleInterface $object, $action) {
		// ACLs can be disabled for debugging. Also, in Backend mode, the ACL
		// mechanism does not work (no fe_users!).
		/** @noinspection PhpUndefinedConstantInspection */
		if ($this->settings['debug']['disableACLs'] || (TYPO3_MODE === 'BE' && $this->implicitAdministratorInBackend === TRUE)) {
			return TRUE;
		}

		$cacheIdentifier = $this->getCacheIdentifier($object, $action);
		if ($this->cache->has($cacheIdentifier)) {
			$value = $this->cache->get($cacheIdentifier);
		} else {
			$this->cache->set($cacheIdentifier, $value = $object->checkAccess($this->getUser(), $action));
		}
		return $value;
	}



	/**
	 * Gets the cache identifier to use for a specific user/object/action
	 * check.
	 * INTERNAL USE ONLY!
	 *
	 * @param  Tx_MmForum_Domain_Model_AccessibleInterface $object The object for which the access is to be checked.
	 * @param  string                                      $action The action for which the access check is to be
	 *                                                             performed.
	 *
	 * @return string              The cache identifier.
	 * @access private
	 */
	protected function getCacheIdentifier(Tx_MmForum_Domain_Model_AccessibleInterface $object, $action) {
		$className = array_pop(explode('_', get_class($object)));
		/** @noinspection PhpUndefinedMethodInspection */
		return 'acl-' . $className . '-' . $object->getUid() . '-' . $this->getUserGroupIdentifier() . '-' . $action;
	}



	/**
	 * Generates an identifier for all user groups the current user is a member of. This identifier can then be used
	 * as part of a cache identifier.
	 *
	 * @return string An identifier for all current user groups.
	 */
	protected function getUserGroupIdentifier() {
		if ($this->userGroupIdentifier === NULL) {
			$user = $this->getUser();
			if ($user === NULL) {
				$this->userGroupIdentifier = 'n';
			} else {
				$groupUids = array();
				foreach ($user->getUsergroup() as $group) {
					/** @var Tx_MmForum_Domain_Model_User_FrontendUserGroup $group */
					$groupUids[] = $group->getUid();
				}
				$this->userGroupIdentifier = implode('g', $groupUids);
			}
		}
		return $this->userGroupIdentifier;
	}



	protected function getUser() {
		if ($this->user === -1) {
			$this->user = $this->frontendUserRepository->findCurrent();
		}
		return $this->user;
	}



}
