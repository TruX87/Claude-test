<?php
/**
 * Contact/enquiry form: shortcode + submission handler.
 *
 * Deliberately not a page-builder-style "Form" custom block: the form
 * must include a fresh nonce on every page view, and a block's save()
 * output is frozen into post_content the moment an editor saves the
 * page — a nonce baked in then would be expired well before a real
 * visitor ever loads the page. A shortcode re-renders its output on
 * every request, so the nonce (and honeypot) are always current. This
 * is the one place in the theme that intentionally isn't a block, for
 * that reason.
 *
 * @package Oja_Talu
 */

defined( 'ABSPATH' ) || exit;

/**
 * Render the [oja_contact_form] shortcode.
 *
 * @return string Form markup, plus a success/error notice if the page
 *                was just redirected back here after a submission.
 */
function oja_talu_contact_form_shortcode(): string {
	ob_start();

	$oja_status = isset( $_GET['oja_contact'] ) ? sanitize_key( wp_unslash( $_GET['oja_contact'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- read-only status flag, not a state change.

	if ( 'sent' === $oja_status ) {
		echo '<p class="oja-form-notice oja-form-notice--success">' . esc_html__( 'Aitäh! Vastame teile peagi.', 'oja-talu' ) . '</p>';
	} elseif ( 'error' === $oja_status ) {
		echo '<p class="oja-form-notice oja-form-notice--error">' . esc_html__( 'Midagi läks valesti — palun proovi uuesti või kirjuta otse e-postile.', 'oja-talu' ) . '</p>';
	}
	?>
	<form class="oja-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
		<input type="hidden" name="action" value="oja_talu_contact" />
		<?php wp_nonce_field( 'oja_talu_contact', 'oja_talu_contact_nonce' ); ?>

		<div class="oja-form__field oja-form__field--honeypot" aria-hidden="true">
			<label for="oja_contact_company">Company</label>
			<input type="text" id="oja_contact_company" name="oja_contact_company" tabindex="-1" autocomplete="off" />
		</div>

		<div class="oja-form__field">
			<label for="oja_contact_name"><?php esc_html_e( 'Nimi', 'oja-talu' ); ?></label>
			<input type="text" id="oja_contact_name" name="oja_contact_name" required />
		</div>

		<div class="oja-form__field">
			<label for="oja_contact_email"><?php esc_html_e( 'E-post', 'oja-talu' ); ?></label>
			<input type="email" id="oja_contact_email" name="oja_contact_email" required />
		</div>

		<div class="oja-form__field">
			<label for="oja_contact_message"><?php esc_html_e( 'Sõnum', 'oja-talu' ); ?></label>
			<textarea id="oja_contact_message" name="oja_contact_message" rows="5" required></textarea>
		</div>

		<button type="submit" class="oja-form__submit"><?php esc_html_e( 'Saada', 'oja-talu' ); ?></button>
	</form>
	<?php
	return (string) ob_get_clean();
}
add_shortcode( 'oja_contact_form', 'oja_talu_contact_form_shortcode' );

/**
 * Handle the contact form submission (both logged-in and anonymous).
 *
 * Verifies the nonce and honeypot, does minimal sanitisation, rate-limits
 * by IP+minute via a transient, sends the enquiry to the site admin
 * email, and redirects back to the referring page with a status flag —
 * never leaves the visitor on a bare admin-post.php response.
 */
function oja_talu_handle_contact_submission(): void {
	$oja_redirect_base = wp_get_referer() ? wp_get_referer() : home_url( '/' );

	if (
		! isset( $_POST['oja_talu_contact_nonce'] ) ||
		! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['oja_talu_contact_nonce'] ) ), 'oja_talu_contact' )
	) {
		wp_safe_redirect( add_query_arg( 'oja_contact', 'error', $oja_redirect_base ) );
		exit;
	}

	// Honeypot: a real visitor never fills in a visually-hidden field.
	if ( ! empty( $_POST['oja_contact_company'] ) ) {
		wp_safe_redirect( add_query_arg( 'oja_contact', 'sent', $oja_redirect_base ) ); // Silently "succeed" for bots.
		exit;
	}

	// Rate-limit: max one submission per IP per 60 seconds.
	$oja_ip_key = 'oja_contact_rl_' . md5( (string) ( $_SERVER['REMOTE_ADDR'] ?? '' ) );
	if ( get_transient( $oja_ip_key ) ) {
		wp_safe_redirect( add_query_arg( 'oja_contact', 'error', $oja_redirect_base ) );
		exit;
	}
	set_transient( $oja_ip_key, 1, MINUTE_IN_SECONDS );

	$oja_name    = isset( $_POST['oja_contact_name'] ) ? sanitize_text_field( wp_unslash( $_POST['oja_contact_name'] ) ) : '';
	$oja_email   = isset( $_POST['oja_contact_email'] ) ? sanitize_email( wp_unslash( $_POST['oja_contact_email'] ) ) : '';
	$oja_message = isset( $_POST['oja_contact_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['oja_contact_message'] ) ) : '';

	if ( ! $oja_name || ! is_email( $oja_email ) || ! $oja_message ) {
		wp_safe_redirect( add_query_arg( 'oja_contact', 'error', $oja_redirect_base ) );
		exit;
	}

	$oja_sent = wp_mail(
		get_option( 'admin_email' ),
		sprintf( '[Oja Talu] %s', __( 'Uus sõnum kodulehelt', 'oja-talu' ) ),
		sprintf( "Nimi: %s\nE-post: %s\n\n%s", $oja_name, $oja_email, $oja_message ),
		array( 'Reply-To: ' . $oja_name . ' <' . $oja_email . '>' )
	);

	wp_safe_redirect( add_query_arg( 'oja_contact', $oja_sent ? 'sent' : 'error', $oja_redirect_base ) );
	exit;
}
add_action( 'admin_post_oja_talu_contact', 'oja_talu_handle_contact_submission' );
add_action( 'admin_post_nopriv_oja_talu_contact', 'oja_talu_handle_contact_submission' );
