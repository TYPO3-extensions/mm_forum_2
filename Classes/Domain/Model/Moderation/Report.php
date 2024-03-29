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
 * Models a post report. Reports are the central object of the moderation
 * component of the mm_forum extension. Each user can report a forum post
 * to the respective moderator group. In this case, a report object is
 * created.
 *
 * These report objects can be assigned to moderators ans be organized in
 * different workflow stages. Moderators can post comments to each report.
 *
 * @author     Martin Helmich <m.helmich@mittwald.de>
 * @package    MmForum
 * @subpackage Domain_Model_Moderation
 * @version    $Id$
 *
 * @copyright  2012 Martin Helmich <m.helmich@mittwald.de>
 *             Mittwald CM Service GmbH & Co. KG
 *             http://www.mittwald.de
 * @license    GNU Public License, version 2
 *             http://opensource.org/licenses/gpl-license.php
 *
 */
class Tx_MmForum_Domain_Model_Moderation_Report extends Tx_Extbase_DomainObject_AbstractEntity {



	/*
	 * ATTRIBUTES
	 */



	/**
	 * The reported post.
	 * @var Tx_MmForum_Domain_Model_Forum_Post
	 */
	protected $post;


	/**
	 * The frontend user that created this post.
	 * @var Tx_MmForum_Domain_Model_User_FrontendUser
	 */
	protected $reporter;


	/**
	 * The moderator that is assigned to this report.
	 * @var Tx_MmForum_Domain_Model_User_FrontendUser
	 */
	protected $moderator;


	/**
	 * The current status of this report.
	 * @var Tx_MmForum_Domain_Model_Moderation_ReportWorkflowStatus
	 */
	protected $workflowStatus;


	/**
	 * A set of comments that are assigned to this report.
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_MmForum_Domain_Model_Moderation_ReportComment>
	 */
	protected $comments;


	/**
	 * The creation timestamp of this report.
	 * @var DateTime
	 */
	protected $crdate;



	/*
	  * CONSTRUCTOR
	  */



	/**
	 * Creates a new report.
	 */
	public function __construct() {
		$this->comments = New Tx_Extbase_Persistence_ObjectStorage();
	}



	/*
	 * GETTERS
	 */



	/**
	 * Gets the reported post.
	 * @return Tx_MmForum_Domain_Model_Forum_Post The reported post.
	 */
	public function getPost() {
		return $this->post;
	}



	/**
	 * Gets the topic to which the reported post belongs to.
	 * @return Tx_MmForum_Domain_Model_Forum_Topic The topic.
	 */
	public function getTopic() {
		return $this->post->getTopic();
	}



	/**
	 * Gets the reporter of this report.
	 * @return Tx_MmForum_Domain_Model_User_FrontendUser The reporter
	 */
	public function getReporter() {
		return $this->reporter;
	}



	/**
	 * Gets the moderator that is assigned to this report.
	 * @return Tx_MmForum_Domain_Model_User_FrontendUser The moderator
	 */
	public function getModerator() {
		return $this->moderator;
	}



	/**
	 * Gets the current status of this report.
	 * @return Tx_MmForum_Domain_Model_Moderation_ReportWorkflowStatus
	 *                             The current workflow status of this report.
	 */
	public function getWorkflowStatus() {
		return $this->workflowStatus;
	}



	/**
	 * Gets all comments for this report.
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_MmForum_Domain_Model_Moderation_ReportComment>
	 *                             All comments for this report.
	 */
	public function getComments() {
		return $this->comments;
	}



	/**
	 * Returns the first comment for this report.
	 * @return Tx_MmForum_Domain_Model_Moderation_ReportComment The first comment.
	 */
	public function getFirstComment() {
		return array_shift($this->comments->toArray());
	}



	/**
	 * Returns the creation time of this report.
	 * @return DateTime The creation time.
	 */
	public function getCrdate() {
		return $this->crdate;
	}



	/*
	 * SETTERS
	 */



	/**
	 * Sets the post.
	 *
	 * @param  Tx_MmForum_Domain_Model_Forum_Post $post The post
	 * @return void
	 */
	public function setPost(Tx_MmForum_Domain_Model_Forum_Post $post) {
		$this->post = $post;
	}



	/**
	 * Sets the reporter.
	 *
	 * @param  Tx_MmForum_Domain_Model_User_FrontendUser $reporter The reporter.
	 * @return void
	 */
	public function setReporter(Tx_MmForum_Domain_Model_User_FrontendUser $reporter) {
		$this->reporter = $reporter;
	}



	/**
	 * Sets the moderator.
	 *
	 * @param  Tx_MmForum_Domain_Model_User_FrontendUser $moderator The moderator.
	 * @return void
	 */
	public function setModerator(Tx_MmForum_Domain_Model_User_FrontendUser $moderator) {
		$this->moderator = $moderator;
	}



	/**
	 * Sets the current workflow status.
	 *
	 * @param  Tx_MmForum_Domain_Model_Moderation_ReportWorkflowStatus $workflowStatus
	 *                             The workflow status.
	 * @return void
	 */
	public function setWorkflowStatus(Tx_MmForum_Domain_Model_Moderation_ReportWorkflowStatus $workflowStatus) {
		If (!$this->workflowStatus || ($this->workflowStatus && $this->workflowStatus->hasFollowupStatus($workflowStatus))) {
			$this->workflowStatus = $workflowStatus;
		}
	}



	/**
	 * Adds a comment to this report.
	 *
	 * @param  Tx_MmForum_Domain_Model_Moderation_ReportComment $comment A comment
	 * @return void
	 */
	public function addComment(Tx_MmForum_Domain_Model_Moderation_ReportComment $comment) {
		$comment->setReport($this);
		$this->comments->attach($comment);
	}



	/**
	 * Removes a comment from this report.
	 *
	 * @param  Tx_MmForum_Domain_Model_Moderation_ReportComment $comment A comment.
	 * @return void
	 */
	public function removeComment(Tx_MmForum_Domain_Model_Moderation_ReportComment $comment) {
		if (count($this->comments) === 1) {
			throw new Tx_MmForum_Domain_Exception_InvalidOperationException('You cannot delete the last remaining comment!', 1334687977);
		}
		$this->comments->detach($comment);
	}



}
