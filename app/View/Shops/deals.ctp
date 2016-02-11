<?php foreach ($deals as $data): ?>

    <?php if (!empty($data['Deal'])): ?>
    
        <?php foreach ($data['Deal'] as $d): ?>
        
<div style="margin-bottom: 20px;">
        
    <div style="display: inline-block; margin: 20px;">
        <?php echo $this->Html->link($this->Html->image('/files/deal/photo/' . $d['photo_dir'] . '/' . $d['photo'], array('alt' => $d['title'])), $d['link'], array('escape' => false, 'target' => '_blank')) ?>
    </div>
        
    <div style="display: inline-block; margin: 20px; vertical-align: top; width: 50%;">
        <h2><?php echo $d['title']; ?></h2>
        
        <hr />
        <br />
        
        <h4 style="width: 500px;"><?php echo $d['description']; ?></h4>
        
        <div style="float: left; margin: 20px; margin-left: 100px;">
            <p>PRICE</p>
            <h3>&#8369; <?php echo $d['price']; ?></h3>
        </div>
        
        <div style="float: right; margin: 20px; margin-right: 100px;">
            <p>SAVE</p>
            <h3><?php echo round(100 - $d['price'] / $d['original_price'] * 100) ?>%</h3>
        </div>
        
        <div class="clear-both"></div>
        
        <div style="float: left; width: 75%">
            <hr />
                <div style="float: left; width: 50%; text-align: center">
                    <h3><?php echo $d['clicks'] ?></h3>
                    <h1>CLICKS</h1>
                </div>
                <div style="float: left; width: 50%; text-align: center">
                    <h3><?php echo date('M d, Y H:i:s', strtotime($d['publish_until'])) ?></h3>
                    <h1>REMAINING</h1>
                </div>
            <hr />
        </div>
        
        <div style="float: right; margin: 12px;">
            <a class="view" href="<?php echo $d['link'] ?>" target="_blank">VIEW</a>
        </div>
        
    </div>
        
</div>
        
        <?php endforeach ?>
        
    <?php endif ?>
    
<?php endforeach ?>