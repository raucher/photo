<div class="row-fluid">
    <div class="hero-unit">
        <h1>Welcome!</h1>
        <p>Dear visitor, this site was made in the training purposes!</p>
        <p>Use it in production at your own risk, good luck ;)</p>
    </div>
    <h2>Overall</h2>
    <div class="well summary">
        <ul>
            <li class="summary-item">
                    <span class="count"><?php echo $n = $mediaCount ?></span>
                    <?php echo $n%10==1&&$n%100!=11?'Media': 'Medias' ?>
            </li>
            <li class="summary-item">
                    <span class="count"><?php echo $n = $galleryCount ?></span>
                    <?php echo $n%10==1&&$n%100!=11?'Gsllery': 'Galleries' ?>
            </li>
            <li class="summary-item last">
                    <span class="count"><?php echo $n = $articleCount ?></span>
                    <?php echo $n%10==1&&$n%100!=11?'Article': 'Articles' ?>
            </li>
        </ul>
    </div> <!--end: .well.summary-->
</div>