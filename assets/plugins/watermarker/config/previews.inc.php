<?php
/* Creates 150x150px cropped previews (normal and gray) and saves them to subfolders */
$config = array();
$config[] = array(
	'source' => 'assets/images',
	'processing' => array(
		array(
			'options' => 'w=150&h=150&zc=1',
			'folder' => '150x150'
		),
		array(
			'options' => 'w=150&h=150&zc=1&fltr=gray',
			'folder' => '150x150gray'
		)
	)
);