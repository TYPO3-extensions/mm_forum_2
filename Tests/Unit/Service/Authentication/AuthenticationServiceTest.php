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


class Tx_MmForum_Service_Authentication_AuthenticationServiceTest extends Tx_Extbase_Tests_Unit_BaseTestCase {



	/**
	 * @var Tx_MmForum_Service_Authentication_AuthenticationService
	 */
	protected $fixture;


	/**
	 * @var Tx_MmForum_Domain_Model_User_FrontendUser
	 */
	protected $user;


	/**
	 * @var Tx_MmForum_Domain_Model_User_FrontendUserGroup
	 */
	protected $group;


	/**
	 * @var Tx_MmForum_Domain_Model_Forum_Forum
	 */
	protected $forum;


	/**
	 * @var PHPUnit_Framework_MockObject_MockObject
	 */
	protected $userRepositoryMock;



	public function setUp() {
		$this->group = new Tx_MmForum_Domain_Model_User_FrontendUserGroup('Users');
		$this->user = new Tx_MmForum_Domain_Model_User_FrontendUser('martin', 'secret');
		$this->user->addUsergroup($this->group);
		$this->forum = $this->objectManager->create('Tx_MmForum_Domain_Model_Forum_Forum', 'Forum', NULL);

		$this->userRepositoryMock = $this->getMock('Tx_MmForum_Domain_Repository_User_FrontendUserRepository');
		$this->userRepositoryMock
			->expects($this->any())
			->method('findCurrent')
			->will($this->returnValue($this->user));

		$cacheMock = $this->getMock('Tx_MmForum_Cache_Cache');
		$cacheMock
			->expects($this->any())
			->method('has')
			->will($this->returnValue(FALSE));

		/** @noinspection PhpParamsInspection */
		$this->fixture = new Tx_MmForum_Service_Authentication_AuthenticationService($this->userRepositoryMock, $cacheMock);
		$this->fixture->disableImplicitAdministrationInBackend();
	}



	/**
	 * @test
	 * @dataProvider getPossibleOperations
	 * @param $operation
	 */
	public function authorizationIsGrantedOnAccessForLoggedInUser($operation) {
		$acl = new Tx_MmForum_Domain_Model_Forum_Access($operation, Tx_MmForum_Domain_Model_Forum_Access::LOGIN_LEVEL_SPECIFIC, $this->group);
		$this->forum->addAcl($acl);

		$this->assertTrue($this->fixture->checkAuthorization($this->forum, $operation));
	}



	/**
	 * @test
	 * @dataProvider getPossibleOperations
	 * @param $operation
	 */
	public function authorizationIsDeniedOnUndefinedAccessForLoggedInUser($operation) {
		$this->assertFalse($this->fixture->checkAuthorization($this->forum, $operation));
	}



	/**
	 * @test
	 * @dataProvider getPossibleOperations
	 * @param $operation
	 */
	public function authorizationIsDeniedOnAccessForAnonymousUser($operation) {
		$this->userRepositoryMock
			->expects($this->any())
			->method('findCurrent')
			->will($this->returnValue(NULL));
		$this->assertFalse($this->fixture->checkAuthorization($this->forum, $operation));
	}



	/**
	 * @test
	 * @dataProvider getPossibleOperations
	 * @param $operation
	 */
	public function authorizationIsDeniedOnDeniedAccessForLoggedInUser($operation) {
		$acl = new Tx_MmForum_Domain_Model_Forum_Access($operation, Tx_MmForum_Domain_Model_Forum_Access::LOGIN_LEVEL_SPECIFIC, $this->group);
		$acl->setNegated(TRUE);
		$this->forum->addAcl($acl);

		$this->assertFalse($this->fixture->checkAuthorization($this->forum, $operation));
	}



	/**
	 * @test
	 */
	public function readAuthorizationIsGrantedOnUndefinedAccessForLoggedInUser() {
		$this->assertTrue($this->fixture->checkAuthorization($this->forum, 'read'));
	}



	/**
	 * @test
	 */
	public function readAuthorizationIsGrantedOnUndefinedAccessForAnonymousUser() {
		$this->userRepositoryMock
			->expects($this->any())
			->method('findCurrent')
			->will($this->returnValue(NULL));
		$this->assertTrue($this->fixture->checkAuthorization($this->forum, 'read'));
	}



	/**
	 * @test
	 * @dataProvider      getPossibleOperations
	 * @param string $operation
	 * @expectedException Tx_MmForum_Domain_Exception_Authentication_NoAccessException
	 */
	public function exceptionIsThrownOnFailedAccessAssertion($operation) {
		$this->fixture->assertAuthorization($this->forum, $operation);
	}



	public function getPossibleOperations() {
		return array(
			array('newPost'),
			array('newTopic'),
			array('moderate'),
			array('administrate')
		);
	}

}
