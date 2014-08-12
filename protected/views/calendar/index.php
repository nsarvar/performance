<?php
/* @var $this CalendarController */
$this->pageTitle = Yii::app()->name;
$themePath = Yii::app()->theme->baseUrl;
$cs = Yii::app()->getClientScript();
$cs->registerCssFile($themePath . '/skin/css/calendar.min.css');
$cs->registerScriptFile($themePath . '/skin/js/underscore-min.js', CClientScript::POS_END);
$cs->registerScriptFile($themePath . '/skin/js/jstz.min.js', CClientScript::POS_END);
$cs->registerScriptFile($themePath . '/skin/js/language/uz-UZ.js', CClientScript::POS_END);
$cs->registerScriptFile($themePath . '/skin/js/calendar.js', CClientScript::POS_END);


?>

<ol class="breadcrumb">
    <li><a href="/"><?= __('Home') ?></a></li>
    <li><?= __('Calendar') ?></li>
</ol>

<div class="page-header">
    <div class="pull-right form-inline">
        <div class="btn-group">
            <button data-calendar-nav="prev" class="btn btn-default"><?= __('&lt;&lt; Prev') ?></button>
            <button data-calendar-nav="today" class="btn btn-default"><?= __('Today') ?></button>
            <button data-calendar-nav="next" class="btn btn-default"><?= __('Next &gt;&gt;') ?></button>
        </div>
        <div class="btn-group">

        </div>
        <div class="btn-group">
            <button data-calendar-view="year" class="btn btn-primary"><?= __('Year') ?></button>
            <button data-calendar-view="month" class="btn btn-primary active"><?= __('Month') ?></button>
            <button data-calendar-view="week" class="btn btn-primary"><?= __('Week') ?></button>
            <button data-calendar-view="day" class="btn btn-primary"><?= __('Day') ?></button>
        </div>
    </div>
    <h3>
        <i class="fa fa-calendar"></i> <?= __('Calendar') ?>
    </h3>
</div>
<div class="row">
    <div class="col col-md-12" style="padding-left: 100px">
        <div id='calendar'></div>
    </div>
</div>
<?php
Yii::app()->getClientScript()->registerScript("CalendarView", "calendarView('calendar')", CClientScript::POS_LOAD);
?>
<script type="text/javascript">
    var calendarView = function (id) {
        var options = {
            events_source: '<?=Yii::app()->createUrl('calendar/events')?>',
            view: 'month',
            tmpl_path: '<?=$themePath . '/skin/tmpls/'?>',
            tmpl_cache: true,
            language: 'uz-UZ',
            //day: '2013-03-12',
            onAfterEventsLoad: function (events) {
                if (!events) {
                    return;
                }
                /*var list = $('#eventlist');
                list.html('');

                $.each(events, function (key, val) {
                    $(document.createElement('li'))
                        .html('<a href="' + val.url + '">' + val.title + '</a>')
                        .appendTo(list);
                });*/
            },
            onAfterViewLoad: function (view) {
                $('.page-header h3').text(this.getTitle());
                $('.btn-group button').removeClass('active');
                $('button[data-calendar-view="' + view + '"]').addClass('active');
            },
            classes: {
                months: {
                    general: 'label'
                }
            }
        };

        var calendar = $('#' + id).calendar(options);

        $('.btn-group button[data-calendar-nav]').each(function () {
            var $this = $(this);
            $this.click(function () {
                calendar.navigate($this.data('calendar-nav'));
            });
        });

        $('.btn-group button[data-calendar-view]').each(function () {
            var $this = $(this);
            $this.click(function () {
                calendar.view($this.data('calendar-view'));
            });
        });

        $('#first_day').change(function () {
            var value = $(this).val();
            value = value.length ? parseInt(value) : null;
            calendar.setOptions({first_day: value});
            calendar.view();
        });

        $('#language').change(function () {
            calendar.setLanguage($(this).val());
            calendar.view();
        });

        $('#events-in-modal').change(function () {
            var val = $(this).is(':checked') ? $(this).val() : null;
            calendar.setOptions({modal: val});
        });
        $('#events-modal .modal-header, #events-modal .modal-footer').click(function (e) {
            //e.preventDefault();
            //e.stopPropagation();
        });
    }

</script>