/* globals jQuery, super_marketplace_i18n, ajaxurl */
"use strict";
(function() { // Hide scope, no $ conflict

    jQuery(document).ready(function ($) {
    
        var $doc = $(document);

        $(window).bind('tb_unload', function () {
            $('.super-add-item > *:not(.super-msg)').show();
            $('.super-add-item .super-msg').html('').removeClass('super-error').removeClass('super-success');
        });

        $doc.on('click', '.star-rating > .star', function(){
            var $this = $(this);
            if(!$this.parents('.plugin-card:eq(0)').hasClass('owned')){
                alert('You do not own this form, rating is disabled!');
            }else{
                if(!$this.parent().hasClass('submitted')){
                    $this.parent().addClass('submitted');
                    var $index = $this.index();
                    var $id = $this.parents('.plugin-card:eq(0)').data('id');
                    $.ajax({
                        type: 'post',
                        url: ajaxurl,
                        data: {
                            action: 'super_marketplace_rate_item',
                            item: $id,
                            rating: $index
                        },
                        success: function (result) {
                            var $result = jQuery.parseJSON(result);
                            if($result.error!==false){
                                alert($result.msg);
                            }else{
                                var $total_ratings = $this.parents('.column-rating:eq(0)').children('.num-ratings').text();
                                $total_ratings = $total_ratings.replace('(','').replace(')','');
                                $total_ratings = parseFloat($total_ratings) + 1;
                                $this.parents('.column-rating:eq(0)').children('.num-ratings').text('('+$total_ratings+')');
                                $this.parent().children('.star').each(function(){
                                    if($(this).index() <= $index){
                                        $(this).attr('class', 'star star-full').attr('data-old-class', 'star star-full');
                                    }else{
                                        $(this).attr('class', 'star star-empty').attr('data-old-class', 'star star-empty');
                                    }
                                });
                            }
                        }
                    });
                }
            }
        });
        $doc.on('mouseover', '.star-rating > .star', function(){
            var $this = $(this);
            if(!$this.parent().hasClass('submitted')){
                var $index = $this.index();
                $this.parent().children('.star').each(function(){
                    if($(this).index() <= $index){
                        if(typeof $(this).attr('data-old-class')==='undefined'){
                            $(this).attr('data-old-class', $(this).attr('class'));
                        }
                        $(this).attr('class', 'star star-full');
                    }else{
                        if($(this).attr('data-old-class')!=='undefined'){
                            $(this).attr('class', 'star star-empty');
                        }
                    }
                });
            }
        });
        $doc.on('mouseleave', '.column-rating', function(){
            if(!$(this).children('.star-rating').hasClass('submitted')){
                $(this).find('.star-rating > .star').each(function(){
                    if(typeof $(this).attr('data-old-class')!=='undefined'){
                        $(this).attr('class', $(this).attr('data-old-class'));
                    }
                });
            }
        });

        $doc.on('click', '.generated-tags > span', function(){
            $(this).remove();
            var $tags = '';
            var $counter = 0;
            $('.generated-tags > span').each(function(){
                if($counter===0){
                    $tags += $(this).text();
                }else{
                    $tags += ', '+$(this).text();
                }
                $counter++;
            });
            $('.super-add-item input[name="tags"]').val($tags);
        });

        $doc.on('keyup keydown', '.super-add-item input[name="tags"]',function(){
            var $value = $(this).val();
            var $tags = $value.split(/[ ,]+/);
            var $tags_html = '';
            var $counter = 0;
            var $duplicate_tags = {};
            $.each($tags,function(index,value){
                if(typeof $duplicate_tags[value]==='undefined'){
                    $counter++;
                    if($counter<=5){
                        value = value.replace(/ /g,'');
                        if( (value!=='') && (value.length>1) ) {
                            $tags_html += '<span>'+value+'</span>';
                        }
                    }
                }
                $duplicate_tags[value] = value;
            });
            $('.super-add-item .generated-tags').html($tags_html);
        });

        $doc.on('click', '.super-marketplace .purchase-now', function(){
            var $this = $(this);
            if(!$this.hasClass('button-disabled')){
                var $old_html = $this.html();
                $this.html('Loading...').addClass('button-disabled');
                var $id = $this.parents('.plugin-card:eq(0)').data('id');
                $.ajax({
                    type: 'post',
                    url: ajaxurl,
                    data: {
                        action: 'super_marketplace_purchase_item',
                        item: $id
                    },
                    success: function (result) {
                        window.location.href = "https://f4d.nl/super-forms/?api=marketplace-purchase-item&item="+$id+"&user="+result+"&return-url="+window.location.href;
                    },
                    error: function () {
                        $this.html($old_html);
                        alert(super_marketplace_i18n.connection_lost);
                    }
                });
            }
        });
        

        $doc.on('click', '.super-marketplace .install-now', function(){
            var $this = $(this);
            if(!$this.hasClass('button-disabled')){
                $this.html('Installing...').addClass('button-disabled');
                var $parent = $this.parents('.plugin-card:eq(0)');
                var $title = $parent.find('input[name="title"]').val();
                var $elements = $parent.find('textarea[name="_super_elements"]').val();
                var $settings = $parent.find('textarea[name="_super_form_settings"]').val();
                var $import = $parent.find('textarea[name="_super_import"]').val();
                $.ajax({
                    type: 'post',
                    url: ajaxurl,
                    data: {
                        action: 'super_marketplace_install_item',
                        title: $title,
                        elements: $elements,
                        settings: $settings,
                        import: $import
                    },
                    success: function (result) {
                        window.location.href = "admin.php?page=super_create_form&id="+result;
                    },
                    error: function () {
                        alert(super_marketplace_i18n.connection_lost);
                    }
                });
            }
        });

        $doc.on('click', '.super-add-item .super-submit', function(){
            var $this = $(this);
            var $old_html = $this.html();
            var $error = false;
            
            $('.super-add-item label').removeClass('error');
            var $field = $('select[name="forms"]');
            if($field.val()===''){
                $error = true;
                $field.parents('label:eq(0)').addClass('error');
            }
            $field = $('input[name="price"]');
            if($field.val()>10){
                $error = true;
                $field.parents('label:eq(0)').addClass('error');
            }
            if($('input[name="price"]').val()>0){
                $field = $('input[name="paypal"]');
                if (($field.val().length < 4) || (!/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/.test($field.val()))) {
                    $error = true;
                    $field.parents('label:eq(0)').addClass('error');
                }
            }
            $field = $('input[name="email"]');
            if (($field.val().length < 4) || (!/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/.test($field.val()))) {
                $error = true;
                $field.parents('label:eq(0)').addClass('error');
            }

            if($error===false){
                var $form = $('select[name="forms"]').val();
                var $price = $('input[name="price"]').val();
                var $paypal = $('input[name="paypal"]').val();
                var $email = $('input[name="email"]').val();
                var $tags = {};
                $('.generated-tags > span').each(function(){
                    $tags[$(this).text()] = $(this).text();
                });
                $this.html('Loading...');
                $.ajax({
                    type: 'post',
                    url: ajaxurl,
                    data: {
                        action: 'super_marketplace_add_item',
                        form: $form,
                        price: $price,
                        paypal: $paypal,
                        email: $email,
                        tags: $tags
                    },
                    success: function (result) {
                        var $result = jQuery.parseJSON(result);
                        var $msg = $('.super-add-item .super-msg');
                        if($result.error===true){
                            $msg.removeClass('super-success').addClass('super-error').html($result.msg);
                        }else{
                            if($result.redirect){
                                 window.location.href = $result.redirect;
                            }else{
                                $('.super-add-item > *:not(.super-msg)').hide();
                                $msg.removeClass('super-error').addClass('super-success').html($result.msg);
                            }
                        }
                    },
                    complete: function(){
                        $this.html($old_html);
                    },
                    error: function () {
                        alert(super_marketplace_i18n.connection_lost);
                    }
                });
            }

        });

        $doc.on('click', '.report', function(){
            var $this = $(this);
            if(!$this.hasClass('reported')){
                var $reason = prompt(super_marketplace_i18n.reason+':', '');
                if($reason.length > 2){
                    var $id = $this.parents('.plugin-card:eq(0)').data('id');
                    $.ajax({
                        type: 'post',
                        url: ajaxurl,
                        data: {
                            action: 'super_marketplace_report_abuse',
                            id: $id,
                            reason: $reason
                        },
                        success: function () {
                            $this.addClass('reported').html('Reported!');
                        },
                        error: function () {
                            alert(super_marketplace_i18n.connection_lost);
                        }
                    });
                }else{
                    alert(super_marketplace_i18n.reason_empty);
                }
            }
        });

    });

})(jQuery);