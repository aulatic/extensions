<?php
if ( !defined( 'MEDIAWIKI' ) ) die( 'Not an entry point.' );
/**
 * jQueryUpload MediaWiki extension - allows files to be uploaded to the wiki or to specific pages using the jQueryFileUpload module
 *
 * jQueryFileUpload module: https://github.com/blueimp/jQuery-File-Upload
 *
 * @package MediaWiki
 * @subpackage Extensions
 * @author Aran Dunkley (http://www.organicdesign.co.nz/nad)
 */
define( 'JQU_VERSION', "0.0.1, 2012-09-24" );

$wgAjaxExportList[] = 'jQueryUpload::server';

$wgSpecialPages['jQueryUpload'] = 'jQueryUpload';
$wgSpecialPageGroups['jQueryUpload'] = 'media';
$wgExtensionCredits['specialpage'][] = array(
	'path'           => __FILE__,
	'name'           => "jQueryUpload",
	'descriptionmsg' => "jqueryupload-desc",
	'url'            => "http://www.organicdesign.co.nz/jQueryUpload",
	'author'         => "[http://www.organicdesign.co.nz/nad Aran Dunkley]",
	'version'        => JQU_VERSION
);

// If the query-string arg mwaction is supplied, rename action and change mwaction to action
// - this hack was required because the jQueryUpload module uses the name "action" too
if( array_key_exists( 'mwaction', $_REQUEST ) ) {
	$wgJQUploadAction = array_key_exists( 'action', $_REQUEST ) ? $_REQUEST['action'] : false;
	$_REQUEST['action'] = $_GET['action'] = $_POST['action'] = $_REQUEST['mwaction'];
}

$dir = dirname(__FILE__);
$wgExtensionMessagesFiles['jQueryUpload'] = "$dir/jQueryUpload.i18n.php";
$wgExtensionMessagesFiles['jQueryUploadAlias'] = "$dir/jQueryUpload.alias.php";
require( "$dir/upload/server/php/upload.class.php" );
require( "$dir/jQueryUpload_body.php" );