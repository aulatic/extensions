<?php
class HighlightJS {

	/**
	 * Called when the extension is first loaded
	 */
	public static function onRegistration() {
		global $wgExtensionFunctions;
		$wgExtensionFunctions[] = __CLASS__ . '::setup';
		Hooks::register( 'ParserFirstCallInit', __CLASS__ . '::onParserFirstCallInit' );
	}

	public static function setup() {
		global $wgOut, $wgResourceModules, $wgExtensionAssetsPath, $IP, $wgAutoloadClasses, $wgHighlightJsPath, $wgHighlightJsStyle;

		// This gets the remote path even if it's a symlink (MW1.25+)
		$path = $wgExtensionAssetsPath . str_replace( "$IP/extensions", '', dirname( $wgAutoloadClasses[__CLASS__] ) );
		$wgResourceModules['ext.highlightjs']['remoteExtPath'] = $path;
		$wgOut->addModules( 'ext.highlightjs' );

		// Use the Organic Design highlight style if none of highlightjs's styles specified
		$css = $wgHighlightJsStyle ? "highlight/styles/$wgHighlightJsStyle.css" : 'highlight.css';
		$wgOut->addStyle( "$path/$css" );
	}

	/**
	 * Register the new tag function
	 */
	public static function onParserFirstCallInit( Parser $parser ) {
		global $wgHighlightJsMagic;
		$parser->setHook( $wgHighlightJsMagic, __CLASS__ . '::expandTag' );
		return true;
	}

	/**
	 * Expand the new tag
	 */
	public static function expandTag( $input, array $args, Parser $parser, PPFrame $frame ) {
		global $wgJsMimeType;
		if( !array_key_exists( 'lang', $args ) ) $args['lang'] = 'nohighlight';
		$class = ' class="' . $args['lang'] . ' todo"';
		$script = "<script type=\"$wgJsMimeType\">if('hljsGo' in window) window.hljsGo();</script>";
		return "<pre><code$class>" . htmlspecialchars( trim( $input ) ) . "</code></pre>$script";
	}
}
