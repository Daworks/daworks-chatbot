<script src="//cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
<section>
    <div id="daworks-chatbot-show">
        <div class="entry-box">
            <h3 class="entry-title">
                &quot;<?php echo $card->title ?>&quot;
            </h3>
            <div class="entry-meta">
                <span class="writer"><attr><i data-feather="user"></i><?php echo $card->name ?></attr></span> 님이</span>
                <span class="created_at"><?php echo $card->created_at ?></span>에 작성하신 글입니다.
            </div>
        </div>
        <div class="entry-content">
            <?php if ($card->photo_check == 1) : ?>
                <picture>
                    <img src="<?= $card->photo ?>" alt="">
                </picture>
            <?php endif ?>
            <div class="content-body">
                <?php echo nl2br($card->story) ?>
            </div>
            <div class="content-comment" style="margin:30px 0;">
                <div id="fb-root"></div>
                <script>(function (d, s, id) {
                        var js, fjs = d.getElementsByTagName(s)[0];
                        if (d.getElementById(id)) return;
                        js = d.createElement(s);
                        js.id = id;
                        js.src = 'https://connect.facebook.net/ko_KR/sdk.js#xfbml=1&version=v3.3&appId=1617805988472516';
                        fjs.parentNode.insertBefore(js, fjs);
                    }(document, 'script', 'facebook-jssdk'));</script>
                <div class="fb-like" data-href="<?php echo home_url(add_query_arg(NULL, NULL)); ?>"
                     data-layout="standard" data-action="like" data-size="large" data-show-faces="true"
                     data-share="true"></div>

            </div>

            <table class="daworks_chatbot_navigation">
                <tbody>
                <tr>
                    <td class="text-left">
                        <?php if (!empty($next_id)) : ?>
                            <a href="<?php printf("%s?mode=show&show_id=%s&current_page=%s", get_permalink(), $next_id, sanitize_text_field($_REQUEST['current_page'])); ?>">
                                <i data-feather="arrow-left"></i> <?php echo mb_strimwidth( $next_title, 0, 30, '...') ?>
                            </a>
                        <?php endif ?>
                    </td>
                    <td class="text-center">
                        <a href="<?php printf("%s?mode=list&current_page=%s", get_permalink(), sanitize_text_field($_REQUEST['current_page'])); ?>"><i
                                    data-feather="grid"></i></a>
                    </td>
                    <td class="text-right">
                        <?php if (!empty($prev_id)) : ?>
                            <a href="<?php sprintf("%s?mode=show&show_id=%s&current_page=%s", get_permalink(), $prev_id, sanitize_text_field($_REQUEST['current_page'])); ?>"><?php echo mb_strimwidth($prev_title, 0, 30, '...') ?>
                                <i data-feather="arrow-right"></i></a>
                        <?php endif ?>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>
<script>feather.replace();</script>