<?php
/* Places old MODX logo absolutely positioned in bottom right corner with 10px margins. Nothing to do with images smaller than 160x120 */
$config = array();

if ($w > 160 && $h > 120)
$config[] = array(
	'source' => 'assets/images',
	'processing' => array(
		array(
			'options' => '&fltr=wmi|/assets/plugins/watermarker/logo.png|'.($w-70).'x'.($h-55).'|30|',
			'folder' => ''
		)
	)
);