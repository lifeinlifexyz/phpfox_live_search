{literal}
<script>
    $Behavior.initLiveSearch = function () {
        var searchForm = $('#header_search_form, #search-panel2');

        var spinner = '<div class="text-center">'
                        +'<i class="fa fa-spinner"></i>'
                    + '</div>';

        var box = '<div id="cm-live-search-box">'
                    + '<i class="fa fa-close"></i>' +
                    '<div class="ls-cont">'
                      + spinner
                    + '</div>'
                  +'</div>';

        if ($('#cm-live-search-box').length == undefined || !$('#cm-live-search-box').length) {
            $(box).appendTo(searchForm);
        }

        searchForm.find('input').off('keyup').on('keyup', function(){
            if ($(this).val().length > 1) {
                searchForm.find('#cm-live-search-box .ls-cont').html(spinner);
                searchForm.find('#cm-live-search-box').show();
                var url = PF.url.make('live-search');
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {q: $(this).val()},
                    success: function(html) {
                        searchForm.find('#cm-live-search-box .ls-cont').html(html);
                        $('.image_deferred:not(.built)').each(function() {
                            var t = $(this),
                                src = t.data('src'),
                                i = new Image();

                            t.addClass('built');
                            if (!src) {
                                t.addClass('no_image');
                                return;
                            }

                            t.addClass('has_image');
                            i.onerror = function(e, u) {
                                t.replaceWith('');
                            };
                            i.onload = function(e) {
                                t.attr('src', src);
                            };
                            i.src = src;
                        });
                        $('.image_load:not(.built)').each(function() {
                            var t = $(this),
                                src = t.data('src'),
                                i = new Image();

                            t.addClass('built');
                            if (!src) {
                                t.addClass('no_image');
                                return;
                            }

                            t.addClass('has_image');
                            i.onload = function(e) {
                                if (t.hasClass('parent-block')){
                                    var parentClass = t.data('apply');
                                    if (parentClass){
                                        $('#main .' + parentClass).css('background-image', 'url(' + src + ')');
                                    }
                                } else {
                                    t.css('background-image', 'url(' + src + ')');
                                }
                            };
                            i.src = src;
                        });
                    }
                });
            } else {
                searchForm.find('#cm-live-search-box').hide();
            }
        });

        searchForm.find('#cm-live-search-box .fa-close').off('click').on('click', function(){
            searchForm.find('#cm-live-search-box').hide();
        })
    }
</script>
{/literal}