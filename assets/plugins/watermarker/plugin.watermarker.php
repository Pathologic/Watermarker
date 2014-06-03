<?php
$e = &$modx->Event;
if ($e->name == 'OnFileBrowserUpload' || $e->name == 'OnFileManagerUpload') {
	$configFolder = MODX_BASE_PATH.'assets/plugins/watermarker/config/';
	if (empty($config) || !file_exists($configFolder.$config.'.inc.php')) {
		$modx->logEvent(0, 3, 'Configuration file not found', 'Watermarker');
		return;
	}
	$path = $filepath . '/' . $filename;
	$path_parts = pathinfo($path);
	if (in_array($path_parts['extension'],explode(',',$modx->config['upload_images']))) {
		if (!class_exists('phpthumb')) include_once(MODX_BASE_PATH.'assets/snippets/phpthumb/phpthumb.class.php');
		$size = getimagesize($path);
		$w = $size[0]; //image width
        $h = $size[1]; //image height
        include_once($configFolder.$config.'.inc.php');
        foreach ($config as $cfg) {
        	if (strpos($filepath,$cfg['source'])) {
        		foreach ($cfg['processing'] as $processing) {
        			$phpThumb = new phpthumb();
        			$options = strtr($processing['options'], Array("," => "&", "_" => "=", '{' => '[', '}' => ']'));
					parse_str($options, $params);
					$params['f'] = $path_parts['extension'];
					foreach ($params as $key => $value) {
	  					$phpThumb->setParameter($key, $value);
					}
  					$phpThumb->setSourceFilename($path);
					if ($phpThumb->GenerateThumbnail()) {
						if (empty($processing['folder'])) {
							$phpThumb->RenderToFile($path);
						}
						else {
							$folder = $filepath.'/'.$processing['folder'];
							if(!is_dir($folder)) mkdir($folder);
							$phpThumb->RenderToFile($folder.'/'.$filename);	
						}
					}
					else {
						$modx->logEvent(0, 3, implode('<br/>', $phpThumb->debugmessages), 'phpthumb');
					}
        		}
        	}
        }
	}
};