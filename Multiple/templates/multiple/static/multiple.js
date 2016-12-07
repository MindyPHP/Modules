(function ($) {

    "use strict";

    /**
     * Описание объекта
     */
    var multiple = function () {
        return multiple.init.apply(this, arguments);
    };

    /**
     * Расширение объекта
     */
    $.extend(multiple, {
        /**
         * Настройки по умолчанию
         */
        options: {
            sortUrl: ''
        },
        /**
         * Элемент, над которым выполняются действия
         */
        element: undefined,
        /**
         * Инициализация
         * @param element
         * @param options
         */
        init: function (element, options) {
            if (element === undefined) return;

            this.element = $(element);

            this.id = this.element.attr('id');
            this.options = $.extend(this.options, options);

            this.bind();

            return this;
        },
        /**
         * "Навешиваем" события
         */
        bind: function () {
            var me = this;

            this.element.on('update', function (e, url) {
                var $this = $(this),
                    args = '',
                    requestPath = window.location.href,
                    delimiter = '';



                if (typeof(url) === 'string') {
                    var explodedUrl = url.split('?'),
                        explodedPath = requestPath.split('?');
                    if (explodedUrl.length > 1){
                        args = explodedUrl[explodedUrl.length-1];
                    }
                    if (explodedPath.length > 1){
                        delimiter = '&'
                    }else{
                        delimiter = '?';
                    }
                }

                var url_update = requestPath + delimiter + args;

                $.get(url_update, function (data) {
                    var $data = $('<div/>').append(data),
                        newList = $data.find('#' + me.id);

                    if (!newList.length) {
                        newList = $data.find('table.multiple-table');
                        $this.find('table.multiple-table').html(newList.html());
                    } else {
                        $this.html(newList.html());
                    }
                    me.initSortable();
                });
            });

            $(document).on('click', '#' + me.id +' .multiple-table th a', function (e) {
                e.preventDefault();
                var $this = $(this);
                $('#' + me.id).trigger('update', $this.attr('href'));
                return false;
            });

            $(document).on('click', '#' + me.id + ' .mmodal-multiple', function (e) {

                e.preventDefault();
                var $this = $(this);
                $this.mmodal({
                    width: $this.data('width'),
                    autoclose: true,
                    onSuccess: function(){
                        $('#' + me.id).trigger('update');
                    }
                });
                return false;
            });
        },
        initSortable: function() {
            var me = this;
            $('#' + me.id + ' .multiple-table.sortingColumn').find('tbody').sortable({
                axis: 'y',
                placeholder: "highlight",
                helper: function (e, ui) {
                    ui.children().each(function () {
                        var $this = $(this);
                        $this.width($this.width());
                    });
                    return ui;
                },
                update: function (event, ui) {
                    var $to = $(ui.item),
                        $prev = $to.prev(),
                        $next = $to.next();

                    var data = $(this).sortable('toArray', {
                        attribute: 'data-pk'
                    });

                    $.ajax({
                        data: {
                            models: data,
                            pk: $to.data('pk'),
                            insertAfter: $prev.data('pk'),
                            insertBefore: $next.data('pk'),
                            action: 'sorting'
                        },
                        type: 'POST',
                        url: me.options.sortUrl,
                        success: function (data) {
                            $('#' + me.id + '-form' ).replaceWith(data);
                        }
                    });
                }
            }).disableSelection();
        }
    });

    /**
     * Инициализация функции объекта для jQuery
     */
    return $.fn.multiple = function (options) {
        var each = jQuery.extend({}, multiple);
        return each.init(this, options);
    };
})($);

$(function(){
    $(document).on('submit', '[data-pseudo-form]', function () {
        var $this = $(this);
        $.ajax({
            'type': 'POST',
            'data': $this.find("input[type='checkbox'][name='models[]'], select[name=action]").serialize(),
            'url': $this.data("action"),
            'success': function (data) {
                try {
                    data = $.parseJSON(data);
                } catch (e) {
                }
                if (data.refresh) {
                    location.reload();
                }
                if (data.redirect) {
                    location.href = data.redirect;
                }
                $('#' + $this.data('list')).trigger('update');
            }
        });
    });

    $(document).off('click', '[data-form-submit]').on('click', '[data-form-submit]', function (e) {
        e.preventDefault();
        var $this = $(this),
            pseudoForm = $this.closest('[data-pseudo-form]');
        pseudoForm.trigger('submit');
        return false;
    });
});