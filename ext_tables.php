<?php

if (!defined('TYPO3_MODE'))
	die('Access denied.');

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY, 'Pi1', 'mm_forum'
);

$extPath = t3lib_extMgm::extPath($_EXTKEY);

if (TYPO3_MODE === 'BE')
{
	t3lib_extMgm::registerExtDirectComponent(
		'MmForum.ForumIndex.DataProvider',
		$extPath . 'Classes/ExtDirect/ForumDataProvider.php:Tx_MmForum_ExtDirect_ForumDataProvider',
		'web', 'user,group'
	);


	Tx_Extbase_Utility_Extension::registerModule(
		$_EXTKEY, 'web', 'tx_mmforum_m1', '', array('Backend' => 'indexForum', 'Forum' => 'update'),
		array(
		'access' => 'user,group',
		'icon' => 'EXT:' . $_EXTKEY . '/ext_icon.gif',
		'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_mod.xml',
		'navigationComponentId' => 'typo3-pagetree',
		)
	);
}

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'mm_forum');

$pluginSignature = strtolower(t3lib_div::underscoredToUpperCamelCase($_EXTKEY)) . '_pi1';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue($pluginSignature,
	'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/Pi1.xml');


t3lib_extMgm::addLLrefForTCAdescr('tx_mmforum_domain_model_forum_forum',
	'EXT:mm_forum/Resources/Private/Language/locallang_csh_tx_mmforum_domain_model_forum_forum.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_mmforum_domain_model_forum_forum');
$TCA['tx_mmforum_domain_model_forum_forum'] = array(
	'ctrl' => array(
		'title' => 'LLL:EXT:mm_forum/Resources/Private/Language/locallang_db.xml:tx_mmforum_domain_model_forum_forum',
		'label' => 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l18n_parent',
		'transOrigDiffSourceField' => 'l18n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden'
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Forum/Forum.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/Forum/Forum.png'
	)
);

t3lib_extMgm::addLLrefForTCAdescr('tx_mmforum_domain_model_forum_topic',
	'EXT:mm_forum/Resources/Private/Language/locallang_csh_tx_mmforum_domain_model_forum_topic.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_mmforum_domain_model_forum_topic');
$TCA['tx_mmforum_domain_model_forum_topic'] = array(
	'ctrl' => array(
		'title' => 'LLL:EXT:mm_forum/Resources/Private/Language/locallang_db.xml:tx_mmforum_domain_model_forum_topic',
		'type' => 'type',
		'label' => 'subject',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l18n_parent',
		'transOrigDiffSourceField' => 'l18n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden'
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Forum/Topic.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/Forum/Topic.png'
	)
);

t3lib_extMgm::addLLrefForTCAdescr('tx_mmforum_domain_model_forum_post',
	'EXT:mm_forum/Resources/Private/Language/locallang_csh_tx_mmforum_domain_model_forum_post.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_mmforum_domain_model_forum_post');
$TCA['tx_mmforum_domain_model_forum_post'] = array(
	'ctrl' => array(
		'title' => 'LLL:EXT:mm_forum/Resources/Private/Language/locallang_db.xml:tx_mmforum_domain_model_forum_post',
		'label' => 'text',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l18n_parent',
		'transOrigDiffSourceField' => 'l18n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden'
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Forum/Post.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/Forum/Post.png'
	)
);

t3lib_extMgm::addLLrefForTCAdescr('tx_mmforum_domain_model_format_textparser',
	'EXT:mm_forum/Resources/Private/Language/locallang_csh_tx_mmforum_domain_model_format_textparser.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_mmforum_domain_model_format_textparser');
$TCA['tx_mmforum_domain_model_format_textparser'] = array(
	'ctrl' => array(
		'title' => 'LLL:EXT:mm_forum/Resources/Private/Language/locallang_db.xml:tx_mmforum_domain_model_format_textparser',
		'label' => 'name',
		'type' => 'type',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l18n_parent',
		'transOrigDiffSourceField' => 'l18n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden'
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Format/Textparser.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/Format/Textparser.png'
	)
);

$tempColumns = array(
	'crdate' => array(
		'exclude' => 1,
		'config' => array('type' => 'passthrough')
	),
	'tx_mmforum_post_count' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:mm_forum/Resources/Private/Language/locallang_db.xml:fe_users.tx_mmforum_post_count',
		'config' => array('type' => 'none'),
	),
	'tx_mmforum_topic_subscriptions' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:mm_forum/Resources/Private/Language/locallang_db.xml:fe_users.tx_mmforum_topic_subscriptions',
		'config' => array(
			'type' => 'select',
			'foreign_table' => 'tx_mmforum_domain_model_forum_topic',
			'MM' => 'tx_mmforum_domain_model_user_topicsubscription',
			'multiple' => TRUE,
			'maxitems' => 9999,
			'minitems' => 0
		)
	),
	'tx_mmforum_forum_subscriptions' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:mm_forum/Resources/Private/Language/locallang_db.xml:fe_users.tx_mmforum_forum_subscriptions',
		'config' => array(
			'type' => 'select',
			'foreign_table' => 'tx_mmforum_domain_model_forum_forum',
			'MM' => 'tx_mmforum_domain_model_user_forumsubscription',
			'multiple' => TRUE,
			'maxitems' => 9999,
			'minitems' => 0
		)
	),
	'tx_mmforum_signature' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:mm_forum/Resources/Private/Language/locallang_db.xml:fe_users.tx_mmforum_signature',
		'config' => array(
			'type' => 'text'
		)
	),
	'tx_mmforum_userfield_values' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:mm_forum/Resources/Private/Language/locallang_db.xml:fe_users.tx_mmforum_userfield_values',
		'config' => array(
			'type' => 'inline',
			'foreign_table' => 'tx_mmforum_domain_model_user_userfield_value',
			'foreign_field' => 'user',
			'maxitems' => 9999,
			'appearance' => array(
				'collapse' => 0,
				'newRecordLinkPosition' => 'bottom',
			),
		)
	),
	'tx_mmforum_read_topics' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:mm_forum/Resources/Private/Language/locallang_db.xml:fe_users.tx_mmforum_read_topics',
		'config' => array(
			'type' => 'select',
			'foreign_table' => 'tx_mmforum_domain_model_forum_topic',
			'MM' => 'tx_mmforum_domain_model_user_readtopic',
			'multiple' => TRUE,
			'minitems' => 0
		)
	),
	'tx_mmforum_use_gravatar' => array(
		'exclude' => 0,
		'label' => 'LLL:EXT:mm_forum/Resources/Private/Language/locallang_db.xml:fe_users.use_gravatar',
		'config' => array(
			'type' => 'check'
		)
	),
	'tx_mmforum_contact' => array(
		'exclude' => 0,
		'label' => 'LLL:EXT:mm_forum/Resources/Private/Language/locallang_db.xml:fe_users.contact',
		'config' => array(
			'type' => 'display'
		)
	),
);

t3lib_div::loadTCA('fe_users');
t3lib_extMgm::addTCAcolumns('fe_users', $tempColumns, 1);
$TCA['fe_users']['types']['Tx_MmForum_Domain_Model_User_FrontendUser'] = $TCA['fe_users']['types']['0'];
$TCA['fe_users']['types']['Tx_MmForum_Domain_Model_User_FrontendUser']['showitem'] .=
	',--div--;LLL:EXT:mm_forum/Resources/Private/Language/locallang_db.xml:fe_users.tx_mmforum.tab.settings,'
	. ' tx_mmforum_post_count, tx_mmforum_topic_subscriptions, tx_mmforum_forum_subscriptions,'
	. ' tx_mmforum_signature, tx_mmforum_userfield_values, tx_mmforum_use_gravatar, tx_mmforum_contact';
t3lib_extMgm::addTcaSelectItem('fe_users', 'tx_extbase_type',
	array('LLL:EXT:mm_forum/Resources/Private/Language/locallang_db.xml:fe_users.tx_extbase_type.mm_forum', 'Tx_MmForum_Domain_Model_User_FrontendUser'));


t3lib_extMgm::addLLrefForTCAdescr('tx_mmforum_domain_model_forum_access',
	'EXT:mm_forum/Resources/Private/Language/locallang_csh_tx_mmforum_domain_model_forum_access.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_mmforum_domain_model_forum_access');
$TCA['tx_mmforum_domain_model_forum_access'] = array(
	'ctrl' => array(
		'title' => 'LLL:EXT:mm_forum/Resources/Private/Language/locallang_db.xml:tx_mmforum_domain_model_forum_access',
		'label' => 'operation',
		'type' => 'login_level',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l18n_parent',
		'transOrigDiffSourceField' => 'l18n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden'
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Forum/Access.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/Forum/Access.png'
	)
);

t3lib_extMgm::addLLrefForTCAdescr('tx_mmforum_domain_model_user_userfield_userfield',
	'EXT:mm_forum/Resources/Private/Language/locallang_csh_tx_mmforum_domain_model_user_userfield_userfield.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_mmforum_domain_model_user_userfield_userfield');
$TCA['tx_mmforum_domain_model_user_userfield_userfield'] = array(
	'ctrl' => array(
		'title' => 'LLL:EXT:mm_forum/Resources/Private/Language/locallang_db.xml:tx_mmforum_domain_model_user_userfield_userfield',
		'label' => 'name',
		'type' => 'type',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l18n_parent',
		'transOrigDiffSourceField' => 'l18n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden'
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/User/Userfield/Userfield.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/User/Userfield/Userfield.png'
	)
);

t3lib_extMgm::addLLrefForTCAdescr('tx_mmforum_domain_model_user_userfield_value',
	'EXT:mm_forum/Resources/Private/Language/locallang_csh_tx_mmforum_domain_model_user_userfield_value.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_mmforum_domain_model_user_userfield_value');
$TCA['tx_mmforum_domain_model_user_userfield_value'] = array(
	'ctrl' => array(
		'title' => 'LLL:EXT:mm_forum/Resources/Private/Language/locallang_db.xml:tx_mmforum_domain_model_user_userfield_value',
		'label' => 'uid',
		'type' => 'user',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l18n_parent',
		'transOrigDiffSourceField' => 'l18n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden'
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/User/Userfield/Value.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/User/Userfield/Value.png'
	)
);

t3lib_extMgm::addLLrefForTCAdescr('tx_mmforum_domain_model_forum_attachment',
	'EXT:mm_forum/Resources/Private/Language/locallang_csh_tx_mmforum_domain_model_forum_attachment.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_mmforum_domain_model_forum_attachment');
$TCA['tx_mmforum_domain_model_forum_attachment'] = array(
	'ctrl' => array(
		'title' => 'LLL:EXT:mm_forum/Resources/Private/Language/locallang_db.xml:tx_mmforum_domain_model_forum_attachment',
		'label' => 'name',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'delete' => 'deleted',
		'enablecolumns' => array('disabled' => 'hidden'),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Forum/Attachment.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/Forum/Attachment.png'
	)
);

#t3lib_extMgm::addLLrefForTCAdescr('tx_mmforum_domain_model_forum_forum','EXT:mm_forum/Resources/Private/Language/locallang_csh_tx_mmforum_domain_model_forum_forum.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_mmforum_domain_model_moderation_report');
$TCA['tx_mmforum_domain_model_moderation_report'] = array(
	'ctrl' => array(
		'title' => 'LLL:EXT:mm_forum/Resources/Private/Language/locallang_db.xml:tx_mmforum_domain_model_moderation_report',
		'label' => 'post',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden'
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Moderation/Report.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/Moderation/Report.png'
	)
);

t3lib_extMgm::allowTableOnStandardPages('tx_mmforum_domain_model_moderation_reportcomment');
$TCA['tx_mmforum_domain_model_moderation_reportcomment'] = array(
	'ctrl' => array(
		'title' => 'LLL:EXT:mm_forum/Resources/Private/Language/locallang_db.xml:tx_mmforum_domain_model_moderation_reportcomment',
		'label' => 'text',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden'
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Moderation/ReportComment.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/Moderation/ReportComment.png'
	)
);

t3lib_extMgm::allowTableOnStandardPages('tx_mmforum_domain_model_moderation_reportworkflowstatus');
$TCA['tx_mmforum_domain_model_moderation_reportworkflowstatus'] = array(
	'ctrl' => array(
		'title' => 'LLL:EXT:mm_forum/Resources/Private/Language/locallang_db.xml:tx_mmforum_domain_model_moderation_reportworkflowstatus',
		'label' => 'name',
		'type' => 'login_level',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l18n_parent',
		'transOrigDiffSourceField' => 'l18n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden'
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Moderation/ReportWorkflowStatus.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/Moderation/ReportWorkflowStatus.png'
	)
);
?>