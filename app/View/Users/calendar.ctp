<?php echo $this->Html->css("fullcalendar") ?>
<?php echo $this->Html->css("fullcalendar.print") ?>

<?php echo $this->Html->script("fullcalendar.min") ?>

<?php echo $this->Html->scriptBlock("
    $(document).ready(function() {
        $('#calendar').fullCalendar({
            events: []
        });
    });
") ?>

<style>
    #calendar {
        width: auto;
        margin: 0 auto;
    }
</style>

<div id='calendar'></div>
