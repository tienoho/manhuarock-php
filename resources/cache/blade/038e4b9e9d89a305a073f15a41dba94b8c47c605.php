<?php if(!$hidden_form): ?>
    <div class="comment-input">
        <div class="user-avatar">
            <?php if(!is_login()): ?>
                <img class="user-avatar-img" src="/mangareader/images/no-avatar.jpg"/>
            <?php else: ?>
                <img class="user-avatar-img" src="<?php echo e(userget()->avatar_url); ?>"/>
            <?php endif; ?>
        </div>

        <div class="ci-form">
            <?php if(!is_login()): ?>
                <div class="user-name">You must be <a class="link-highlight" href="javascript:(0);" data-toggle="modal"
                                                      data-target="#modal-auth">login</a> to post a comment
                </div>
            <?php else: ?>
                <div class="user-name">
                    Comment as <span class="link-highlight"><?php echo e(userget()->name); ?></span>
                </div>
            <?php endif; ?>

            <form class="preform comment-form">
                <div class="loading-absolute " style="display: none;">
                    <div class="loading">
                        <div class="span1"></div>
                        <div class="span2"></div>
                        <div class="span3"></div>
                    </div>
                </div>
                <textarea class="form-control form-control-textarea" id="df-cm-content" name="content" maxlength="3000"
                          placeholder="Leave a comment" required></textarea>
                <div class="ci-buttons" id="df-cm-buttons" style="display: none;">
                    <div class="ci-b-left">
                        <div class="cb-li">
                            <a class="btn btn-sm btn-spoil"><i class="icofont-check mr-2"></i><?php echo e(L::_("Spoil?")); ?></a>
                        </div>
                    </div>
                    <div class="ci-b-right">
                        <div class="cb-li"><a class="btn btn-sm btn-secondary" id="df-cm-close">Close</a></div>
                        <div class="cb-li">
                            <button class="btn btn-sm btn-warning ml-2">Comment</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php endif; ?>

<div class="cw_list">
    <?php $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="cw_l-line" id="cm-<?php echo e($comment->id); ?>">
            <div class="user-avatar">
                <img class="user-avatar-img"
                     src="<?php echo e($comment->useravata); ?>"
                     alt="<?php echo e($comment->username); ?>"/></div>
            <div class="info">
                <div class="ihead">
                    <div class="user-name"><?php echo e($comment->username); ?></div>
                    <div class="time"><?php echo e(timeago($comment->updated_at)); ?></div>
                </div>
                <div class="ibody <?php echo e(($comment->is_spoil ? 'is-spoil' : '')); ?>">
                    <p><?php echo e($comment->content); ?></p>
                    <?php if($comment->is_spoil): ?>
                        <div class="show-spoil my-3">
                            <button type="button" class="btn btn-sm btn-light"><?php echo e(L::_('Show spoil')); ?></button>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="ibottom">
                    <div class="ib-li ib-reply" data-id="<?php echo e($comment->id); ?>">
                        <a class="btn"><i class="icofont-reply mr-1"></i><?php echo e(L::_('Reply')); ?></a>
                    </div>
                    <div class="ib-li ib-like">
                        <a class="btn cm-btn-vote" data-id="<?php echo e($comment->id); ?>" data-type="1">
                            <i class="icofont-thumbs-up mr-1"></i>
                            <span class="value"><?php echo e($comment->likes); ?></span>
                        </a>
                    </div>
                    <div class="ib-li ib-dislike">
                        <a class="btn cm-btn-vote" data-id="<?php echo e($comment->id); ?>" data-type="0"> <i
                                    class="icofont-thumbs-down mr-1"></i><span class="value"><?php echo e($comment->dislikes); ?></span> </a>
                    </div>
                    <?php if(is_login()): ?>
                        <div id="reply-<?php echo e($comment->id); ?>" class="comment-input is-reply reply-block"
                             style="display: none;">
                            <div class="user-avatar">
                                <img class="user-avatar-img"
                                     src="<?php echo e(userget()->avatar_url); ?>"
                                     alt="<?php echo e(userget()->name); ?>">
                            </div>
                            <div class="ci-form">
                                <form class="preform preform-dark comment-form">
                                    <div class="loading-absolute bg-white" style="display: none">
                                        <div class="loading">
                                            <div class="span1"></div>
                                            <div class="span2"></div>
                                            <div class="span3"></div>
                                        </div>
                                    </div>
                                    <input type="hidden" value="<?php echo e($comment->user_id); ?>" name="mention_id">
                                    <input type="hidden" value="<?php echo e($comment->id); ?>" name="parent_id">
                                    <textarea class="form-control form-control-textarea" name="content" maxlength="3000"
                                              placeholder="<?php echo e(L::_("Add a reply")); ?>" required=""></textarea>
                                    <div class="ci-buttons">
                                        <div class="ci-b-left">
                                            <div class="cb-li"><a class="btn btn-sm btn-spoil"><i
                                                            class="icofont-check mr-2"></i><?php echo e(L::_("Spoil?")); ?></a>
                                            </div>
                                        </div>
                                        <div class="ci-b-right">
                                            <div class="cb-li">
                                                <a class="btn btn-sm btn-secondary btn-close-reply"
                                                   data-id="<?php echo e($comment->id); ?>"><?php echo e(L::_('Close')); ?></a>
                                            </div>
                                            <div class="cb-li">
                                                <button class="btn btn-sm btn-warning ml-2"><?php echo e(L::_('Reply')); ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="clearfix"></div>
                </div>
            </div>

            <?php
            $replys = (new \Models\User)->getReplys($comment->id);
            ?>
            <?php if(!empty($replys)): ?>
                <div class="replies">
                    <div class="rep-more rep-in">
                        <button type="button" class="btn btn-sm cm-btn-show-rep" data-id="<?php echo e($comment->id); ?>">
                            <i class="icofont-caret-down mr-2"></i><span><?php echo e(count($replys)); ?> <?php echo e(L::_('replies')); ?></span>
                        </button>
                    </div>
                    <div class="replies-wrap" id="replies-<?php echo e($comment->id); ?>" style="display: none;">
                        <?php $__currentLoopData = $replys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reply): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="cw_l-line" id="cm-<?php echo e($reply->id); ?>" data-parent-id="<?php echo e($comment->id); ?>">
                                <div class="user-avatar">
                                    <img class="user-avatar-img" src="<?php echo e($reply->useravata); ?>"
                                         alt="<?php echo e($reply->username); ?>">
                                </div>
                                <div class="info">
                                    <div class="ihead">
                                        <div class="user-name"><?php echo e($reply->username); ?></div>
                                        <div class="time"><?php echo e(timeago($reply->updated_at)); ?></div>
                                    </div>
                                    <div class="ibody  <?php echo e(($reply->is_spoil ? 'is-spoil' : '')); ?>">

                                        <p><a class="tag-name"><?php echo e('@'. $reply->mention_name); ?></a> <?php echo e($reply->content); ?>

                                        </p>

                                        <?php if($reply->is_spoil): ?>
                                            <div class="show-spoil my-3">
                                                <button type="button"
                                                        class="btn btn-sm btn-light"><?php echo e(L::_('Show spoil')); ?></button>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="ibottom">
                                        <div class="ib-li ib-reply" data-id="<?php echo e($reply->id); ?>">
                                            <a class="btn"><i class="icofont-reply mr-1"></i><?php echo e(L::_('Reply')); ?></a>
                                        </div>
                                        <div class="ib-li ib-like">
                                            <a class="btn cm-btn-vote " data-id="<?php echo e($reply->id); ?>" data-type="1">
                                                <i class="icofont-thumbs-up mr-1"></i><span class="value"><?php echo e($reply->likes); ?></span>
                                            </a>
                                        </div>
                                        <div class="ib-li ib-dislike">
                                            <a class="btn cm-btn-vote " data-id="<?php echo e($reply->id); ?>" data-type="0">
                                                <i class="icofont-thumbs-down mr-1"></i><span class="value"><?php echo e($reply->dislikes); ?></span>
                                            </a>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>

                                    <div id="reply-<?php echo e($reply->id); ?>" class="comment-input is-reply reply-block"
                                         style="display: none;">
                                        <div class="user-avatar">
                                            <img class="user-avatar-img" src="<?php echo e(userget()->avatar_url); ?>"
                                                 alt="<?php echo e(userget()->name); ?>">
                                        </div>
                                        <div class="ci-form">
                                            <form class="preform preform-dark comment-form">
                                                <div class="loading-absolute bg-white" style="display: none">
                                                    <div class="loading">
                                                        <div class="span1"></div>
                                                        <div class="span2"></div>
                                                        <div class="span3"></div>
                                                    </div>
                                                </div>
                                                <input type="hidden" value="<?php echo e($reply->userid); ?>" name="mention_id">
                                                <input type="hidden" value="<?php echo e($comment->id); ?>" name="parent_id">
                                                <textarea class="form-control form-control-textarea" name="content"
                                                          maxlength="3000" placeholder="<?php echo e(L::_("Add a reply")); ?>"
                                                          required=""></textarea>
                                                <div class="ci-buttons">
                                                    <div class="ci-b-left">
                                                        <div class="cb-li"><a class="btn btn-sm btn-spoil"><i
                                                                        class="icofont-check mr-2"></i><?php echo e(L::_("Spoil?")); ?></a>
                                                        </div>
                                                    </div>
                                                    <div class="ci-b-right">
                                                        <div class="cb-li">
                                                            <a class="btn btn-sm btn-secondary btn-close-reply"
                                                               data-id="<?php echo e($reply->id); ?>"><?php echo e(L::_('Close')); ?></a>
                                                        </div>
                                                        <div class="cb-li">
                                                            <button class="btn btn-sm btn-warning ml-2"><?php echo e(L::_("Reply")); ?></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php /**PATH /www/wwwroot/mangarock.top/resources/views/themes/manga18fx/components/ajax/comment.blade.php ENDPATH**/ ?>