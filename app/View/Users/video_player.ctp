<?php echo $this->Html->script('jwplayer') ?>

<div id="myElement">Loading the player...</div>

<?php $filename = pathinfo($data['Video']['video']) ?>

<script type="text/javascript">
    jwplayer("myElement").setup({
        file: "<?php echo '/files/video/video/' . $data['Video']['video_dir'] . '/' . $data['Video']['video'] ?>",
        image: "<?php echo '/files/video/video/' . $data['Video']['video_dir'] . '/' . $filename['filename'] ?>.jpg"
    });
</script>