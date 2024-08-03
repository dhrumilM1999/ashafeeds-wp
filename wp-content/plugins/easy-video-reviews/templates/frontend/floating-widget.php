<?php
/**
 * Easy Video Reviews - Frontend floating widget Modal
 * Frontend Modal
 *
 * @package EasyVideoReviews
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit( 1 );
$evr_settings = $this->option()->get_all();
$floating_widget_enable = $evr_settings['enable_floating_widget_review'];
$floating_widget_settings = $evr_settings['floating_widgets_settings'];

if ( ! isset( $evr_settings['enable_floating_widget_review'] ) || '1' !== $floating_widget_enable ) {
	return;
}

// manage translation
$translation       = new \EasyVideoReviews\Translation();
$evr_floating_text = ! empty($evr_settings['translations']) ? $evr_settings['translations'] ['floating-widget-text'] : $translation->get_all()['floating-widget-text'];


$review_settings = $this->option()->get('review_option');
$this->set_review_state($review_settings);
$current_page_id = (string) get_the_ID();

if ( 'show-on-hover' === $floating_widget_settings['cta_behavaiour'] ) {
    $clas_name = 'group-hover:right-[125%] group-hover:opacity-[1] group-hover:visible invisible opacity-[0]';
} elseif ( 'show-all-the-time' === $floating_widget_settings['cta_behavaiour'] ) {
    $clas_name = 'visible opacity-[1]';
} elseif ( 'hide-after-first-click' === $floating_widget_settings['cta_behavaiour'] ) {
    $clas_name = 'visible opacity-[1]';
} elseif ( 'never-show' === $floating_widget_settings['cta_behavaiour'] ) {
    $clas_name = 'invisible opacity-[0]';
}

if ( is_array($floating_widget_settings['widget_show_on']) ) {
    if ( in_array('desktop', $floating_widget_settings['widget_show_on']) && in_array('mobile', $floating_widget_settings['widget_show_on']) ) {
        $resposive_class = 'sm:block';
    } elseif ( in_array('desktop', $floating_widget_settings['widget_show_on']) ) {
        $resposive_class = 'hidden sm:block';
    } elseif ( in_array('mobile', $floating_widget_settings['widget_show_on']) ) {
        $resposive_class = 'sm:hidden';
    } else {
        $resposive_class = 'sm:block';
    }
} else {
    $resposive_class = 'sm:block';
}

$you_tube_url_pattern = '/\bwww\.youtube\.com\b/';
$you_tube_short_pattern = '/\byoutu\.be\b/';

if ( $you_tube_url_pattern ) {
    $pattern = '/(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/';
} elseif ( $you_tube_short_pattern ) {
    $pattern = '/(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/';
} else {
    $pattern = '';
}

if ( isset($pattern) && ! empty($pattern) ) {
    preg_match($pattern, $floating_widget_settings['icon_background_video_url'], $matches);

    if ( isset($matches[1]) ) {
        $yt_video_id = $matches[1];
    } else {
        $yt_video_id = 'invalid url';
    }
}

?>
<!-- recorder modal -->
<?php if ( ! in_array($current_page_id, $floating_widget_settings['exclude_widgets_pages']) ) : ?>
    <div class="evr-floating-widget <?php echo esc_attr($resposive_class); ?> fixed bottom-[46px] z-[99] evr-floating-<?php echo esc_attr($floating_widget_settings['widget_position']); ?> evr-floating-mobile-<?php echo esc_attr($floating_widget_settings['widget_mobile_position']); ?>">
        <div class="floating-button ml-auto relative group inline-flex items-center relative">
            <div class="floating-cta-text floating-hover-text z-[99] absolute transition-all flex items-center justify-center py-1 px-[15px] min-w-[170px] min-h-[41px] bg-white rounded-[33px] text-center text-black text-sm font-normal after:content-[''] after:absolute after:block after:h-[19px] after:w-[19px] after:transform after:rotate-45 <?php echo esc_attr($clas_name); ?>">
                <div class="text relative z-[2]">
                    <?php echo esc_html($floating_widget_settings['cta_text']); ?>
                </div>
            </div>
            <?php if ( 'static' === $floating_widget_settings['widget_icon_background_type'] ) : ?>
                <button class="flex items-center justify-center ml-auto mt-auto rounded-full w-[66px] h-[66px] <?php echo esc_attr($floating_widget_settings['widget_animation_effect']); ?>">
                    <?php if ( 'svg' === $floating_widget_settings['selected_floating_icon_data']['type'] ) : ?>
                        <?php echo $this->io()->sanitize($floating_widget_settings['selected_floating_icon_data']['icon']); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    <?php else : ?>
                        <img class="h-[30px] w-[auto] <?php echo esc_attr($floating_widget_settings['widget_animation_effect']); ?>" src=" <?php echo esc_url( $floating_widget_settings['selected_floating_icon_data']['icon'] ); ?> " alt="floating-icon">
                    <?php endif; ?>
                </button>
            <?php endif; ?>
            <?php if ( 'video' === $floating_widget_settings['widget_icon_background_type'] ) : ?>
                <!-- video play button -->
                <button id="floating-widget-button" class="flex items-center relative justify-center overflow-hidden ml-auto mt-auto rounded-full w-[66px] h-[66px] <?php echo esc_attr($floating_widget_settings['widget_animation_effect']); ?>">
                    <?php if ( preg_match($you_tube_url_pattern, $floating_widget_settings['icon_background_video_url']) || preg_match($you_tube_short_pattern, $floating_widget_settings['icon_background_video_url']) ) : ?>
                        <iframe class="h-[120px] w-[300px] max-w-[300px] absolute top-[50%] left-[50%] -translate-y-[50%] -translate-x-[50%] pointer-events-none" src="https://www.youtube.com/embed/<?php echo esc_attr($yt_video_id); ?>?playlist=<?php echo esc_attr($yt_video_id); ?>&controls=0&showinfo=0&rel=0&autoplay=1&loop=1&mute=1&iv_load_policy=3" frameborder="0" allowfullscreen></iframe>
                    <?php else : ?>
                        <video class="video h-full w-full object-cover" preload="auto" poster="<?php echo esc_url('https://evrstaging.wppool.dev/evr-icon/EVR%20Poster.png'); ?>" autoplay muted loop>
                            <source src="<?php echo esc_url($floating_widget_settings['icon_background_video_url']); ?>" type="video/mp4" />
                            <source src="<?php echo esc_url($floating_widget_settings['icon_background_video_url']); ?>" type="video/ogg">
                        </video>
                    <?php endif; ?>
                </button>
            <?php endif; ?>
        </div>
        <?php if ( 'static' === $floating_widget_settings['widget_icon_background_type'] ) : ?>
            <div class="evr-floating-widget__card flex flex-col min-h-[380px] px-5 py-6 sm:min-h-[561px] transition-all invisible opacity-[0] absolute z-[99] bottom-[-100%] bg-[#fff] sm:w-[462px] shadow-lg rounded-[10px]">
                <div class="flex justify-end">
                    <span class="evr-floating-close cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 17 17" fill="none">
                            <path d="M8.5 8.5L16 16M1 16L8.5 8.5L1 16ZM16 1L8.49857 8.5L16 1ZM8.49857 8.5L1 1L8.49857 8.5Z" stroke="#575757" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </span>
                </div>
                <div class="mx-auto my-auto">
                    <div class="text-center text-stone-900 text-base font-bold font-['Segoe UI'] leading-normal mb-[20px]"><?php echo esc_html($evr_floating_text[0]); ?></div>
                    <div class="text-center text-stone-900 text-base font-normal font-['Segoe UI'] leading-normal"><?php echo esc_html($evr_floating_text[1]); ?></div>
                        <?php if ( $this->only_video || $this->text_review_optional ) : ?>
                            <div class="flex justify-center my-[20px] lg:my-[30px] gap-[10px] lg:gap-[15px]">
                                <div id="only-video-review-button" class="cursor-pointer w-[150px] h-[150px] p-[15px] bg-blue-600 rounded-[15px] border border-zinc-200 justify-center flex-col items-center inline-flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="87" height="67" viewBox="0 0 87 35" fill="none">
                                        <g filter="url(#filter0_d_1715_4041)">
                                            <path d="M38.6691 38.3349C38.8345 38.1661 39.0318 38.032 39.2496 37.9403C39.4673 37.8485 39.7011 37.801 39.9374 37.8005H47.0624C47.2987 37.801 47.5325 37.8485 47.7502 37.9403C47.9679 38.032 48.1652 38.1661 48.3306 38.3349C48.9541 38.9654 49.72 39.5711 50.4788 40.1019C51.3377 40.6977 52.2324 41.2402 53.1578 41.7264L53.1934 41.7478H53.2041C53.5647 41.9264 53.8541 42.2219 54.0253 42.5861C54.1964 42.9503 54.2392 43.3617 54.1467 43.7534C54.0542 44.145 53.8318 44.4937 53.5157 44.7428C53.1996 44.9919 52.8085 45.1266 52.4061 45.125H34.5936C34.1925 45.125 33.8032 44.9896 33.4886 44.7407C33.174 44.4919 32.9527 44.1441 32.8603 43.7538C32.768 43.3634 32.8101 42.9534 32.9799 42.5899C33.1496 42.2265 33.437 41.931 33.7956 41.7513L33.8028 41.7478L33.8384 41.7264C34.0972 41.5975 34.3515 41.4596 34.6008 41.3131C35.2577 40.9368 35.8983 40.5326 36.5209 40.1019C37.2833 39.5675 38.0457 38.9654 38.6691 38.3349ZM39.9374 21.9688C39.9374 21.0239 40.3127 20.1178 40.9808 19.4497C41.6489 18.7816 42.555 18.4062 43.4999 18.4062C44.4447 18.4062 45.3509 18.7816 46.0189 19.4497C46.687 20.1178 47.0624 21.0239 47.0624 21.9688C47.0624 22.9136 46.687 23.8197 46.0189 24.4878C45.3509 25.1559 44.4447 25.5313 43.4999 25.5313C42.555 25.5313 41.6489 25.1559 40.9808 24.4878C40.3127 23.8197 39.9374 22.9136 39.9374 21.9688Z" fill="white"/>
                                            <path d="M22.125 9.5C20.2353 9.5 18.4231 10.2507 17.0869 11.5869C15.7507 12.9231 15 14.7353 15 16.625L15 27.3125C15 29.2022 15.7507 31.0144 17.0869 32.3506C18.4231 33.6868 20.2353 34.4375 22.125 34.4375H64.875C66.7647 34.4375 68.5769 33.6868 69.9131 32.3506C71.2493 31.0144 72 29.2022 72 27.3125V16.625C72 14.7353 71.2493 12.9231 69.9131 11.5869C68.5769 10.2507 66.7647 9.5 64.875 9.5H22.125ZM43.5 14.8438C45.3897 14.8438 47.2019 15.5944 48.5381 16.9306C49.8743 18.2668 50.625 20.0791 50.625 21.9688C50.625 23.8584 49.8743 25.6707 48.5381 27.0069C47.2019 28.3431 45.3897 29.0938 43.5 29.0938C41.6103 29.0938 39.7981 28.3431 38.4619 27.0069C37.1257 25.6707 36.375 23.8584 36.375 21.9688C36.375 20.0791 37.1257 18.2668 38.4619 16.9306C39.7981 15.5944 41.6103 14.8438 43.5 14.8438ZM59.5312 23.75C59.0588 23.75 58.6058 23.5623 58.2717 23.2283C57.9377 22.8942 57.75 22.4412 57.75 21.9688C57.75 21.4963 57.9377 21.0433 58.2717 20.7092C58.6058 20.3752 59.0588 20.1875 59.5312 20.1875C60.0037 20.1875 60.4567 20.3752 60.7908 20.7092C61.1248 21.0433 61.3125 21.4963 61.3125 21.9688C61.3125 22.4412 61.1248 22.8942 60.7908 23.2283C60.4567 23.5623 60.0037 23.75 59.5312 23.75Z" fill="url(#paint0_linear_1715_4041)"/>
                                        </g>
                                        <circle cx="60" cy="22" r="2.5" fill="#FF3838" stroke="white"/>
                                        <defs>
                                            <filter id="filter0_d_1715_4041" x="9.53674e-07" y="0.500001" width="87" height="65.625" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                            <feOffset dy="6"/>
                                            <feGaussianBlur stdDeviation="7.5"/>
                                            <feComposite in2="hardAlpha" operator="out"/>
                                            <feColorMatrix type="matrix" values="0 0 0 0 0.120694 0 0 0 0 0.217895 0 0 0 0 0.658333 0 0 0 1 0"/>
                                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1715_4041"/>
                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1715_4041" result="shape"/>
                                            </filter>
                                            <linearGradient id="paint0_linear_1715_4041" x1="15" y1="5.51" x2="99.36" y2="43.13" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#C7F2FA"/>
                                            <stop offset="1" stop-color="#DAE0E2"/>
                                            </linearGradient>
                                        </defs>
                                    </svg>
                                    <div class="text-center text-white text-base font-bold font-['Segoe UI'] leading-normal mt-[10px]"><?php echo esc_html($evr_floating_text[2]); ?></div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if ( $this->only_text ) : ?>
                            <div class="flex justify-center my-[20px] lg:my-[30px] gap-[10px] lg:gap-[15px]">
                                <div id="only-text-review-button" class="cursor-pointer w-[150px] h-[150px] p-[15px] bg-[#7357F2] rounded-[15px] border border-zinc-200 justify-center flex-col items-center inline-flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="59" height="29" viewBox="0 0 59 29" fill="none">
                                        <path d="M0 4.83333C0 2.175 2.655 0 5.9 0H53.1C54.6648 0 56.1655 0.509225 57.2719 1.41565C58.3784 2.32208 59 3.55145 59 4.83333V24.1667C59 25.4485 58.3784 26.6779 57.2719 27.5843C56.1655 28.4908 54.6648 29 53.1 29H5.9C4.33522 29 2.83453 28.4908 1.72807 27.5843C0.621605 26.6779 0 25.4485 0 24.1667V4.83333ZM6.9 4.83333C6.34772 4.83333 5.9 5.28105 5.9 5.83333V8.66667C5.9 9.21895 6.34772 9.66667 6.9 9.66667H10.8C11.3523 9.66667 11.8 9.21895 11.8 8.66667V5.83333C11.8 5.28105 11.3523 4.83333 10.8 4.83333H6.9ZM9.85 12.0833C9.29772 12.0833 8.85 12.531 8.85 13.0833V15.9167C8.85 16.469 9.29772 16.9167 9.85 16.9167H13.75C14.3023 16.9167 14.75 16.469 14.75 15.9167V13.0833C14.75 12.531 14.3023 12.0833 13.75 12.0833H9.85ZM6.9 19.3333C6.34772 19.3333 5.9 19.781 5.9 20.3333V23.1667C5.9 23.719 6.34772 24.1667 6.9 24.1667H10.8C11.3523 24.1667 11.8 23.719 11.8 23.1667V20.3333C11.8 19.781 11.3523 19.3333 10.8 19.3333H6.9ZM15.75 19.3333C15.1977 19.3333 14.75 19.781 14.75 20.3333V23.1667C14.75 23.719 15.1977 24.1667 15.75 24.1667H43.25C43.8023 24.1667 44.25 23.719 44.25 23.1667V20.3333C44.25 19.781 43.8023 19.3333 43.25 19.3333H15.75ZM48.2 19.3333C47.6477 19.3333 47.2 19.781 47.2 20.3333V23.1667C47.2 23.719 47.6477 24.1667 48.2 24.1667H52.1C52.6523 24.1667 53.1 23.719 53.1 23.1667V20.3333C53.1 19.781 52.6523 19.3333 52.1 19.3333H48.2ZM18.7 12.0833C18.1477 12.0833 17.7 12.531 17.7 13.0833V15.9167C17.7 16.469 18.1477 16.9167 18.7 16.9167H22.6C23.1523 16.9167 23.6 16.469 23.6 15.9167V13.0833C23.6 12.531 23.1523 12.0833 22.6 12.0833H18.7ZM27.55 12.0833C26.9977 12.0833 26.55 12.531 26.55 13.0833V15.9167C26.55 16.469 26.9977 16.9167 27.55 16.9167H31.45C32.0023 16.9167 32.45 16.469 32.45 15.9167V13.0833C32.45 12.531 32.0023 12.0833 31.45 12.0833H27.55ZM36.4 12.0833C35.8477 12.0833 35.4 12.531 35.4 13.0833V15.9167C35.4 16.469 35.8477 16.9167 36.4 16.9167H40.3C40.8523 16.9167 41.3 16.469 41.3 15.9167V13.0833C41.3 12.531 40.8523 12.0833 40.3 12.0833H36.4ZM45.25 12.0833C44.6977 12.0833 44.25 12.531 44.25 13.0833V15.9167C44.25 16.469 44.6977 16.9167 45.25 16.9167H49.15C49.7023 16.9167 50.15 16.469 50.15 15.9167V13.0833C50.15 12.531 49.7023 12.0833 49.15 12.0833H45.25ZM15.75 4.83333C15.1977 4.83333 14.75 5.28105 14.75 5.83333V8.66667C14.75 9.21895 15.1977 9.66667 15.75 9.66667H19.65C20.2023 9.66667 20.65 9.21895 20.65 8.66667V5.83333C20.65 5.28105 20.2023 4.83333 19.65 4.83333H15.75ZM24.6 4.83333C24.0477 4.83333 23.6 5.28105 23.6 5.83333V8.66667C23.6 9.21895 24.0477 9.66667 24.6 9.66667H28.5C29.0523 9.66667 29.5 9.21895 29.5 8.66667V5.83333C29.5 5.28105 29.0523 4.83333 28.5 4.83333H24.6ZM33.45 4.83333C32.8977 4.83333 32.45 5.28105 32.45 5.83333V8.66667C32.45 9.21895 32.8977 9.66667 33.45 9.66667H37.35C37.9023 9.66667 38.35 9.21895 38.35 8.66667V5.83333C38.35 5.28105 37.9023 4.83333 37.35 4.83333H33.45ZM42.3 4.83333C41.7477 4.83333 41.3 5.28105 41.3 5.83333V8.66667C41.3 9.21895 41.7477 9.66667 42.3 9.66667H52.1C52.6523 9.66667 53.1 9.21895 53.1 8.66667V5.83333C53.1 5.28105 52.6523 4.83333 52.1 4.83333H42.3Z" fill="url(#paint0_linear)"/>
                                        <defs>
                                        <linearGradient id="paint0_linear" x1="29.5" y1="0" x2="29.5" y2="29" gradientUnits="userSpaceOnUse">
                                        <stop stop-color="#9BC6ED"/>
                                        <stop offset="1" stop-color="#4E9DE6"/>
                                        </linearGradient>
                                        </defs>
                                    </svg>
                                    <div class="text-center text-white text-base font-bold font-['Segoe UI'] leading-normal mt-[10px]"><?php echo esc_html($evr_floating_text[3]); ?></div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if ( $this->choose_option ) : ?>
                            <div class="flex justify-center my-[20px] lg:my-[30px] gap-[10px] lg:gap-[15px]">
                                <div id="choose-video-review-button" class="cursor-pointer w-[150px] h-[150px] p-[15px] bg-blue-600 rounded-[15px] border border-zinc-200 justify-center flex-col items-center inline-flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="88" height="66" viewBox="0 0 88 66" fill="none">
                                        <g filter="url(#filter0_d_2880_1004)">
                                            <path d="M39.1691 37.8349C39.3345 37.6661 39.5318 37.532 39.7496 37.4403C39.9673 37.3485 40.2011 37.301 40.4374 37.3005H47.5624C47.7987 37.301 48.0325 37.3485 48.2502 37.4403C48.4679 37.532 48.6652 37.6661 48.8306 37.8349C49.4541 38.4654 50.22 39.0711 50.9788 39.6019C51.8377 40.1977 52.7324 40.7402 53.6578 41.2264L53.6934 41.2478H53.7041C54.0647 41.4264 54.3541 41.7219 54.5253 42.0861C54.6964 42.4503 54.7392 42.8617 54.6467 43.2534C54.5542 43.645 54.3318 43.9937 54.0157 44.2428C53.6996 44.4919 53.3085 44.6266 52.9061 44.625H35.0936C34.6925 44.625 34.3032 44.4896 33.9886 44.2407C33.674 43.9919 33.4527 43.6441 33.3603 43.2538C33.268 42.8634 33.3101 42.4534 33.4799 42.0899C33.6496 41.7265 33.937 41.431 34.2956 41.2513L34.3028 41.2478L34.3384 41.2264C34.5972 41.0975 34.8515 40.9596 35.1008 40.8131C35.7577 40.4368 36.3983 40.0326 37.0209 39.6019C37.7833 39.0675 38.5457 38.4654 39.1691 37.8349ZM40.4374 21.4688C40.4374 20.5239 40.8127 19.6178 41.4808 18.9497C42.1489 18.2816 43.055 17.9062 43.9999 17.9062C44.9447 17.9062 45.8509 18.2816 46.5189 18.9497C47.187 19.6178 47.5624 20.5239 47.5624 21.4688C47.5624 22.4136 47.187 23.3197 46.5189 23.9878C45.8509 24.6559 44.9447 25.0313 43.9999 25.0313C43.055 25.0313 42.1489 24.6559 41.4808 23.9878C40.8127 23.3197 40.4374 22.4136 40.4374 21.4688Z" fill="white"/>
                                            <path d="M22.625 9C20.7353 9 18.9231 9.75067 17.5869 11.0869C16.2507 12.4231 15.5 14.2353 15.5 16.125L15.5 26.8125C15.5 28.7022 16.2507 30.5144 17.5869 31.8506C18.9231 33.1868 20.7353 33.9375 22.625 33.9375H65.375C67.2647 33.9375 69.0769 33.1868 70.4131 31.8506C71.7493 30.5144 72.5 28.7022 72.5 26.8125V16.125C72.5 14.2353 71.7493 12.4231 70.4131 11.0869C69.0769 9.75067 67.2647 9 65.375 9H22.625ZM44 14.3438C45.8897 14.3438 47.7019 15.0944 49.0381 16.4306C50.3743 17.7668 51.125 19.5791 51.125 21.4688C51.125 23.3584 50.3743 25.1707 49.0381 26.5069C47.7019 27.8431 45.8897 28.5938 44 28.5938C42.1103 28.5938 40.2981 27.8431 38.9619 26.5069C37.6257 25.1707 36.875 23.3584 36.875 21.4688C36.875 19.5791 37.6257 17.7668 38.9619 16.4306C40.2981 15.0944 42.1103 14.3438 44 14.3438ZM60.0312 23.25C59.5588 23.25 59.1058 23.0623 58.7717 22.7283C58.4377 22.3942 58.25 21.9412 58.25 21.4688C58.25 20.9963 58.4377 20.5433 58.7717 20.2092C59.1058 19.8752 59.5588 19.6875 60.0312 19.6875C60.5037 19.6875 60.9567 19.8752 61.2908 20.2092C61.6248 20.5433 61.8125 20.9963 61.8125 21.4688C61.8125 21.9412 61.6248 22.3942 61.2908 22.7283C60.9567 23.0623 60.5037 23.25 60.0312 23.25Z" fill="url(#paint0_linear_2880_1004)"/>
                                        </g>
                                        <circle cx="60.5" cy="21.5" r="2.5" fill="#FF3838" stroke="white"/>
                                        <defs>
                                            <filter id="filter0_d_2880_1004" x="0.500001" y="9.53674e-07" width="87" height="65.625" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                            <feOffset dy="6"/>
                                            <feGaussianBlur stdDeviation="7.5"/>
                                            <feComposite in2="hardAlpha" operator="out"/>
                                            <feColorMatrix type="matrix" values="0 0 0 0 0.120694 0 0 0 0 0.217895 0 0 0 0 0.658333 0 0 0 1 0"/>
                                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_2880_1004"/>
                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_2880_1004" result="shape"/>
                                            </filter>
                                            <linearGradient id="paint0_linear_2880_1004" x1="15.5" y1="5.01" x2="99.86" y2="42.63" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#C7F2FA"/>
                                            <stop offset="1" stop-color="#DAE0E2"/>
                                            </linearGradient>
                                        </defs>
                                        </svg>
                                    <div class="text-center text-white text-base font-bold font-['Segoe UI'] leading-normal mt-[10px]"><?php echo esc_html($evr_floating_text[2]); ?></div>
                                </div>
                                <div id="choose-text-review-button" class="cursor-pointer w-[150px] h-[150px] p-[15px] bg-[#7357F2] rounded-[15px] border border-zinc-200 justify-center flex-col items-center inline-flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="89" height="59" viewBox="0 0 89 59" fill="none">
                                        <g filter="url(#filter0_d_2880_989)">
                                            <rect x="18" y="12" width="52" height="23" fill="white"/>
                                            <rect x="20" y="13" width="7" height="6" fill="url(#paint0_linear_2880_989)"/>
                                            <rect x="62" y="28" width="7" height="6" fill="url(#paint1_linear_2880_989)"/>
                                            <path d="M15 13.8333C15 11.175 17.655 9 20.9 9H68.1C69.6648 9 71.1655 9.50922 72.2719 10.4157C73.3784 11.3221 74 12.5515 74 13.8333V33.1667C74 34.4485 73.3784 35.6779 72.2719 36.5843C71.1655 37.4908 69.6648 38 68.1 38H20.9C19.3352 38 17.8345 37.4908 16.7281 36.5843C15.6216 35.6779 15 34.4485 15 33.1667V13.8333ZM21.9 13.8333C21.3477 13.8333 20.9 14.281 20.9 14.8333V17.6667C20.9 18.219 21.3477 18.6667 21.9 18.6667H25.8C26.3523 18.6667 26.8 18.219 26.8 17.6667V14.8333C26.8 14.281 26.3523 13.8333 25.8 13.8333H21.9ZM24.85 21.0833C24.2977 21.0833 23.85 21.531 23.85 22.0833V24.9167C23.85 25.469 24.2977 25.9167 24.85 25.9167H28.75C29.3023 25.9167 29.75 25.469 29.75 24.9167V22.0833C29.75 21.531 29.3023 21.0833 28.75 21.0833H24.85ZM21.9 28.3333C21.3477 28.3333 20.9 28.781 20.9 29.3333V32.1667C20.9 32.719 21.3477 33.1667 21.9 33.1667H25.8C26.3523 33.1667 26.8 32.719 26.8 32.1667V29.3333C26.8 28.781 26.3523 28.3333 25.8 28.3333H21.9ZM30.75 28.3333C30.1977 28.3333 29.75 28.781 29.75 29.3333V32.1667C29.75 32.719 30.1977 33.1667 30.75 33.1667H58.25C58.8023 33.1667 59.25 32.719 59.25 32.1667V29.3333C59.25 28.781 58.8023 28.3333 58.25 28.3333H30.75ZM63.2 28.3333C62.6477 28.3333 62.2 28.781 62.2 29.3333V32.1667C62.2 32.719 62.6477 33.1667 63.2 33.1667H67.1C67.6523 33.1667 68.1 32.719 68.1 32.1667V29.3333C68.1 28.781 67.6523 28.3333 67.1 28.3333H63.2ZM33.7 21.0833C33.1477 21.0833 32.7 21.531 32.7 22.0833V24.9167C32.7 25.469 33.1477 25.9167 33.7 25.9167H37.6C38.1523 25.9167 38.6 25.469 38.6 24.9167V22.0833C38.6 21.531 38.1523 21.0833 37.6 21.0833H33.7ZM42.55 21.0833C41.9977 21.0833 41.55 21.531 41.55 22.0833V24.9167C41.55 25.469 41.9977 25.9167 42.55 25.9167H46.45C47.0023 25.9167 47.45 25.469 47.45 24.9167V22.0833C47.45 21.531 47.0023 21.0833 46.45 21.0833H42.55ZM51.4 21.0833C50.8477 21.0833 50.4 21.531 50.4 22.0833V24.9167C50.4 25.469 50.8477 25.9167 51.4 25.9167H55.3C55.8523 25.9167 56.3 25.469 56.3 24.9167V22.0833C56.3 21.531 55.8523 21.0833 55.3 21.0833H51.4ZM60.25 21.0833C59.6977 21.0833 59.25 21.531 59.25 22.0833V24.9167C59.25 25.469 59.6977 25.9167 60.25 25.9167H64.15C64.7023 25.9167 65.15 25.469 65.15 24.9167V22.0833C65.15 21.531 64.7023 21.0833 64.15 21.0833H60.25ZM30.75 13.8333C30.1977 13.8333 29.75 14.281 29.75 14.8333V17.6667C29.75 18.219 30.1977 18.6667 30.75 18.6667H34.65C35.2023 18.6667 35.65 18.219 35.65 17.6667V14.8333C35.65 14.281 35.2023 13.8333 34.65 13.8333H30.75ZM39.6 13.8333C39.0477 13.8333 38.6 14.281 38.6 14.8333V17.6667C38.6 18.219 39.0477 18.6667 39.6 18.6667H43.5C44.0523 18.6667 44.5 18.219 44.5 17.6667V14.8333C44.5 14.281 44.0523 13.8333 43.5 13.8333H39.6ZM48.45 13.8333C47.8977 13.8333 47.45 14.281 47.45 14.8333V17.6667C47.45 18.219 47.8977 18.6667 48.45 18.6667H52.35C52.9023 18.6667 53.35 18.219 53.35 17.6667V14.8333C53.35 14.281 52.9023 13.8333 52.35 13.8333H48.45ZM57.3 13.8333C56.7477 13.8333 56.3 14.281 56.3 14.8333V17.6667C56.3 18.219 56.7477 18.6667 57.3 18.6667H67.1C67.6523 18.6667 68.1 18.219 68.1 17.6667V14.8333C68.1 14.281 67.6523 13.8333 67.1 13.8333H57.3Z" fill="url(#paint2_linear_2880_989)"/>
                                        </g>
                                        <defs>
                                            <filter id="filter0_d_2880_989" x="9.53674e-07" y="9.53674e-07" width="89" height="59" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                            <feOffset dy="6"/>
                                            <feGaussianBlur stdDeviation="7.5"/>
                                            <feComposite in2="hardAlpha" operator="out"/>
                                            <feColorMatrix type="matrix" values="0 0 0 0 0.120694 0 0 0 0 0.217895 0 0 0 0 0.658333 0 0 0 1 0"/>
                                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_2880_989"/>
                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_2880_989" result="shape"/>
                                            </filter>
                                            <linearGradient id="paint0_linear_2880_989" x1="20" y1="11.5" x2="28" y2="20.5" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#F7FFC6"/>
                                            <stop offset="1" stop-color="#F9CCAE"/>
                                            </linearGradient>
                                            <linearGradient id="paint1_linear_2880_989" x1="64" y1="26" x2="66.5" y2="40.5" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#FCDFCB"/>
                                            <stop offset="1" stop-color="#E9C81A"/>
                                            </linearGradient>
                                            <linearGradient id="paint2_linear_2880_989" x1="44.5" y1="9" x2="44.5" y2="38" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#9BC6ED"/>
                                            <stop offset="1" stop-color="#4E9DE6"/>
                                            </linearGradient>
                                        </defs>
                                        </svg>
                                    <div class="text-center text-white text-base font-bold font-['Segoe UI'] leading-normal mt-[10px]"><?php echo esc_html($evr_floating_text[3]); ?></div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="text-center text-zinc-600 text-xs font-normal font-['Segoe UI'] leading-normal"><?php echo esc_html($evr_floating_text[4]); ?></div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php if ( 'video' === $floating_widget_settings['widget_icon_background_type'] ) : ?>
            <!-- video play content -->
            <div class="evr-floating-widget__card z-[99] overflow-hidden flex flex-col min-h-[380px] px-5 py-6 sm:min-h-[561px] transition-all invisible opacity-[0] absolute bottom-[-100%] bg-[#fff] sm:w-[462px] shadow-lg rounded-[10px]">
                <div class="flex justify-end">
                    <span class="evr-floating-close cursor-pointer relative z-[1]">
                        <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 17 17" fill="none">
                            <path d="M8.5 8.5L16 16M1 16L8.5 8.5L1 16ZM16 1L8.49857 8.5L16 1ZM8.49857 8.5L1 1L8.49857 8.5Z" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </span>
                </div>
                <div class="mx-auto my-auto relative z-[1]">
                    <div class="text-center text-stone-900 text-base text-[#fff] font-bold font-['Segoe UI'] leading-normal mb-[20px]"><?php echo esc_html($evr_floating_text[0]); ?></div>
                    <div class="text-center text-stone-900 text-base text-[#fff] font-normal font-['Segoe UI'] leading-normal"><?php echo esc_html($evr_floating_text[1]); ?></div>
                        <?php if ( $this->only_video || $this->text_review_optional ) : ?>
                            <div class="flex justify-center my-[20px] lg:my-[30px] gap-[10px] lg:gap-[15px]">
                                <div id="only-video-review-button" class="cursor-pointer w-[150px] h-[150px] p-[15px] bg-blue-600 rounded-[15px] justify-center flex-col items-center inline-flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="87" height="67" viewBox="0 0 87 35" fill="none">
                                        <g filter="url(#filter0_d_1715_4041)">
                                            <path d="M38.6691 38.3349C38.8345 38.1661 39.0318 38.032 39.2496 37.9403C39.4673 37.8485 39.7011 37.801 39.9374 37.8005H47.0624C47.2987 37.801 47.5325 37.8485 47.7502 37.9403C47.9679 38.032 48.1652 38.1661 48.3306 38.3349C48.9541 38.9654 49.72 39.5711 50.4788 40.1019C51.3377 40.6977 52.2324 41.2402 53.1578 41.7264L53.1934 41.7478H53.2041C53.5647 41.9264 53.8541 42.2219 54.0253 42.5861C54.1964 42.9503 54.2392 43.3617 54.1467 43.7534C54.0542 44.145 53.8318 44.4937 53.5157 44.7428C53.1996 44.9919 52.8085 45.1266 52.4061 45.125H34.5936C34.1925 45.125 33.8032 44.9896 33.4886 44.7407C33.174 44.4919 32.9527 44.1441 32.8603 43.7538C32.768 43.3634 32.8101 42.9534 32.9799 42.5899C33.1496 42.2265 33.437 41.931 33.7956 41.7513L33.8028 41.7478L33.8384 41.7264C34.0972 41.5975 34.3515 41.4596 34.6008 41.3131C35.2577 40.9368 35.8983 40.5326 36.5209 40.1019C37.2833 39.5675 38.0457 38.9654 38.6691 38.3349ZM39.9374 21.9688C39.9374 21.0239 40.3127 20.1178 40.9808 19.4497C41.6489 18.7816 42.555 18.4062 43.4999 18.4062C44.4447 18.4062 45.3509 18.7816 46.0189 19.4497C46.687 20.1178 47.0624 21.0239 47.0624 21.9688C47.0624 22.9136 46.687 23.8197 46.0189 24.4878C45.3509 25.1559 44.4447 25.5313 43.4999 25.5313C42.555 25.5313 41.6489 25.1559 40.9808 24.4878C40.3127 23.8197 39.9374 22.9136 39.9374 21.9688Z" fill="white"/>
                                            <path d="M22.125 9.5C20.2353 9.5 18.4231 10.2507 17.0869 11.5869C15.7507 12.9231 15 14.7353 15 16.625L15 27.3125C15 29.2022 15.7507 31.0144 17.0869 32.3506C18.4231 33.6868 20.2353 34.4375 22.125 34.4375H64.875C66.7647 34.4375 68.5769 33.6868 69.9131 32.3506C71.2493 31.0144 72 29.2022 72 27.3125V16.625C72 14.7353 71.2493 12.9231 69.9131 11.5869C68.5769 10.2507 66.7647 9.5 64.875 9.5H22.125ZM43.5 14.8438C45.3897 14.8438 47.2019 15.5944 48.5381 16.9306C49.8743 18.2668 50.625 20.0791 50.625 21.9688C50.625 23.8584 49.8743 25.6707 48.5381 27.0069C47.2019 28.3431 45.3897 29.0938 43.5 29.0938C41.6103 29.0938 39.7981 28.3431 38.4619 27.0069C37.1257 25.6707 36.375 23.8584 36.375 21.9688C36.375 20.0791 37.1257 18.2668 38.4619 16.9306C39.7981 15.5944 41.6103 14.8438 43.5 14.8438ZM59.5312 23.75C59.0588 23.75 58.6058 23.5623 58.2717 23.2283C57.9377 22.8942 57.75 22.4412 57.75 21.9688C57.75 21.4963 57.9377 21.0433 58.2717 20.7092C58.6058 20.3752 59.0588 20.1875 59.5312 20.1875C60.0037 20.1875 60.4567 20.3752 60.7908 20.7092C61.1248 21.0433 61.3125 21.4963 61.3125 21.9688C61.3125 22.4412 61.1248 22.8942 60.7908 23.2283C60.4567 23.5623 60.0037 23.75 59.5312 23.75Z" fill="url(#paint0_linear_1715_4041)"/>
                                        </g>
                                        <circle cx="60" cy="22" r="2.5" fill="#FF3838" stroke="white"/>
                                        <defs>
                                            <filter id="filter0_d_1715_4041" x="9.53674e-07" y="0.500001" width="87" height="65.625" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                            <feOffset dy="6"/>
                                            <feGaussianBlur stdDeviation="7.5"/>
                                            <feComposite in2="hardAlpha" operator="out"/>
                                            <feColorMatrix type="matrix" values="0 0 0 0 0.120694 0 0 0 0 0.217895 0 0 0 0 0.658333 0 0 0 1 0"/>
                                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1715_4041"/>
                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1715_4041" result="shape"/>
                                            </filter>
                                            <linearGradient id="paint0_linear_1715_4041" x1="15" y1="5.51" x2="99.36" y2="43.13" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#C7F2FA"/>
                                            <stop offset="1" stop-color="#DAE0E2"/>
                                            </linearGradient>
                                        </defs>
                                    </svg>
                                    <div class="text-center text-white text-base font-bold font-['Segoe UI'] leading-normal mt-[10px]"><?php echo esc_html($evr_floating_text[2]); ?></div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if ( $this->only_text ) : ?>
                            <div class="flex justify-center my-[20px] lg:my-[30px] gap-[10px] lg:gap-[15px]">
                                <div id="only-text-review-button" class="cursor-pointer w-[150px] h-[150px] p-[15px] bg-[#7357F2] rounded-[15px] justify-center flex-col items-center inline-flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="59" height="29" viewBox="0 0 59 29" fill="none">
                                        <path d="M0 4.83333C0 2.175 2.655 0 5.9 0H53.1C54.6648 0 56.1655 0.509225 57.2719 1.41565C58.3784 2.32208 59 3.55145 59 4.83333V24.1667C59 25.4485 58.3784 26.6779 57.2719 27.5843C56.1655 28.4908 54.6648 29 53.1 29H5.9C4.33522 29 2.83453 28.4908 1.72807 27.5843C0.621605 26.6779 0 25.4485 0 24.1667V4.83333ZM6.9 4.83333C6.34772 4.83333 5.9 5.28105 5.9 5.83333V8.66667C5.9 9.21895 6.34772 9.66667 6.9 9.66667H10.8C11.3523 9.66667 11.8 9.21895 11.8 8.66667V5.83333C11.8 5.28105 11.3523 4.83333 10.8 4.83333H6.9ZM9.85 12.0833C9.29772 12.0833 8.85 12.531 8.85 13.0833V15.9167C8.85 16.469 9.29772 16.9167 9.85 16.9167H13.75C14.3023 16.9167 14.75 16.469 14.75 15.9167V13.0833C14.75 12.531 14.3023 12.0833 13.75 12.0833H9.85ZM6.9 19.3333C6.34772 19.3333 5.9 19.781 5.9 20.3333V23.1667C5.9 23.719 6.34772 24.1667 6.9 24.1667H10.8C11.3523 24.1667 11.8 23.719 11.8 23.1667V20.3333C11.8 19.781 11.3523 19.3333 10.8 19.3333H6.9ZM15.75 19.3333C15.1977 19.3333 14.75 19.781 14.75 20.3333V23.1667C14.75 23.719 15.1977 24.1667 15.75 24.1667H43.25C43.8023 24.1667 44.25 23.719 44.25 23.1667V20.3333C44.25 19.781 43.8023 19.3333 43.25 19.3333H15.75ZM48.2 19.3333C47.6477 19.3333 47.2 19.781 47.2 20.3333V23.1667C47.2 23.719 47.6477 24.1667 48.2 24.1667H52.1C52.6523 24.1667 53.1 23.719 53.1 23.1667V20.3333C53.1 19.781 52.6523 19.3333 52.1 19.3333H48.2ZM18.7 12.0833C18.1477 12.0833 17.7 12.531 17.7 13.0833V15.9167C17.7 16.469 18.1477 16.9167 18.7 16.9167H22.6C23.1523 16.9167 23.6 16.469 23.6 15.9167V13.0833C23.6 12.531 23.1523 12.0833 22.6 12.0833H18.7ZM27.55 12.0833C26.9977 12.0833 26.55 12.531 26.55 13.0833V15.9167C26.55 16.469 26.9977 16.9167 27.55 16.9167H31.45C32.0023 16.9167 32.45 16.469 32.45 15.9167V13.0833C32.45 12.531 32.0023 12.0833 31.45 12.0833H27.55ZM36.4 12.0833C35.8477 12.0833 35.4 12.531 35.4 13.0833V15.9167C35.4 16.469 35.8477 16.9167 36.4 16.9167H40.3C40.8523 16.9167 41.3 16.469 41.3 15.9167V13.0833C41.3 12.531 40.8523 12.0833 40.3 12.0833H36.4ZM45.25 12.0833C44.6977 12.0833 44.25 12.531 44.25 13.0833V15.9167C44.25 16.469 44.6977 16.9167 45.25 16.9167H49.15C49.7023 16.9167 50.15 16.469 50.15 15.9167V13.0833C50.15 12.531 49.7023 12.0833 49.15 12.0833H45.25ZM15.75 4.83333C15.1977 4.83333 14.75 5.28105 14.75 5.83333V8.66667C14.75 9.21895 15.1977 9.66667 15.75 9.66667H19.65C20.2023 9.66667 20.65 9.21895 20.65 8.66667V5.83333C20.65 5.28105 20.2023 4.83333 19.65 4.83333H15.75ZM24.6 4.83333C24.0477 4.83333 23.6 5.28105 23.6 5.83333V8.66667C23.6 9.21895 24.0477 9.66667 24.6 9.66667H28.5C29.0523 9.66667 29.5 9.21895 29.5 8.66667V5.83333C29.5 5.28105 29.0523 4.83333 28.5 4.83333H24.6ZM33.45 4.83333C32.8977 4.83333 32.45 5.28105 32.45 5.83333V8.66667C32.45 9.21895 32.8977 9.66667 33.45 9.66667H37.35C37.9023 9.66667 38.35 9.21895 38.35 8.66667V5.83333C38.35 5.28105 37.9023 4.83333 37.35 4.83333H33.45ZM42.3 4.83333C41.7477 4.83333 41.3 5.28105 41.3 5.83333V8.66667C41.3 9.21895 41.7477 9.66667 42.3 9.66667H52.1C52.6523 9.66667 53.1 9.21895 53.1 8.66667V5.83333C53.1 5.28105 52.6523 4.83333 52.1 4.83333H42.3Z" fill="url(#paint0_linear)"/>
                                        <defs>
                                        <linearGradient id="paint0_linear" x1="29.5" y1="0" x2="29.5" y2="29" gradientUnits="userSpaceOnUse">
                                        <stop stop-color="#9BC6ED"/>
                                        <stop offset="1" stop-color="#4E9DE6"/>
                                        </linearGradient>
                                        </defs>
                                    </svg>
                                    <div class="text-center text-white text-base font-bold font-['Segoe UI'] leading-normal mt-[10px]"><?php echo esc_html($evr_floating_text[3]); ?></div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if ( $this->choose_option ) : ?>
                            <div class="flex justify-center my-[20px] lg:my-[30px] gap-[10px] lg:gap-[15px]">
                                <div id="choose-video-review-button" class="cursor-pointer w-[150px] h-[150px] p-[15px] bg-blue-600 rounded-[15px] justify-center flex-col items-center inline-flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="88" height="66" viewBox="0 0 88 66" fill="none">
                                        <g filter="url(#filter0_d_2880_1004)">
                                            <path d="M39.1691 37.8349C39.3345 37.6661 39.5318 37.532 39.7496 37.4403C39.9673 37.3485 40.2011 37.301 40.4374 37.3005H47.5624C47.7987 37.301 48.0325 37.3485 48.2502 37.4403C48.4679 37.532 48.6652 37.6661 48.8306 37.8349C49.4541 38.4654 50.22 39.0711 50.9788 39.6019C51.8377 40.1977 52.7324 40.7402 53.6578 41.2264L53.6934 41.2478H53.7041C54.0647 41.4264 54.3541 41.7219 54.5253 42.0861C54.6964 42.4503 54.7392 42.8617 54.6467 43.2534C54.5542 43.645 54.3318 43.9937 54.0157 44.2428C53.6996 44.4919 53.3085 44.6266 52.9061 44.625H35.0936C34.6925 44.625 34.3032 44.4896 33.9886 44.2407C33.674 43.9919 33.4527 43.6441 33.3603 43.2538C33.268 42.8634 33.3101 42.4534 33.4799 42.0899C33.6496 41.7265 33.937 41.431 34.2956 41.2513L34.3028 41.2478L34.3384 41.2264C34.5972 41.0975 34.8515 40.9596 35.1008 40.8131C35.7577 40.4368 36.3983 40.0326 37.0209 39.6019C37.7833 39.0675 38.5457 38.4654 39.1691 37.8349ZM40.4374 21.4688C40.4374 20.5239 40.8127 19.6178 41.4808 18.9497C42.1489 18.2816 43.055 17.9062 43.9999 17.9062C44.9447 17.9062 45.8509 18.2816 46.5189 18.9497C47.187 19.6178 47.5624 20.5239 47.5624 21.4688C47.5624 22.4136 47.187 23.3197 46.5189 23.9878C45.8509 24.6559 44.9447 25.0313 43.9999 25.0313C43.055 25.0313 42.1489 24.6559 41.4808 23.9878C40.8127 23.3197 40.4374 22.4136 40.4374 21.4688Z" fill="white"/>
                                            <path d="M22.625 9C20.7353 9 18.9231 9.75067 17.5869 11.0869C16.2507 12.4231 15.5 14.2353 15.5 16.125L15.5 26.8125C15.5 28.7022 16.2507 30.5144 17.5869 31.8506C18.9231 33.1868 20.7353 33.9375 22.625 33.9375H65.375C67.2647 33.9375 69.0769 33.1868 70.4131 31.8506C71.7493 30.5144 72.5 28.7022 72.5 26.8125V16.125C72.5 14.2353 71.7493 12.4231 70.4131 11.0869C69.0769 9.75067 67.2647 9 65.375 9H22.625ZM44 14.3438C45.8897 14.3438 47.7019 15.0944 49.0381 16.4306C50.3743 17.7668 51.125 19.5791 51.125 21.4688C51.125 23.3584 50.3743 25.1707 49.0381 26.5069C47.7019 27.8431 45.8897 28.5938 44 28.5938C42.1103 28.5938 40.2981 27.8431 38.9619 26.5069C37.6257 25.1707 36.875 23.3584 36.875 21.4688C36.875 19.5791 37.6257 17.7668 38.9619 16.4306C40.2981 15.0944 42.1103 14.3438 44 14.3438ZM60.0312 23.25C59.5588 23.25 59.1058 23.0623 58.7717 22.7283C58.4377 22.3942 58.25 21.9412 58.25 21.4688C58.25 20.9963 58.4377 20.5433 58.7717 20.2092C59.1058 19.8752 59.5588 19.6875 60.0312 19.6875C60.5037 19.6875 60.9567 19.8752 61.2908 20.2092C61.6248 20.5433 61.8125 20.9963 61.8125 21.4688C61.8125 21.9412 61.6248 22.3942 61.2908 22.7283C60.9567 23.0623 60.5037 23.25 60.0312 23.25Z" fill="url(#paint0_linear_2880_1004)"/>
                                        </g>
                                        <circle cx="60.5" cy="21.5" r="2.5" fill="#FF3838" stroke="white"/>
                                        <defs>
                                            <filter id="filter0_d_2880_1004" x="0.500001" y="9.53674e-07" width="87" height="65.625" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                            <feOffset dy="6"/>
                                            <feGaussianBlur stdDeviation="7.5"/>
                                            <feComposite in2="hardAlpha" operator="out"/>
                                            <feColorMatrix type="matrix" values="0 0 0 0 0.120694 0 0 0 0 0.217895 0 0 0 0 0.658333 0 0 0 1 0"/>
                                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_2880_1004"/>
                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_2880_1004" result="shape"/>
                                            </filter>
                                            <linearGradient id="paint0_linear_2880_1004" x1="15.5" y1="5.01" x2="99.86" y2="42.63" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#C7F2FA"/>
                                            <stop offset="1" stop-color="#DAE0E2"/>
                                            </linearGradient>
                                        </defs>
                                        </svg>
                                    <div class="text-center text-white text-base font-bold font-['Segoe UI'] leading-normal mt-[10px]"><?php echo esc_html($evr_floating_text[2]); ?></div>
                                </div>
                                <div id="choose-text-review-button" class="cursor-pointer w-[150px] h-[150px] p-[15px] bg-[#7357F2] rounded-[15px] justify-center flex-col items-center inline-flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="89" height="59" viewBox="0 0 89 59" fill="none">
                                        <g filter="url(#filter0_d_2880_989)">
                                            <rect x="18" y="12" width="52" height="23" fill="white"/>
                                            <rect x="20" y="13" width="7" height="6" fill="url(#paint0_linear_2880_989)"/>
                                            <rect x="62" y="28" width="7" height="6" fill="url(#paint1_linear_2880_989)"/>
                                            <path d="M15 13.8333C15 11.175 17.655 9 20.9 9H68.1C69.6648 9 71.1655 9.50922 72.2719 10.4157C73.3784 11.3221 74 12.5515 74 13.8333V33.1667C74 34.4485 73.3784 35.6779 72.2719 36.5843C71.1655 37.4908 69.6648 38 68.1 38H20.9C19.3352 38 17.8345 37.4908 16.7281 36.5843C15.6216 35.6779 15 34.4485 15 33.1667V13.8333ZM21.9 13.8333C21.3477 13.8333 20.9 14.281 20.9 14.8333V17.6667C20.9 18.219 21.3477 18.6667 21.9 18.6667H25.8C26.3523 18.6667 26.8 18.219 26.8 17.6667V14.8333C26.8 14.281 26.3523 13.8333 25.8 13.8333H21.9ZM24.85 21.0833C24.2977 21.0833 23.85 21.531 23.85 22.0833V24.9167C23.85 25.469 24.2977 25.9167 24.85 25.9167H28.75C29.3023 25.9167 29.75 25.469 29.75 24.9167V22.0833C29.75 21.531 29.3023 21.0833 28.75 21.0833H24.85ZM21.9 28.3333C21.3477 28.3333 20.9 28.781 20.9 29.3333V32.1667C20.9 32.719 21.3477 33.1667 21.9 33.1667H25.8C26.3523 33.1667 26.8 32.719 26.8 32.1667V29.3333C26.8 28.781 26.3523 28.3333 25.8 28.3333H21.9ZM30.75 28.3333C30.1977 28.3333 29.75 28.781 29.75 29.3333V32.1667C29.75 32.719 30.1977 33.1667 30.75 33.1667H58.25C58.8023 33.1667 59.25 32.719 59.25 32.1667V29.3333C59.25 28.781 58.8023 28.3333 58.25 28.3333H30.75ZM63.2 28.3333C62.6477 28.3333 62.2 28.781 62.2 29.3333V32.1667C62.2 32.719 62.6477 33.1667 63.2 33.1667H67.1C67.6523 33.1667 68.1 32.719 68.1 32.1667V29.3333C68.1 28.781 67.6523 28.3333 67.1 28.3333H63.2ZM33.7 21.0833C33.1477 21.0833 32.7 21.531 32.7 22.0833V24.9167C32.7 25.469 33.1477 25.9167 33.7 25.9167H37.6C38.1523 25.9167 38.6 25.469 38.6 24.9167V22.0833C38.6 21.531 38.1523 21.0833 37.6 21.0833H33.7ZM42.55 21.0833C41.9977 21.0833 41.55 21.531 41.55 22.0833V24.9167C41.55 25.469 41.9977 25.9167 42.55 25.9167H46.45C47.0023 25.9167 47.45 25.469 47.45 24.9167V22.0833C47.45 21.531 47.0023 21.0833 46.45 21.0833H42.55ZM51.4 21.0833C50.8477 21.0833 50.4 21.531 50.4 22.0833V24.9167C50.4 25.469 50.8477 25.9167 51.4 25.9167H55.3C55.8523 25.9167 56.3 25.469 56.3 24.9167V22.0833C56.3 21.531 55.8523 21.0833 55.3 21.0833H51.4ZM60.25 21.0833C59.6977 21.0833 59.25 21.531 59.25 22.0833V24.9167C59.25 25.469 59.6977 25.9167 60.25 25.9167H64.15C64.7023 25.9167 65.15 25.469 65.15 24.9167V22.0833C65.15 21.531 64.7023 21.0833 64.15 21.0833H60.25ZM30.75 13.8333C30.1977 13.8333 29.75 14.281 29.75 14.8333V17.6667C29.75 18.219 30.1977 18.6667 30.75 18.6667H34.65C35.2023 18.6667 35.65 18.219 35.65 17.6667V14.8333C35.65 14.281 35.2023 13.8333 34.65 13.8333H30.75ZM39.6 13.8333C39.0477 13.8333 38.6 14.281 38.6 14.8333V17.6667C38.6 18.219 39.0477 18.6667 39.6 18.6667H43.5C44.0523 18.6667 44.5 18.219 44.5 17.6667V14.8333C44.5 14.281 44.0523 13.8333 43.5 13.8333H39.6ZM48.45 13.8333C47.8977 13.8333 47.45 14.281 47.45 14.8333V17.6667C47.45 18.219 47.8977 18.6667 48.45 18.6667H52.35C52.9023 18.6667 53.35 18.219 53.35 17.6667V14.8333C53.35 14.281 52.9023 13.8333 52.35 13.8333H48.45ZM57.3 13.8333C56.7477 13.8333 56.3 14.281 56.3 14.8333V17.6667C56.3 18.219 56.7477 18.6667 57.3 18.6667H67.1C67.6523 18.6667 68.1 18.219 68.1 17.6667V14.8333C68.1 14.281 67.6523 13.8333 67.1 13.8333H57.3Z" fill="url(#paint2_linear_2880_989)"/>
                                        </g>
                                        <defs>
                                            <filter id="filter0_d_2880_989" x="9.53674e-07" y="9.53674e-07" width="89" height="59" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                            <feOffset dy="6"/>
                                            <feGaussianBlur stdDeviation="7.5"/>
                                            <feComposite in2="hardAlpha" operator="out"/>
                                            <feColorMatrix type="matrix" values="0 0 0 0 0.120694 0 0 0 0 0.217895 0 0 0 0 0.658333 0 0 0 1 0"/>
                                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_2880_989"/>
                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_2880_989" result="shape"/>
                                            </filter>
                                            <linearGradient id="paint0_linear_2880_989" x1="20" y1="11.5" x2="28" y2="20.5" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#F7FFC6"/>
                                            <stop offset="1" stop-color="#F9CCAE"/>
                                            </linearGradient>
                                            <linearGradient id="paint1_linear_2880_989" x1="64" y1="26" x2="66.5" y2="40.5" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#FCDFCB"/>
                                            <stop offset="1" stop-color="#E9C81A"/>
                                            </linearGradient>
                                            <linearGradient id="paint2_linear_2880_989" x1="44.5" y1="9" x2="44.5" y2="38" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#9BC6ED"/>
                                            <stop offset="1" stop-color="#4E9DE6"/>
                                            </linearGradient>
                                        </defs>
                                        </svg>
                                    <div class="text-center text-white text-base font-bold font-['Segoe UI'] leading-normal mt-[10px]"><?php echo esc_html($evr_floating_text[3]); ?></div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="text-center text-zinc-600 text-xs text-[#fff] font-normal font-['Segoe UI'] leading-normal"><?php echo esc_html($evr_floating_text[4]); ?></div>
                </div>
                <div class="video-controler mt-4 flex items-center justify-between relative z-[1]">
                    <?php if ( preg_match($you_tube_url_pattern, $floating_widget_settings['icon_background_video_url']) || preg_match($you_tube_short_pattern, $floating_widget_settings['icon_background_video_url']) ) : ?>
                        <div id="floating-yt-video-unmute" class="cursor-pointer">
                            <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.26057 2.03426C9.26057 1.11459 8.14814 0.654059 7.49831 1.30458L4.4006 4.40229H3.07065C2.28521 4.40229 1.47499 4.85937 1.23956 5.71365C1.07984 6.29564 0.999264 6.89649 1.00001 7.5C1.00001 8.11817 1.0833 8.71706 1.24094 9.28635C1.47568 10.1399 2.2859 10.5977 3.07134 10.5977H4.39991L7.49763 13.6954C8.14814 14.3459 9.26057 13.8854 9.26057 12.9657V2.03426ZM11.2068 5.5863C11.1596 5.53558 11.1026 5.49489 11.0392 5.46668C10.9759 5.43846 10.9075 5.42328 10.8382 5.42206C10.7689 5.42084 10.7 5.43359 10.6358 5.45956C10.5715 5.48552 10.5131 5.52417 10.464 5.5732C10.415 5.62222 10.3764 5.68062 10.3504 5.74491C10.3244 5.80919 10.3117 5.87805 10.3129 5.94737C10.3141 6.0167 10.3293 6.08506 10.3575 6.14839C10.3857 6.21172 10.4264 6.26872 10.4771 6.31599L11.6612 7.5L10.4771 8.68401C10.386 8.78188 10.3363 8.91133 10.3387 9.04508C10.341 9.17884 10.3952 9.30645 10.4898 9.40104C10.5844 9.49564 10.712 9.54982 10.8458 9.55218C10.9795 9.55454 11.109 9.50489 11.2068 9.4137L12.3908 8.22968L13.5749 9.4137C13.6221 9.46442 13.6791 9.50511 13.7425 9.53332C13.8058 9.56154 13.8742 9.57671 13.9435 9.57794C14.0128 9.57916 14.0817 9.56641 14.1459 9.54044C14.2102 9.51448 14.2686 9.47583 14.3176 9.4268C14.3667 9.37778 14.4053 9.31938 14.4313 9.25509C14.4573 9.19081 14.47 9.12195 14.4688 9.05263C14.4676 8.9833 14.4524 8.91494 14.4242 8.85161C14.396 8.78828 14.3553 8.73128 14.3045 8.68401L13.1205 7.5L14.3045 6.31599C14.3957 6.21812 14.4454 6.08867 14.443 5.95492C14.4407 5.82116 14.3865 5.69355 14.2919 5.59895C14.1973 5.50436 14.0697 5.45018 13.9359 5.44782C13.8022 5.44546 13.6727 5.49511 13.5749 5.5863L12.3908 6.77032L11.2068 5.5863Z" fill="white"/>
                            </svg>
                        </div>
                        <div id="floating-yt-video-fullscreen" class="cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
                                <path d="M1.92857 9.35714C1.41786 9.35714 1 9.775 1 10.2857V13.0714C1 13.5821 1.41786 14 1.92857 14H4.71429C5.225 14 5.64286 13.5821 5.64286 13.0714C5.64286 12.5607 5.225 12.1429 4.71429 12.1429H2.85714V10.2857C2.85714 9.775 2.43929 9.35714 1.92857 9.35714ZM1.92857 5.64286C2.43929 5.64286 2.85714 5.225 2.85714 4.71429V2.85714H4.71429C5.225 2.85714 5.64286 2.43929 5.64286 1.92857C5.64286 1.41786 5.225 1 4.71429 1H1.92857C1.41786 1 1 1.41786 1 1.92857V4.71429C1 5.225 1.41786 5.64286 1.92857 5.64286ZM12.1429 12.1429H10.2857C9.775 12.1429 9.35714 12.5607 9.35714 13.0714C9.35714 13.5821 9.775 14 10.2857 14H13.0714C13.5821 14 14 13.5821 14 13.0714V10.2857C14 9.775 13.5821 9.35714 13.0714 9.35714C12.5607 9.35714 12.1429 9.775 12.1429 10.2857V12.1429ZM9.35714 1.92857C9.35714 2.43929 9.775 2.85714 10.2857 2.85714H12.1429V4.71429C12.1429 5.225 12.5607 5.64286 13.0714 5.64286C13.5821 5.64286 14 5.225 14 4.71429V1.92857C14 1.41786 13.5821 1 13.0714 1H10.2857C9.775 1 9.35714 1.41786 9.35714 1.92857Z" fill="white"/>
                            </svg>
                        </div>
                    <?php else : ?>
                        <div class="floating-video-mute cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
                                <path d="M11.2606 2.03426C11.2606 1.11459 10.1481 0.654059 9.49831 1.30458L6.4006 4.40229H5.07065C4.28521 4.40229 3.47499 4.85937 3.23956 5.71365C3.07984 6.29564 2.99926 6.89649 3.00001 7.5C3.00001 8.11817 3.0833 8.71706 3.24094 9.28635C3.47568 10.1399 4.2859 10.5977 5.07134 10.5977H6.39991L9.49763 13.6954C10.1481 14.3459 11.2606 13.8854 11.2606 12.9657V2.03426Z" fill="white"/>
                            </svg>
                        </div>
                        <div class="floating-video-fullscreen cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
                                <path d="M1.92857 9.35714C1.41786 9.35714 1 9.775 1 10.2857V13.0714C1 13.5821 1.41786 14 1.92857 14H4.71429C5.225 14 5.64286 13.5821 5.64286 13.0714C5.64286 12.5607 5.225 12.1429 4.71429 12.1429H2.85714V10.2857C2.85714 9.775 2.43929 9.35714 1.92857 9.35714ZM1.92857 5.64286C2.43929 5.64286 2.85714 5.225 2.85714 4.71429V2.85714H4.71429C5.225 2.85714 5.64286 2.43929 5.64286 1.92857C5.64286 1.41786 5.225 1 4.71429 1H1.92857C1.41786 1 1 1.41786 1 1.92857V4.71429C1 5.225 1.41786 5.64286 1.92857 5.64286ZM12.1429 12.1429H10.2857C9.775 12.1429 9.35714 12.5607 9.35714 13.0714C9.35714 13.5821 9.775 14 10.2857 14H13.0714C13.5821 14 14 13.5821 14 13.0714V10.2857C14 9.775 13.5821 9.35714 13.0714 9.35714C12.5607 9.35714 12.1429 9.775 12.1429 10.2857V12.1429ZM9.35714 1.92857C9.35714 2.43929 9.775 2.85714 10.2857 2.85714H12.1429V4.71429C12.1429 5.225 12.5607 5.64286 13.0714 5.64286C13.5821 5.64286 14 5.225 14 4.71429V1.92857C14 1.41786 13.5821 1 13.0714 1H10.2857C9.775 1 9.35714 1.41786 9.35714 1.92857Z" fill="white"/>
                            </svg>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="video-background floating-video-visible h-full w-full absolute top-0 left-0">
                    <div class="h-full w-full absolute z-1 top-0 left-0 bg-gradient-to-t from-gray-900 to-zinc-950"></div>
                    <?php if ( preg_match($you_tube_url_pattern, $floating_widget_settings['icon_background_video_url']) || preg_match($you_tube_short_pattern, $floating_widget_settings['icon_background_video_url']) ) : ?>
            
                        <div id="evr-floating-yt-video" class="h-[684px] w-[1200px] max-w-[1200px] z-[-1] absolute top-[50%] left-[50%] -translate-y-[50%] -translate-x-[50%] pointer-events-none"></div>
                    <?php else : ?>
                        <video id="evr-floating-modal-video" class="video h-full w-full object-cover <?php echo esc_attr($floating_widget_settings['widget_animation_effect']); ?>" src="<?php echo esc_url($floating_widget_settings['icon_background_video_url']); ?>" autoplay muted loop>
                        </video>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
    
    <script>
        <?php if ( 'hide-after-first-click' === $floating_widget_settings['cta_behavaiour'] ) : ?>
            let floatingButton = document.querySelector(".floating-button")
            let element = document.querySelector(".floating-hover-text")
            floatingButton.addEventListener("click", (event) => {
                element.classList.remove("visible", "opacity-[1]")
                element.classList.add("invisible", "opacity-[0]")
            });
        <?php endif; ?>

        var tag = document.createElement('script');
        tag.src = "https://www.youtube.com/iframe_api";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

        var player;
        function onYouTubeIframeAPIReady() {
            player = new YT.Player('evr-floating-yt-video', {
            height: '684',
            width: '1200',
            videoId: <?php echo "'" . esc_attr($yt_video_id) . "'"; ?>,
            playerVars: {
                'rel': 0,
                'autoplay': 1,
                'controls': 0,
                'mute': 1,
                'loop': 1,
                'playlist': <?php echo "'" . esc_attr($yt_video_id) . "'"; ?>,
                'enablejsapi': 1
            },
            events: {
                'onReady': onPlayerReady,
                'onError': onPlayerError
            }
            })

            function onPlayerReady(event) {
                document.getElementById('floating-yt-video-unmute').addEventListener('click', function() {
                    if(player.isMuted()){
                        player.unMute()
                        this.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
                            <path d="M11.2606 2.03426C11.2606 1.11459 10.1481 0.654059 9.49831 1.30458L6.4006 4.40229H5.07065C4.28521 4.40229 3.47499 4.85937 3.23956 5.71365C3.07984 6.29564 2.99926 6.89649 3.00001 7.5C3.00001 8.11817 3.0833 8.71706 3.24094 9.28635C3.47568 10.1399 4.2859 10.5977 5.07134 10.5977H6.39991L9.49763 13.6954C10.1481 14.3459 11.2606 13.8854 11.2606 12.9657V2.03426Z" fill="white"/>
                        </svg>`
                    }else{
                        player.mute()
                        this.innerHTML = `<svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.26057 2.03426C9.26057 1.11459 8.14814 0.654059 7.49831 1.30458L4.4006 4.40229H3.07065C2.28521 4.40229 1.47499 4.85937 1.23956 5.71365C1.07984 6.29564 0.999264 6.89649 1.00001 7.5C1.00001 8.11817 1.0833 8.71706 1.24094 9.28635C1.47568 10.1399 2.2859 10.5977 3.07134 10.5977H4.39991L7.49763 13.6954C8.14814 14.3459 9.26057 13.8854 9.26057 12.9657V2.03426ZM11.2068 5.5863C11.1596 5.53558 11.1026 5.49489 11.0392 5.46668C10.9759 5.43846 10.9075 5.42328 10.8382 5.42206C10.7689 5.42084 10.7 5.43359 10.6358 5.45956C10.5715 5.48552 10.5131 5.52417 10.464 5.5732C10.415 5.62222 10.3764 5.68062 10.3504 5.74491C10.3244 5.80919 10.3117 5.87805 10.3129 5.94737C10.3141 6.0167 10.3293 6.08506 10.3575 6.14839C10.3857 6.21172 10.4264 6.26872 10.4771 6.31599L11.6612 7.5L10.4771 8.68401C10.386 8.78188 10.3363 8.91133 10.3387 9.04508C10.341 9.17884 10.3952 9.30645 10.4898 9.40104C10.5844 9.49564 10.712 9.54982 10.8458 9.55218C10.9795 9.55454 11.109 9.50489 11.2068 9.4137L12.3908 8.22968L13.5749 9.4137C13.6221 9.46442 13.6791 9.50511 13.7425 9.53332C13.8058 9.56154 13.8742 9.57671 13.9435 9.57794C14.0128 9.57916 14.0817 9.56641 14.1459 9.54044C14.2102 9.51448 14.2686 9.47583 14.3176 9.4268C14.3667 9.37778 14.4053 9.31938 14.4313 9.25509C14.4573 9.19081 14.47 9.12195 14.4688 9.05263C14.4676 8.9833 14.4524 8.91494 14.4242 8.85161C14.396 8.78828 14.3553 8.73128 14.3045 8.68401L13.1205 7.5L14.3045 6.31599C14.3957 6.21812 14.4454 6.08867 14.443 5.95492C14.4407 5.82116 14.3865 5.69355 14.2919 5.59895C14.1973 5.50436 14.0697 5.45018 13.9359 5.44782C13.8022 5.44546 13.6727 5.49511 13.5749 5.5863L12.3908 6.77032L11.2068 5.5863Z" fill="white"/>
                        </svg>`
                    }
                })

                document.getElementById('floating-yt-video-fullscreen').addEventListener('click', function() {
                    if (!document.fullscreenElement) {
                        player.getIframe().requestFullscreen()
                    } else {
                        document.exitFullscreen()
                    }
                });
            }

            function onPlayerError(event) {
                let element = document.getElementById('floating-widget-button')
                element.innerHTML = `<video class="video h-full w-full object-cover" preload="auto" poster="<?php echo esc_url('https://evrstaging.wppool.dev/evr-icon/EVR%20Poster.png'); ?>" autoplay muted loop>
                        <source src="<?php echo esc_url($floating_widget_settings['icon_background_video_url']); ?>" type="video/mp4" />
                        <source src="<?php echo esc_url($floating_widget_settings['icon_background_video_url']); ?>" type="video/ogg">
                    </video>`
            }
        }
    </script>
    <style>
        .evr-floating-widget.evr-floating-right{
            <?php echo esc_attr($floating_widget_settings['widget_position']); ?> : 46px;
        }

        .evr-floating-widget .floating-cta-text{
            color: <?php echo esc_attr($floating_widget_settings['cta_backround_color']); ?> !important; background-color: <?php echo esc_attr($floating_widget_settings['cta_backround_color']); ?> !important;
        }
        .evr-floating-widget .floating-cta-text div.text{
            color: <?php echo esc_attr($floating_widget_settings['cta_text_color']); ?> !important;
        }
        .floating-button button svg path{
            fill: <?php echo esc_attr( $floating_widget_settings['icon_color'] ); ?>;
        }

        <?php if ( 'video' !== $floating_widget_settings['widget_icon_background_type'] ) : ?>
            .floating-button button{
                background-color: <?php echo esc_attr($floating_widget_settings['icon_background_color']); ?>;
            }
        <?php endif; ?>
       
        @media (max-width: 576px) {

           <?php if ( 'right' === $floating_widget_settings['widget_mobile_position'] ) : ?>
                .evr-floating-widget.evr-floating-mobile-right{
                    left: unset;
                    right: 46px;
                }
            <?php endif; ?>
            
            <?php if ( 'left' === $floating_widget_settings['widget_mobile_position'] ) : ?>
                .evr-floating-widget.evr-floating-mobile-left{
                    right: unset;
                    left: 46px;
                }
            <?php endif; ?>

            <?php if ( 'right' === $floating_widget_settings['widget_mobile_position'] ) : ?>
                .evr-floating-widget.evr-floating-mobile-right .evr-floating-widget__card{
                    left: unset;
                    right: -26px;
                }
            <?php endif; ?>

            <?php if ( 'left' === $floating_widget_settings['widget_mobile_position'] ) : ?>
                .evr-floating-widget.evr-floating-mobile-left .evr-floating-widget__card{
                    left: -26px;
                    right: unset;
                }
            <?php endif; ?>

            .evr-floating-widget .floating-cta-text{
                color: <?php echo esc_attr($floating_widget_settings['cta_backround_mobile_color']); ?> !important; background-color: <?php echo esc_attr($floating_widget_settings['cta_backround_mobile_color']); ?> !important;
            }

            .evr-floating-widget .floating-cta-text div.text{
                color: <?php echo esc_attr($floating_widget_settings['cta_text_mobile_color']); ?> !important;
            }

            .floating-button button svg path{
                fill: <?php echo esc_attr($floating_widget_settings['icon_mobile_color']); ?>;
            }

            <?php if ( 'video' !== $floating_widget_settings['widget_icon_background_type'] ) : ?>
                .floating-button button{
                    background-color: <?php echo esc_attr($floating_widget_settings['icon_background_mobile_color']); ?>;
                }
            <?php endif; ?>

            .evr-floating-widget.evr-floating-mobile-right .floating-button .floating-hover-text{
                right: 135%;
                left: unset;
            }

            .evr-floating-widget.evr-floating-mobile-left .floating-button .floating-hover-text{
                left: 135%;
                right: unset;
            }

            .evr-floating-widget.evr-floating-mobile-right .floating-button .floating-hover-text:after {
                right: -4px;
                left: unset;
            }

            .evr-floating-widget.evr-floating-mobile-left .floating-button .floating-hover-text:after {
                left: -4px;
                right: unset;
            }
        }
    </style>
<?php endif; ?>
<!--  recorder modal -->
