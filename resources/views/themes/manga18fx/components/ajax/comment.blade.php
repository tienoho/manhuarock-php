@if(!$hidden_form)
    <div class="comment-input">
        <div class="user-avatar">
            @if(!is_login())
                <img class="user-avatar-img" src="/mangareader/images/no-avatar.jpg"/>
            @else
                <img class="user-avatar-img" src="{{ userget()->avatar_url }}"/>
            @endif
        </div>

        <div class="ci-form">
            @if(!is_login())
                <div class="user-name">You must be <a class="link-highlight" href="javascript:(0);" data-toggle="modal"
                                                      data-target="#modal-auth">login</a> to post a comment
                </div>
            @else
                <div class="user-name">
                    Comment as <span class="link-highlight">{{ userget()->name }}</span>
                </div>
            @endif

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
                            <a class="btn btn-sm btn-spoil"><i class="icofont-check mr-2"></i>{{ L::_("Spoil?") }}</a>
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
@endif

<div class="cw_list">
    @foreach($comments as $comment)
        <div class="cw_l-line" id="cm-{{ $comment->id }}">
            <div class="user-avatar">
                <img class="user-avatar-img"
                     src="{{ $comment->useravata }}"
                     alt="{{ $comment->username }}"/></div>
            <div class="info">
                <div class="ihead">
                    <div class="user-name">{{ $comment->username }}</div>
                    <div class="time">{{ timeago($comment->updated_at) }}</div>
                </div>
                <div class="ibody {{ ($comment->is_spoil ? 'is-spoil' : '') }}">
                    <p>{{ $comment->content }}</p>
                    @if($comment->is_spoil)
                        <div class="show-spoil my-3">
                            <button type="button" class="btn btn-sm btn-light">{{ L::_('Show spoil') }}</button>
                        </div>
                    @endif
                </div>
                <div class="ibottom">
                    <div class="ib-li ib-reply" data-id="{{ $comment->id }}">
                        <a class="btn"><i class="icofont-reply mr-1"></i>{{ L::_('Reply') }}</a>
                    </div>
                    <div class="ib-li ib-like">
                        <a class="btn cm-btn-vote" data-id="{{ $comment->id }}" data-type="1">
                            <i class="icofont-thumbs-up mr-1"></i>
                            <span class="value">{{ $comment->likes }}</span>
                        </a>
                    </div>
                    <div class="ib-li ib-dislike">
                        <a class="btn cm-btn-vote" data-id="{{ $comment->id }}" data-type="0"> <i
                                    class="icofont-thumbs-down mr-1"></i><span class="value">{{ $comment->dislikes }}</span> </a>
                    </div>
                    @if(is_login())
                        <div id="reply-{{ $comment->id }}" class="comment-input is-reply reply-block"
                             style="display: none;">
                            <div class="user-avatar">
                                <img class="user-avatar-img"
                                     src="{{ userget()->avatar_url }}"
                                     alt="{{ userget()->name }}">
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
                                    <input type="hidden" value="{{ $comment->user_id }}" name="mention_id">
                                    <input type="hidden" value="{{ $comment->id }}" name="parent_id">
                                    <textarea class="form-control form-control-textarea" name="content" maxlength="3000"
                                              placeholder="{{ L::_("Add a reply") }}" required=""></textarea>
                                    <div class="ci-buttons">
                                        <div class="ci-b-left">
                                            <div class="cb-li"><a class="btn btn-sm btn-spoil"><i
                                                            class="icofont-check mr-2"></i>{{ L::_("Spoil?") }}</a>
                                            </div>
                                        </div>
                                        <div class="ci-b-right">
                                            <div class="cb-li">
                                                <a class="btn btn-sm btn-secondary btn-close-reply"
                                                   data-id="{{ $comment->id }}">{{ L::_('Close') }}</a>
                                            </div>
                                            <div class="cb-li">
                                                <button class="btn btn-sm btn-warning ml-2">{{ L::_('Reply') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                    <div class="clearfix"></div>
                </div>
            </div>

            <?php
            $replys = (new \Models\User)->getReplys($comment->id);
            ?>
            @if(!empty($replys))
                <div class="replies">
                    <div class="rep-more rep-in">
                        <button type="button" class="btn btn-sm cm-btn-show-rep" data-id="{{ $comment->id }}">
                            <i class="icofont-caret-down mr-2"></i><span>{{ count($replys) }} {{ L::_('replies') }}</span>
                        </button>
                    </div>
                    <div class="replies-wrap" id="replies-{{ $comment->id }}" style="display: none;">
                        @foreach($replys as $reply)
                            <div class="cw_l-line" id="cm-{{ $reply->id }}" data-parent-id="{{ $comment->id }}">
                                <div class="user-avatar">
                                    <img class="user-avatar-img" src="{{ $reply->useravata }}"
                                         alt="{{ $reply->username }}">
                                </div>
                                <div class="info">
                                    <div class="ihead">
                                        <div class="user-name">{{ $reply->username }}</div>
                                        <div class="time">{{ timeago($reply->updated_at) }}</div>
                                    </div>
                                    <div class="ibody  {{ ($reply->is_spoil ? 'is-spoil' : '') }}">

                                        <p><a class="tag-name">{{ '@'. $reply->mention_name }}</a> {{ $reply->content }}
                                        </p>

                                        @if($reply->is_spoil)
                                            <div class="show-spoil my-3">
                                                <button type="button"
                                                        class="btn btn-sm btn-light">{{ L::_('Show spoil') }}</button>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ibottom">
                                        <div class="ib-li ib-reply" data-id="{{ $reply->id }}">
                                            <a class="btn"><i class="icofont-reply mr-1"></i>{{ L::_('Reply') }}</a>
                                        </div>
                                        <div class="ib-li ib-like">
                                            <a class="btn cm-btn-vote " data-id="{{ $reply->id }}" data-type="1">
                                                <i class="icofont-thumbs-up mr-1"></i><span class="value">{{ $reply->likes }}</span>
                                            </a>
                                        </div>
                                        <div class="ib-li ib-dislike">
                                            <a class="btn cm-btn-vote " data-id="{{ $reply->id }}" data-type="0">
                                                <i class="icofont-thumbs-down mr-1"></i><span class="value">{{ $reply->dislikes }}</span>
                                            </a>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>

                                    <div id="reply-{{ $reply->id }}" class="comment-input is-reply reply-block"
                                         style="display: none;">
                                        <div class="user-avatar">
                                            <img class="user-avatar-img" src="{{ userget()->avatar_url }}"
                                                 alt="{{ userget()->name }}">
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
                                                <input type="hidden" value="{{ $reply->userid }}" name="mention_id">
                                                <input type="hidden" value="{{ $comment->id }}" name="parent_id">
                                                <textarea class="form-control form-control-textarea" name="content"
                                                          maxlength="3000" placeholder="{{ L::_("Add a reply") }}"
                                                          required=""></textarea>
                                                <div class="ci-buttons">
                                                    <div class="ci-b-left">
                                                        <div class="cb-li"><a class="btn btn-sm btn-spoil"><i
                                                                        class="icofont-check mr-2"></i>{{ L::_("Spoil?") }}</a>
                                                        </div>
                                                    </div>
                                                    <div class="ci-b-right">
                                                        <div class="cb-li">
                                                            <a class="btn btn-sm btn-secondary btn-close-reply"
                                                               data-id="{{ $reply->id }}">{{ L::_('Close') }}</a>
                                                        </div>
                                                        <div class="cb-li">
                                                            <button class="btn btn-sm btn-warning ml-2">{{ L::_("Reply") }}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    @endforeach
</div>
