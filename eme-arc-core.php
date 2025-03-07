<?php
/*
 * Plugin Name: EME ARC Suite - Core
 * Description: Core functionality for integrating callsign and custom fields with Events Made Easy forms and data.
 * Version: 1.7.4
 * Author: W9MDM
 * License: GPL2
 */

if (!defined('ABSPATH')) {
    exit; // Prevent direct access
}

// Define the core version constant
define('EME_ARC_CORE_VERSION', '1.7.4'); // Matches the plugin version

// Namespace import for Plugin Update Checker (must be at the top of the file)
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

/**
 * Add callsign field to person edit form.
 */
function eme_arc_person_edit_form($person) {
    $answers = eme_get_person_answers($person['person_id']);
    $callsign = '';
    foreach ($answers as $answer) {
        if ($answer['field_id'] == 2) {
            $callsign = esc_attr($answer['answer']);
            break;
        }
    }
    ?>
    <div class="eme_form_row">
        <label for="callsign"><?php esc_html_e('Callsign', 'events-made-easy'); ?></label>
        <input type="text" name="callsign" id="callsign" value="<?php echo $callsign; ?>" maxlength="10" />
        <small><?php esc_html_e('Format: e.g., W9MDM (1-2 letters, 1 number, 1-3 letters)', 'events-made-easy'); ?></small>
    </div>
    <?php
}
add_action('eme_person_edit_form', 'eme_arc_person_edit_form');

/**
 * Add callsign field to member edit form.
 */
function eme_arc_member_edit_form($member) {
    $answers = eme_get_person_answers($member['person_id']);
    $callsign = '';
    foreach ($answers as $answer) {
        if ($answer['field_id'] == 2) {
            $callsign = esc_attr($answer['answer']);
            break;
        }
    }
    ?>
    <div class="eme_form_row">
        <label for="callsign"><?php esc_html_e('Member Callsign', 'events-made-easy'); ?></label>
        <input type="text" name="callsign" id="callsign" value="<?php echo $callsign; ?>" maxlength="10" />
        <small><?php esc_html_e('Format: e.g., W9MDM (1-2 letters, 1 number, 1-3 letters)', 'events-made-easy'); ?></small>
    </div>
    <?php
}
add_action('eme_member_edit_form', 'eme_arc_member_edit_form');

/**
 * Validate and save callsign for people (answer_2, field_id = 2).
 */
function eme_arc_save_person_callsign($result, $person_id) {
    global $wpdb;
    $message = $result[0];

    if (isset($_POST['callsign'])) {
        $callsign = trim(eme_sanitize_request($_POST['callsign']));
        if (empty($callsign)) {
            $message .= esc_html__('Callsign cannot be empty.', 'events-made-easy') . '<br>';
        } elseif (!preg_match('/^[A-Za-z]{1,2}[0-9][A-Za-z]{1,3}$/', $callsign)) {
            $message .= esc_html__('Invalid callsign format. Use 1-2 letters, 1 number, 1-3 letters (e.g., W9MDM).', 'events-made-easy') . '<br>';
        } else {
            $callsign = strtoupper($callsign);
            if (!$person_id) {
                $person_id = eme_db_insert_person([]);
            }
            if ($person_id) {
                $existing_answer = $wpdb->get_row(
                    $wpdb->prepare(
                        "SELECT * FROM {$wpdb->prefix}eme_answers WHERE related_id = %d AND type = 'person' AND field_id = 2",
                        $person_id
                    ),
                    ARRAY_A
                );
                if ($existing_answer) {
                    $wpdb->update(
                        "{$wpdb->prefix}eme_answers",
                        ['answer' => $callsign],
                        ['answer_id' => $existing_answer['answer_id']],
                        ['%s'],
                        ['%d']
                    );
                } else {
                    $wpdb->insert(
                        "{$wpdb->prefix}eme_answers",
                        [
                            'related_id' => $person_id,
                            'type' => 'person',
                            'field_id' => 2,
                            'answer' => $callsign
                        ],
                        ['%d', '%s', '%d', '%s']
                    );
                }
            } else {
                $message .= esc_html__('Failed to save callsign.', 'events-made-easy') . '<br>';
                error_log("Failed to save callsign for person_id $person_id: " . $wpdb->last_error);
            }
        }
    }
    return [$message, $person_id];
}
add_filter('eme_add_update_person_from_backend', 'eme_arc_save_person_callsign', 10, 2);

/**
 * Validate and save callsign for members (answer_2, field_id = 2).
 */
function eme_arc_save_member_callsign($result, $member_id) {
    global $wpdb;
    $message = $result[0];

    if (isset($_POST['callsign'])) {
        $callsign = trim(eme_sanitize_request($_POST['callsign']));
        if (empty($callsign)) {
            $message .= esc_html__('Callsign cannot be empty.', 'events-made-easy') . '<br>';
        } elseif (!preg_match('/^[A-Za-z]{1,2}[0-9][A-Za-z]{1,3}$/', $callsign)) {
            $message .= esc_html__('Invalid callsign format. Use 1-2 letters, 1 number, 1-3 letters (e.g., W9MDM).', 'events-made-easy') . '<br>';
        } else {
            $callsign = strtoupper($callsign);
            if ($member_id) {
                $member = eme_get_member($member_id);
                $person_id = $member['person_id'];
                $existing_answer = $wpdb->get_row(
                    $wpdb->prepare(
                        "SELECT * FROM {$wpdb->prefix}eme_answers WHERE related_id = %d AND type = 'person' AND field_id = 2",
                        $person_id
                    ),
                    ARRAY_A
                );
                if ($existing_answer) {
                    $wpdb->update(
                        "{$wpdb->prefix}eme_answers",
                        ['answer' => $callsign],
                        ['answer_id' => $existing_answer['answer_id']],
                        ['%s'],
                        ['%d']
                    );
                } else {
                    $wpdb->insert(
                        "{$wpdb->prefix}eme_answers",
                        [
                            'related_id' => $person_id,
                            'type' => 'person',
                            'field_id' => 2,
                            'answer' => $callsign
                        ],
                        ['%d', '%s', '%d', '%s']
                    );
                }
            } else {
                $message .= esc_html__('Member ID missing for callsign save.', 'events-made-easy') . '<br>';
                error_log("Member ID missing for callsign save: $member_id");
            }
        }
    }
    return [$message, $member_id];
}
add_filter('eme_add_update_member', 'eme_arc_save_member_callsign', 10, 2);

/**
 * Replace callsign placeholder for people (field_id = 2).
 */
function eme_arc_people_callsign_placeholder($format, $person, $target, $lang, $do_shortcode) {
    if (preg_match('/#_CALLSIGN/', $format)) {
        $answers = eme_get_person_answers($person['person_id']);
        $callsign = '';
        foreach ($answers as $answer) {
            if ($answer['field_id'] == 2) {
                $callsign = trim(strtoupper($answer['answer']));
                break;
            }
        }
        $replacement = empty($callsign) ? 'N/A' : ($target === 'html' ? eme_esc_html($callsign) : $callsign);
        $format = str_replace('#_CALLSIGN', $replacement, $format);
    }
    return $format;
}
add_filter('eme_replace_people_placeholders', 'eme_arc_people_callsign_placeholder', 10, 5);

/**
 * Replace callsign placeholder for members (field_id = 2).
 */
function eme_arc_members_callsign_placeholder($format, $member, $target, $lang, $do_shortcode) {
    if (preg_match('/#_MEMBERCALLSIGN/', $format)) {
        $answers = eme_get_person_answers($member['person_id']);
        $callsign = '';
        foreach ($answers as $answer) {
            if ($answer['field_id'] == 2) {
                $callsign = trim(strtoupper($answer['answer']));
                break;
            }
        }
        $replacement = empty($callsign) ? 'N/A' : ($target === 'html' ? eme_esc_html($callsign) : $callsign);
        $format = str_replace('#_MEMBERCALLSIGN', $replacement, $format);
    }
    return $format;
}
add_filter('eme_replace_members_placeholders', 'eme_arc_members_callsign_placeholder', 10, 5);

/**
 * Check for Events Made Easy dependency with corrected function names.
 */
function eme_arc_core_check_eme() {
    if (!function_exists('eme_get_person') || !function_exists('eme_db_insert_person') || !function_exists('eme_db_update_person') || !function_exists('eme_get_person_answers')) {
        deactivate_plugins(plugin_basename(__FILE__));
        wp_die(__('This plugin requires Events Made Easy (EME) with full functionality to be active. Missing functions detected.', 'events-made-easy'));
    }
}
add_action('plugins_loaded', 'eme_arc_core_check_eme');

// Include the Plugin Update Checker library (local copy only, per README recommendation)
$checker_path = dirname(__FILE__) . '/plugin-update-checker/plugin-update-checker.php';

if (file_exists($checker_path)) {
    require_once $checker_path;
    
    // Initialize the update checker for GitHub integration (per README)
    $updateChecker = PucFactory::buildUpdateChecker(
        'https://github.com/W9MDM/eme-arc-suite-core/', // GitHub repo URL, trailing slash per README
        __FILE__, // Full path to the main plugin file, per README
        'eme-arc-suite-core' // Unique plugin slug, per README
    );
    
    // Set the branch to check (default is 'main', per README)
    $updateChecker->setBranch('main');
    
    // Enable GitHub Releases for stable updates (per README)
    $updateChecker->getVcsApi()->enableReleaseAssets();
}