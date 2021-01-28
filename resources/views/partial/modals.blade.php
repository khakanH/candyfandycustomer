<div id="LoadingModal" class="modal" data-backdrop="false" data-keyboard="true" style="height: 100%; background: rgba(0,0,0,0.6);">
          <center><img id="loading_gif" style="margin-top: 250px;" width="70" height="70" src="<?php echo config('app.img_url') ?>gif_candy.png"></center>
</div>

<script type="text/javascript">
	$(function() {
    var loading = $('#loading_gif'),
        degree = 360,
        timer;
    
    function rotate() {    
        loading.css({ transform: 'rotate(' + degree + 'deg)'});
        timer = setTimeout(function() {
            --degree;
            rotate();
        },5); //lower this to increase speed
    }
    
    rotate();
});
</script>