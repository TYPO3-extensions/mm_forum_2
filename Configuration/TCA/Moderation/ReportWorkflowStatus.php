<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_mmforum_domain_model_moderation_reportworkflowstatus'] = array(
	'ctrl' => $TCA['tx_mmforum_domain_model_moderation_reportworkflowstatus']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'name,icon,followup_status,initial,final'
	),
	'types' => array(
		'1' => array('showitem' => 'name,icon,followup_status,initial,final')
	),
	'palettes' => array(
		'1' => array('showitem' => '')
	),
	'columns' => array(
		'hidden' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array(
				'type' => 'check'
			)
		),
		'crdate' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.crdate',
			'config'  => array(
				'type' => 'passthrough'
			)
		),
		'name' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:mm_forum/Resources/Private/Language/locallang_db.xml:tx_mmforum_domain_model_moderation_reportworkflowstatus.name',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			)
		),
		'followup_status' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:mm_forum/Resources/Private/Language/locallang_db.xml:tx_mmforum_domain_model_moderation_reportworkflowstatus.followup_status',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_mmforum_domain_model_moderation_reportworkflowstatus',
				'MM' => 'tx_mmforum_domain_model_moderation_reportworkflowstatus_followup',
				'maxitems' => 9999,
				'size' => 5
			)
		),
		'initial' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:mm_forum/Resources/Private/Language/locallang_db.xml:tx_mmforum_domain_model_moderation_reportworkflowstatus.initial',
			'config'  => array(
				'type' => 'check'
			)
		),
		'final' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:mm_forum/Resources/Private/Language/locallang_db.xml:tx_mmforum_domain_model_moderation_reportworkflowstatus.final',
			'config'  => array(
				'type' => 'check'
			)
		),
		'icon' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:mm_forum/Resources/Private/Language/locallang_db.xml:tx_mmforum_domain_model_moderation_reportworkflowstatus.icon',
			'config'  => array(
				'type' => 'group',
				'internal_type' => 'file',
				'uploadfolder' => 'uploads/tx_mmforum/workflowstatus/',
				'minitems' => 1,
				'maxitems' => 1,
				'allowed' => '*',
				'disallowed' => ''
			)
		)
	),
);
?>