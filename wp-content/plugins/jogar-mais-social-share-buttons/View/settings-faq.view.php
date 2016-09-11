<?php
/**
 *
 * @package Social Share Buttons
 * @author  Victor Freitas
 * @subpackage View Admin Page
 * @version 1.4.0
 */

namespace JM\Share_Buttons;

if ( ! function_exists( 'add_action' ) )
	exit(0);

class Settings_Faq_View
{
	/**
	 * Display page setting
	 *
	 * @since 1.3
	 * @param Null
	 * @return Void Display page
	 */
	public static function render_page_faq()
	{
		$prefix           = Setting::PREFIX;
		$use_options_file = dirname( __FILE__ ) . '/use-options.php';
	?>
		<div class="wrap">
			<h2><?php _e( 'Social Share Buttons', App::TEXTDOMAIN ); ?></h2>
			<p class="description"><?php _e( 'Add the Share Buttons automatically.', App::TEXTDOMAIN ); ?></p>
			<span class="<?php echo "{$prefix}-title"; ?>">
				<?php _e( 'Use options', App::TEXTDOMAIN ); ?>
			</span>
			<div class="<?php echo "{$prefix}-wrap-faq"; ?>">
				<code>
					<span style="color: #000000">
						<span style="color: #FF8000">Via&nbsp;shortcode:<br>&nbsp;<span style="color: #333333">[SSB_SHARE&nbsp;class_first=""&nbsp;class_second=""&nbsp;class_link=""&nbsp;class_icon=""&nbsp;layout="default"&nbsp;remove_inside="0"&nbsp;remove_counter="0"]</span><br><br>Via&nbsp;PHP&nbsp;Using&nbsp;function&nbsp;WordPress<br>&nbsp;</span>
						<span style="color: #007700">echo</span>
						<span style="color: #0000BB">do_shortcode(</span>
						<span style="color: #DD0000">'[SSB_SHARE&nbsp;class_first=""&nbsp;class_second=""&nbsp;class_link=""&nbsp;class_icon=""&nbsp;layout="default"&nbsp;remove_inside="0"&nbsp;remove_counter="0"]'</span>
						<span style="color: #007700">);<br><br></span>
						<span style="color: #FF8000">Returns&nbsp;all&nbsp;the&nbsp;buttons&nbsp;and&nbsp;the&nbsp;use&nbsp;of&nbsp;classes&nbsp;is&nbsp;optional<br><br>Via&nbsp;method&nbsp;PHP:<br></span>
						<span style="color: #007700">use</span>
						<span style="color: #0000BB">JM\Share_Buttons\Shares_View;</span>
						<span style="color: #007700"><br><br></span>
						<span style="color: #0000BB">$args</span>
						<span style="color: #007700">=&nbsp;array(<br>&nbsp;&nbsp;&nbsp;&nbsp;</span>
						<span style="color: #DD0000">'class_first'&nbsp;</span>
						<span style="color: #007700">=&gt;</span>
						<span style="color: #DD0000">''</span><span style="color: #007700">,</span>
						<span style="color: #007700"><br>&nbsp;&nbsp;&nbsp;&nbsp;</span>
						<span style="color: #DD0000">'class_second'</span>
						<span style="color: #007700">=&gt;</span>
						<span style="color: #DD0000">''</span><span style="color: #007700">,<br>&nbsp;&nbsp;&nbsp;&nbsp;</span>
						<span style="color: #DD0000">'class_link'&nbsp;&nbsp;</span>
						<span style="color: #007700">=&gt;</span>
						<span style="color: #DD0000">''</span><span style="color: #007700">,<br>&nbsp;&nbsp;&nbsp;&nbsp;</span>
						<span style="color: #DD0000">'class_icon'&nbsp;&nbsp;</span>
						<span style="color: #007700">=&gt;</span>
						<span style="color: #DD0000">''</span><span style="color: #007700">,<br>&nbsp;&nbsp;&nbsp;&nbsp;</span>
						<span style="color: #DD0000">'layout'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
						<span style="color: #007700">=&gt;&nbsp;</span><span style="color: #DD0000">'default'</span><span style="color: #007700">,<br>&nbsp;&nbsp;&nbsp;&nbsp;</span>
						<span style="color: #DD0000">'elements'&nbsp;&nbsp;&nbsp;&nbsp;</span>
						<span style="color: #007700">=&gt;&nbsp;array(<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
						<span style="color: #DD0000">'remove_inside'&nbsp;</span>
						<span style="color: #007700">=&gt;&nbsp;</span>
						<span style="color: #0000BB">false</span><span style="color: #007700">,<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
						<span style="color: #DD0000">'remove_counter'</span>
						<span style="color: #007700">=&gt;&nbsp;</span>
						<span style="color: #0000BB">false</span><span style="color: #007700">,<br>&nbsp;&nbsp;&nbsp;&nbsp;),<br>);<br><br>if&nbsp;(&nbsp;</span>
						<span style="color: #0000BB">class_exists</span><span style="color: #007700">(</span>
						<span style="color: #DD0000">'JM\Share_Buttons\Shares_View'</span>
						<span style="color: #007700">)&nbsp;)&nbsp;:<br>&nbsp;&nbsp;&nbsp;&nbsp;echo&nbsp;</span>
						<span style="color: #0000BB">Shares_View</span><span style="color: #007700">::</span><span style="color: #0000BB">buttons_share</span><span style="color: #007700">(</span>
						<span style="color: #0000BB">$args</span>
						<span style="color: #007700">);<br>endif;<br><br></span>
						<span style="color: #FF8000">$args&nbsp;&nbsp;&nbsp;(Array)&nbsp;(optional)<br>Layout&nbsp;options:&nbsp;default,&nbsp;buttons,&nbsp;rounded,&nbsp;square<br></span>
					</span>
				</code>
			</div>
		</div>
	<?php
	}
}