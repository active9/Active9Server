<?php
// Active9 Server (http://www.active9.com/server)
// Copyright 2012-214 Active9 LLC
// LICENSE: GPL V3

class mimes {
	private $mime_list;

	function __construct() {
		$this->mime_list = array(
			'aif'			=> 'audio/x-aiff',
			'aiff'			=> 'audio/x-aiff',
			'avi'			=> 'video/avi',
			'apk'			=> 'application/vnd.android.package-archive',
			'bmp'			=> 'image/bmp',
			'bz2'			=> 'application/x-bz2',
			'css'			=> 'text/css',
			'csv'			=> 'text/csv',
                        'dae'                   => 'text/xml',
			'dmg'			=> 'application/x-apple-diskimage',
			'doc'			=> 'application/msword',
			'docx'			=> 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
			'eml'			=> 'message/rfc822',
			'aps'			=> 'application/postscript',
			'exe'			=> 'application/x-ms-dos-executable',
			'flv'			=> 'video/x-flv',
			'fs'			=> 'x-shader/x-fragment',
			'gif'			=> 'image/gif',
			'gz' 			=> 'application/x-gzip',
			'hqx'			=> 'application/stuffit',
			'htm'			=> 'text/html',
			'html'			=> 'text/html',
			'jar'			=> 'application/x-java-archive',
			'jpeg'			=> 'image/jpeg',
			'jpg'			=> 'image/jpeg',
			'js'			=> 'application/javascript',
			'json'			=> 'application/json',
			'm3u'			=> 'audio/x-mpegurl',
			'm4a'			=> 'audio/mp4',
			'mdb'			=> 'application/x-msaccess',
			'mid'			=> 'audio/midi',
			'midi'			=> 'audio/midi',
			'mov'			=> 'video/quicktime',
			'mp3'			=> 'audio/mpeg',
			'mp4'			=> 'video/mp4',
			'mpeg'			=> 'video/mpeg',
			'mpg'			=> 'video/mpeg',
			'odg'			=> 'vnd.oasis.opendocument.graphics',
			'odp'			=> 'vnd.oasis.opendocument.presentation',
			'odt'			=> 'vnd.oasis.opendocument.text',
			'ods'			=> 'vnd.oasis.opendocument.spreadsheet',
			'ogg'			=> 'audio/ogg',
			'pdf'			=> 'application/pdf',
			'png'			=> 'image/png',
			'ppt'			=> 'application/vnd.ms-powerpoint',
			'pptx'			=> 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
			'ps'			=> 'application/postscript',
			'rar'			=> 'application/x-rar-compressed',
			'rtf'			=> 'application/rtf',
			'tar'			=> 'application/x-tar',
			'sit'			=> 'application/x-stuffit',
			'svg'			=> 'image/svg+xml',
			'swf'			=> 'application/x-shockwave-flash',
			'tif'			=> 'image/tiff',
			'tiff'			=> 'image/tiff',
			'ttf'			=> 'application/x-font-truetype',
			'txt'			=> 'text/plain',
			'vcf'			=> 'text/x-vcard',
			'vs'			=> 'x-shader/x-vertex',
			'wav'			=> 'audio/wav',
			'wma'			=> 'audio/x-ms-wma',
			'wmv'			=> 'audio/x-ms-wmv',
			'xls'			=> 'application/excel',
			'xlsx'			=> 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
			'xml'			=> 'application/xml-dtd',
			'zip'			=> 'application/zip'
		);
	}

	function listmimes() {
		return $this->mime_list;
	}

}





?>
